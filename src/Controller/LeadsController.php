<?php
declare(strict_types=1);

namespace App\Controller;

use \DrewM\MailChimp\MailChimp;

/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeadsController extends AppController {

    public function initialize(): void {
        parent::initialize();
        $allowedActions = [
            'wpLead',
            'mcSubscribe'
        ];
        $this->Auth->allow($allowedActions);

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->paginate['contain'] = ['Images'];
        $leads = $this->paginate($this->Leads->find('all')->where(['Leads.user_id' => $this->authUserId]));

        $this->set(compact('leads'));
    }

    /**
     * View method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $lead = $this->Leads->get($id, [
            'contain' => ['Images'],
        ]);

        $this->set(compact('lead'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $lead = $this->Leads->newEmptyEntity();
        if ($this->request->is('post')) {
            $lead = $this->Leads->patchEntity($lead, $this->request->getData());
            $lead->user_id = $this->authUserId;
            if ($this->Leads->save($lead)) {
                $this->Flash->success(__('The lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lead could not be saved. Please, try again.'));
        }

        $states = $this->Leads->States->find('list')->where(['States.status' => true])->order(['States.name' => 'ASC'])->toArray();
        $cities = [];
        $this->set(compact('lead', 'states', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $lead = $this->Leads->find('all')->contain(['Images'])->where(['Leads.id' => $id, 'Leads.user_id' => $this->authUserId])->first();
        if (empty($lead)) {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['action' => 'index']);
        } else {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $lead = $this->Leads->patchEntity($lead, $this->request->getData());
                if ($this->Leads->save($lead)) {
                    $this->Flash->success(__('The lead has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The lead could not be saved. Please, try again.'));
            }

            $states = $this->Leads->States->find('list')->where(['States.status' => true])->order(['States.name' => 'ASC'])->toArray();
            if (empty($lead->state_id)) {
                $cities = [];
            } else {
                $cities = $this->Leads->Cities->find('list')->where(['Cities.state_id' => $lead->state_id,
                                                                     'Cities.status'   => true])->order(['Cities.name' => 'ASC'])->toArray();
            }

            $this->set(compact('lead', 'states', 'cities'));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $lead = $this->Leads->get($id);
        if ($this->Leads->delete($lead)) {
            $this->Flash->success(__('The lead has been deleted.'));
        } else {
            $this->Flash->error(__('The lead could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isUniqueEmail($id = null) {
        $this->autoRender = false;
        $email = $this->request->getQuery('email');
        $conditions = [
            'Leads.user_id' => $this->authUserId,
            'Leads.email'   => $email,
        ];

        if ($id !== null) {
            $conditions['Leads.id !='] = $id;
        }
        $count = $this->Leads->find()->where($conditions)->count();
        echo ($count) ? "false" : "true";
        exit;
    }


    public function wpLead() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        $this->loadComponent('RapidFunnel');
        $this->loadModel('LeadLogs');

        $slot = $this->getAvailableSlot();

        $apiResponseData = [
            'response' => [
                'message' => 'Not Send to RF',
                'status'  => 400
            ]
        ];

        $status = "Error";
        $requestData = $this->request->getData();

        $lead = $this->Leads->find()->where(['Leads.email' => $requestData['email']])->first();

        $distributorId = 181405;
        if (empty($lead)) {
            $lead = $this->Leads->newEmptyEntity();
            if ($this->request->is('post')) {
                $lead = $this->Leads->patchEntity($lead, $this->request->getData());
                $lead->status = true;
                $lead->user_id = $slot->user_id;
                if ($this->Leads->save($lead)) {
                    $this->responseCode = SUCCESS_CODE;
                    $this->responseMessage = 'The lead has been saved.';
                    $status = "Saved";

                    //Sending TO Rapid Funnel
                    $distributorId = $slot->user->distributor_id;
                    $params = [
                        'userId'    => ROTATOR_TEST_MODE ? 181405 : $distributorId,
                        'firstName' => empty($requestData['first_name']) ? 'NA' : $requestData['first_name'],
                        'lastName'  => empty($requestData['last_name']) ? 'NA' : $requestData['last_name'],
                        'email'     => empty($requestData['email']) ? 'na@na.com' : $requestData['email'],
                        'phone[]'   => empty($requestData['phone']) ? 'NA' : $requestData['phone'],
                        'company'   => empty($requestData['company']) ? 'NA' : $requestData['company'],
                        'note'      => empty($requestData['note']) ? 'NA' : $requestData['note'],
                        //'campaignId' => 564, // 564, 560
                    ];

                    $requestData['API_PARAMS'] = $params;
                    $requestData['LEAD_USER_ID'] = $slot->user_id;

                    $url = "https://apiv2.rapidfunnel.com/v1/contacts";

                    $this->loadComponent('RapidFunnel');
                    $apiResponseData = $this->RapidFunnel->postRf($url, $params);

                } else {
                    $errors = $lead->getErrors();
                    $this->responseData['errors'] = $errors;
                    $this->responseMessage = 'The lead could not be saved. Please, try again.';
                }
            }
        } else {

            $this->responseMessage = 'The lead already exists.';
            $this->responseCode = ALREADY_EXIST;
            $status = "Already Exists";
        }


        $leadLog = $this->LeadLogs->newEmptyEntity();

        //Test
        $requestData['DISTRIBUTED_ID'] = $distributorId;
        $requestData['TEST_ENTRY'] = ROTATOR_TEST_MODE;

        $leadLog->distributor_id = $distributorId;
        $leadLog->lead_id = $lead->id;
        $leadLog->first_name = $lead->first_name;
        $leadLog->last_name = $lead->last_name;
        $leadLog->email = $lead->email;
        $leadLog->ip = $requestData['ip'];
        $leadLog->lead_from = $requestData['lead_from'];
        $leadLog->request_json = json_encode($requestData);
        $leadLog->response_json = is_array($apiResponseData) ? json_encode($apiResponseData) : $apiResponseData;
        $leadLog->status = $status;

        if ($this->LeadLogs->save($leadLog)) {
            //Saved
        } else {
            //pr($leadLog->getErrors());
        }

        try {
            if (is_string($apiResponseData)) {
                $apiResponse = json_decode($apiResponseData, true);
            } else {
                $apiResponse['response']['contactId'] = empty($lead) ? 0 : $lead->rf_contact;
            }
        } catch (\Exception $e) {
            $apiResponse['response']['status'] = 520;
            $apiResponse['response']['contactId'] = empty($lead) ? 0 : $lead->rf_contact;
        }

        //Update User Position as filled
        if (!empty($apiResponse['response'])) {
            if ($status == "Saved" && $apiResponse['response']['status'] == 200) {
                $lead = $this->Leads->find('all')->where(['id' => $lead->id])->first();

                $lead->rf_contact = $apiResponse['response']['contactId'];

                $this->Leads->save($lead);

                $this->setSlotAsOccupied($slot, $lead);
            }
        }

        $this->responseData['rf_contact_id'] = 181405;
        $this->responseData['rf_user_id'] = $distributorId;

        if ($status != "Error") {
            $savedLead = $this->Leads->find()->contain(['Users'])->where(['Leads.id' => $lead->id])->first();

            $this->responseData['rf_contact_id'] = $savedLead->rf_contact;
            $this->responseData['rf_user_id'] = ROTATOR_TEST_MODE ? 181405 : $savedLead->user->distributor_id;

            try {
                $this->mcSubscribe($savedLead->id);
            } catch (\Exception $e) {
                //Do Nothing
            }

            $options = [
                'layout'      => 'reserve_spot',
                'emailFormat' => 'both',
                'template'    => 'reserve_lead_spot',
                'to'          => !EMAIL_TEST_MODE ? ADMIN_EMAIL : $savedLead->email,
                'subject'     => " Reserve Your Spot",
                'from'        => [LEAD_FROM_EMAIL => LEAD_FROM_EMAIL_TITLE],
                'sender'      => [LEAD_FROM_EMAIL => LEAD_FROM_EMAIL_TITLE],
                'viewVars'    => [
                    'contactFirstName' => $savedLead->first_name,
                    'distributorName'  => $savedLead->user->name,
                    'distributorPhone' => $savedLead->user->phone,
                    'url'              => "https://nulifeinfo.com/res/16933/" . $this->responseData['rf_user_id'] . "/" . $savedLead->rf_contact . "?source=web",
                ]
            ];

            $this->loadComponent('EmailManager');
            try {
                $this->EmailManager->sendEmail($options);

                $options = [
                    'layout'      => 'reserve_spot',
                    'emailFormat' => 'both',
                    'template'    => 'water_report',
                    'to'          => !EMAIL_TEST_MODE ? ADMIN_EMAIL : $savedLead->email,
                    'subject'     => "Water Report " . LEAD_FROM_EMAIL_TITLE,
                    'from'        => [LEAD_FROM_EMAIL => LEAD_FROM_EMAIL_TITLE],
                    'sender'      => [LEAD_FROM_EMAIL => LEAD_FROM_EMAIL_TITLE],
                    'viewVars'    => [
                        'contactFirstName' => $savedLead->first_name,
                        'distributorName'  => $savedLead->user->name,
                        'distributorPhone' => $savedLead->user->phone,
                    ]
                ];

                $this->EmailManager->sendEmail($options);

            } catch (\Error $e) {
                //Something Went Wrong
            }
        }

        echo $this->responseFormat();
        exit;
    }

    public function getAvailableSlot() {
        $this->loadModel('UsersPositions');

        //To Restart the complete round
        $activePositions = $this->UsersPositions->find('all')
            ->where([
                'UsersPositions.subscription_status' => 'Active',
            ])
            ->count();

        $occupiedPositions = $this->UsersPositions->find('all')
            ->where([
                'UsersPositions.subscription_status' => 'Active',
                'UsersPositions.slot_status'         => 'occupied',
                'UsersPositions.occupied_leads >= lead_limit',
            ])
            ->count();

        //if all positions occupied
        if ($activePositions == $occupiedPositions) {
            //Update all for waiting
            $this->UsersPositions->updateAll([
                'slot_status'    => 'waiting',
                'occupied_leads' => 0,
            ], [
                'subscription_status' => 'Active',
            ]);
        }


        //To check if round completed
        $waitingPositions = $this->UsersPositions->find('all')
            ->where([
                'UsersPositions.subscription_status' => 'Active',
                'UsersPositions.slot_status'         => 'waiting'
            ])
            ->count();

        //if all positions occupied
        if ($waitingPositions <= 0) {
            //Update all for waiting
            $this->UsersPositions->updateAll([
                'slot_status' => 'waiting'
            ], [
                'subscription_status' => 'Active',
                'occupied_leads < lead_limit',
            ]);
        }

        $slot = $this->UsersPositions->find('all')
            ->contain(['Users'])
            ->where([
                'UsersPositions.subscription_status' => 'Active',
                'UsersPositions.slot_status'         => 'waiting',
                'UsersPositions.occupied_leads < UsersPositions.lead_limit',
            ])
            ->order(['UsersPositions.position_order' => 'ASC'])
            ->first();

        return $slot;
    }

    public function setSlotAsOccupied($slot, $lead) {
        $this->loadModel('UsersPositions');
        $this->loadModel('RotatorLoops');
        $waitingPositions = $this->UsersPositions->find('all')->where(['UsersPositions.subscription_status' => 'Active', 'UsersPositions.slot_status' => 'waiting'])->count();


        $this->UsersPositions->updateAll([
            'occupied_leads = occupied_leads + 1',
        ], ['id' => $slot->id]);


//        $currentPositions = $this->UsersPositions->find('all')->where(['UsersPositions.id' => $slot->id])->first();
//        if ($currentPositions->occupied_leads == $currentPositions->lead_limit) {
        $this->UsersPositions->updateAll([
            'slot_status' => 'occupied',
        ], ['id' => $slot->id]);
        //}

        $rotatorLoopMax = $this->RotatorLoops->find('all')->select(['RotatorLoops__max_round_no' => 'MAX(round_no)'])->first();

        $roundNo = empty($rotatorLoopMax['max_round_no']) ? 1 : $rotatorLoopMax['max_round_no'];

        if ($waitingPositions <= 1) {
            $roundNo = $roundNo + 1;
        }

        $rotatorLoop = $this->RotatorLoops->newEmptyEntity();

        $rotatorLoop->round_no = $roundNo;
        $rotatorLoop->user_position_id = $slot->id;
        $rotatorLoop->lead_id = $lead->id;
        $rotatorLoop->lead_status = "Saved";

        $this->RotatorLoops->save($rotatorLoop);

    }

    //TO update the lead status and webinar information
    public function wpUpdateLead() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        $this->loadModel('LeadLogs');

        $slot = $this->getAvailableSlot();

        $apiResponseData = [
            'response' => [
                'message' => 'Not Send to RF',
                'status'  => 400
            ]
        ];

        $status = "Error";
        $requestData = $this->request->getData();
        $lead = $this->Leads->find()->where(['Leads.email' => $requestData['email']])->first();


        if (!empty($lead)) {
            if ($this->request->is('post')) {
                $fieldsToUpdate = ['lead_status', 'go_to_webinar_id', 'go_to_webinar_title', 'is_webinar_regiatered'];
                foreach ($fieldsToUpdate as $field) {
                    if (!empty($requestData[$field])) {
                        $lead->{$field} = $requestData[$field];
                    }
                }
                if ($this->Leads->save($lead)) {
                    $this->responseCode = SUCCESS_CODE;
                    $this->responseMessage = 'The lead has been updated.';
                    $status = "Updated";

                    //Sending TO Rapid Funnel
                } else {
                    $errors = $lead->getErrors();
                    $this->responseData['errors'] = $errors;
                    $this->responseMessage = 'The lead could not be updated. Please, try again.';
                }

                $leadLog = $this->LeadLogs->newEmptyEntity();

                //Test
                $leadLog->distributor_id = $lead->user_id;
                $leadLog->lead_id = $lead->id;
                $leadLog->first_name = $lead->first_name;
                $leadLog->last_name = $lead->last_name;
                $leadLog->email = $lead->email;
                $leadLog->ip = $requestData['ip'];
                $leadLog->lead_from = $requestData['lead_from'];
                $leadLog->request_json = json_encode($requestData);
                $leadLog->response_json = ['RF API not called, only lead status updated.'];
                $leadLog->status = $status;

                if ($this->LeadLogs->save($leadLog)) {
                    //Saved
                } else {
                    pr($leadLog->getErrors());
                }
            }
        } else {
            $this->responseMessage = 'The lead does not exist.';
        }


        echo $this->responseFormat();
        exit;
    }

    public function mcSubscribe($leadId, $slug = "nulife-leads") {
        $this->loadModel('McDetails');

        $mc = $this->McDetails->find()->where(['slug' => $slug])->first();
        $lead = $this->Leads->find()->contain(['Users'])->where(['Leads.id' => $leadId])->first();
        $mcFields = json_decode($mc->merged_fields_json, true);
        $mcMergeFields = json_decode($mc->mc_merge_fields, true);

        $MailChimp = new MailChimp($mc->api_key);

        $finalFields = [];
        $mergeFields = [];


        foreach ($mcMergeFields as $field) {
            $mergeFields[$field['tag']] = ($field['type'] == "text") ? "NA" : 1;
        }


        foreach ($mcFields as $field => $match) {
            switch ($field) {
                case "email":
                    {
                        $mergeFields[$match] = $lead->email;
                        break;
                    }
                case "rf_distributor_id":
                    {
                        $mergeFields[$match] = $lead->user->distributor_id;
                        break;
                    }
                case "rf_contact_id":
                    {
                        $mergeFields[$match] = $lead->rf_contact;
                        break;
                    }
                case "phone":
                    {
                        $mergeFields[$match] = $lead->phone;
                        break;
                    }

                case "first_name":
                    {
                        $mergeFields[$match] = empty($lead->first_name) ? "NA" : $lead->first_name;
                        break;
                    }
                case "last_name":
                    {
                        $mergeFields[$match] = empty($lead->last_name) ? "NA" : $lead->last_name;
                        break;
                    }
                case "address":
                    {
                        $mergeFields[$match] = empty($lead->address) ? "NA" : $lead->address;
                        break;
                    }
                case "city":
                    {
                        $mergeFields[$match] = empty($lead->city) ? "NA" : $lead->city;
                        break;
                    }
                case "state":
                    {
                        $mergeFields[$match] = empty($lead->state) ? "NA" : $lead->state;
                        break;
                    }
                case "zip":
                    {
                        $mergeFields[$match] = empty($lead->zip) ? "NA" : $lead->zip;
                        break;
                    }

            }
        }


        $finalFields['status'] = "subscribed";
        $finalFields['email_address'] = $lead->email;
        $finalFields['merge_fields'] = $mergeFields;

        $result = $MailChimp->post("lists/" . $mc->list_id . "/members", $finalFields);

        return true;
    }

}