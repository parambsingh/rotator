<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use LogMeIn\GoToWebinar\Client;


/**
 * Webinars Controller
 *
 * @method \App\Model\Entity\Webinar[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WebinarsController extends AppController {

    public function initialize(): void {
        parent::initialize();
        $this->loadModel('WebinarAccounts');
    }

    public function index() {
        $webinarAccount = $this->WebinarAccounts->find('all')->first();

        $this->set(compact('webinarAccount'));
    }

    public function settings() {
        $webinarAccount = $this->WebinarAccounts->find('all')->first();

        $this->set(compact('webinarAccount'));
    }

    public function saveSettings() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is('post')) {
            $webinarAccount = $this->WebinarAccounts->find('all')->first();

            if (empty($webinarAccount)) {
                $webinarAccount = $this->WebinarAccounts->newEmptyEntity();
            }

            $webinarAccount->client_id = $this->request->getData('client_id');
            $webinarAccount->client_secret = $this->request->getData('client_secret');

            if ($this->WebinarAccounts->save($webinarAccount)) {
                $this->responseCode = SUCCESS_CODE;
                $this->responseData['webinarAccount'] = $webinarAccount;
            }

        }

        echo $this->responseFormat();
        exit;
    }

    public function getAccountDetail() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $this->responseMessage = "Something went wrong, please try again.";
        $this->loadModel('WebinarAccounts');
        $webinarAccount = $this->WebinarAccounts->find('all')->first();

        //Get Account Detail
        $url = "https://api.getgo.com/oauth/v2/token";
        $headers = [
            "Authorization: Basic " . base64_encode($webinarAccount->client_id . ':' . $webinarAccount->client_secret),
            "Accept:application/json",
            "Content-Type: application/x-www-form-urlencoded",
        ];

        $params = [
            'redirect_uri' => SITE_URL . 'users/webinar',
            'grant_type'   => 'authorization_code',
            'code'         => $webinarAccount->code
        ];


        $response = $this->curlPost($url, $params, $headers);

        $resp = json_decode($response, true);

        if (!empty($resp['access_token'])) {
            $webinarAccount = $this->WebinarAccounts->find('all')->first();
            $webinarAccount->account_json = $response;
            $webinarAccount->status = true;
            $this->WebinarAccounts->save($webinarAccount);

            $this->responseCode = SUCCESS_CODE;
            $this->responseData['webinarAccount'] = $webinarAccount;
            $this->responseMessage = "Successfully Verified.";
        }

        echo $this->responseFormat();
        exit;
    }

    public function curlGet($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $serverOutput = curl_exec($ch);

        curl_close($ch);

        return $serverOutput;
    }

    public function curlPost($url, $params, $headers) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $serverOutput = curl_exec($ch);

        if ($serverOutput === false) {
            echo('Error performing rmv lookup: ' . curl_errno($ch) . ' - ' . curl_error($ch) . ' (Message ID: ' . basename(__FILE__) . '-' . __LINE__ . ')');
        }

        curl_close($ch);

        return $serverOutput;
    }

    public function getWebinars() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $this->loadModel('WebinarAccounts');
        $webinarAccount = $this->WebinarAccounts->find('all')->first();

        $resp = json_decode($webinarAccount->account_json, true);

        $client = new Client($resp['access_token'], $resp);

        $get = $client->createRequest('GET', "organizers/" . $resp['organizer_key'] . "/webinars")->execute();

        $webinars = $get->getDecodedBody();

        $this->responseCode = SUCCESS_CODE;
        $this->responseData['webinars'] = $webinars;
        echo $this->responseFormat();
        exit;
    }


}
