<?php
declare(strict_types=1);

namespace App\Controller;

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
            'wpLead'
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

        $this->set(compact('lead'));
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

            $this->set(compact('lead'));
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

        $distributorId = 0;
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
                        'userId'    => ROTATOR_TEST_MODE ? 181406 : $distributorId,
                        'firstName' => empty($requestData['first_name']) ? 'NA' : $requestData['first_name'],
                        'lastName'  => empty($requestData['last_name']) ? 'na@na.com' : $requestData['last_name'],
                        'email'     => empty($requestData['email']) ? 'NA' : $requestData['email'],
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
        $leadLog->response_json = $apiResponseData;
        $leadLog->status = $status;

        $this->LeadLogs->save($leadLog);

        $apiResponse = json_decode($apiResponseData, true);

        //Update User Position as filled
        if(!empty($apiResponse['response'])) {
            if ($status == "Saved" && $apiResponse['response']['status'] == 200) {
                $this->setSlotAsOccupied($slot, $lead);
            }
        }

        echo $this->responseFormat();
        exit;
    }

    public function getAvailableSlot() {
        $this->loadModel('UsersPositions');


        $waitingPositions = $this->UsersPositions->find('all')->where(['UsersPositions.subscription_status' => 'Active', 'UsersPositions.slot_status' => 'waiting'])->count();

        //if all positions occupied
        if ($waitingPositions <= 0) {
            //Update all for waiting
            $this->UsersPositions->updateAll(['slot_status' => 'waiting'], ['subscription_status' => 'Active']);
        }

        $slot = $this->UsersPositions->find('all')
            ->contain(['Users'])
            ->where(['UsersPositions.subscription_status' => 'Active', 'UsersPositions.slot_status' => 'waiting'])
            ->order(['UsersPositions.position_order' => 'ASC'])
            ->first();

        return $slot;
    }

    public function setSlotAsOccupied($slot, $lead) {
        $this->loadModel('UsersPositions');
        $this->loadModel('RotatorLoops');
        $waitingPositions = $this->UsersPositions->find('all')->where(['UsersPositions.subscription_status' => 'Active', 'UsersPositions.slot_status' => 'waiting'])->count();

        $this->UsersPositions->updateAll(['slot_status' => 'occupied'], ['id' => $slot->id]);

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


}

