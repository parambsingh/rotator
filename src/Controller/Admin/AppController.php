<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $responseCode = SUCCESS_CODE;
    public $responseMessage = "";
    public $responseData = [];
    public $currentPage = 0;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        //$this->loadComponent('Csrf');

        $this->loadComponent('Auth', [
            'storage'       => 'Session',
            'authenticate'  => [
                'Form' => [
                    'userModel' => 'Admins',
                    'fields'    => ['username' => 'email', 'password' => 'password']
                ],
            ],
            'loginAction'   => ['controller' => 'Admins', 'action' => 'login'],
            'loginRedirect' => ['controller' => 'Admins', 'action' => 'dashboard']
        ]);

        if ($this->Auth->user()) {
            $this->set('authUser', $this->Auth->user());
            $this->viewBuilder()->setLayout('admin');
            $this->searchConditions();
        } else {
            $this->viewBuilder()->setLayout('admin_login');
        }

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }


    public function beforeFilter(EventInterface $event) {
        //$this->getEventManager()->off($this->Csrf);
        $user = $this->Auth->user();
        if ($user) {
            if ($this->request->getParam('prefix') == 'admin') {
                if ($user['role'] != "Admin") {
                    return $this->redirect(SITE_URL);
                }
            }
        }
    }


    public function responseFormat() {
        $returnArray = [
            "code"    => $this->responseCode,
            "message" => $this->responseMessage,
        ];
        if ($this->currentPage > 0) {
            $this->responseData['currentPage'] = $this->currentPage;
        }

        if (isset($this->responseData['total'])) {
            $this->responseData['pages'] = ceil($this->responseData['total'] / PAGE_LIMIT);
        }

        $returnArray['data'] = !empty($this->responseData) ? $this->responseData : ['message' => 'Data not found'];

        return json_encode($returnArray);
    }

    public function getErrorMessage($errors, $show = false, $field = []) {
        if (is_array($errors)) {
            foreach ($errors as $key => $error) {
                $field[$key] = "[" . $key . "]";
                $this->getErrorMessage($error, $show, $field);
                break;
            }
        } else {
            $this->responseMessage = ($show) ? implode(" >> ", $field) . " >> " . $errors : $errors;
        }
    }

    public function getCurrentPage() {
        $this->currentPage = empty($this->request->getQuery('page')) ? 1 : $this->request->getQuery('page');
        return $this->currentPage;
    }

    public function searchConditions() {

        if (!empty($this->request->getQuery('keyword'))) {

            $keyString = strtolower($this->request->getQuery('keyword'));
            $matches = explode(",", $this->request->getQuery('match'));
            $conditions = [];
            foreach ($matches as $match) {
                $conditions['OR']["LOWER(" . $match . ") LIKE"] = "%$keyString%";
            }
            $this->paginate['conditions'] = $conditions;

            $this->set('search_key', $keyString);
        }
    }

    public function assignNewPosition($userId) {
        $this->loadModel('UsersPositions');

        //Get Max Position Order
        $maxUserPosition = $this->UsersPositions->find('all')->select(['UsersPositions__max_position_order' => 'MAX(position_order)'])->first();
        $maxPositionOrder = empty($maxUserPosition) ? 0 : $maxUserPosition['max_position_order'];

        $userPosition = $this->UsersPositions->newEmptyEntity();

        $userPosition->user_id = $userId;
        $userPosition->position_no = 1;
        $userPosition->position_order = $maxPositionOrder + 1;
        $userPosition->lead_limit = 0;

        $userPosition->subscription_status = "Active";
        $userPosition->subscription_id = 1;

        $this->UsersPositions->save($userPosition);
    }
}
