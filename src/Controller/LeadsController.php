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
        $this->paginate = [
            'contain' => ['Images'],
        ];
        $leads = $this->paginate($this->Leads);

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
            'contain' => ['Images', 'Users', 'EmailCampaignRecipients', 'RotatorLoops'],
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
            if ($this->Leads->save($lead)) {
                $this->Flash->success(__('The lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lead could not be saved. Please, try again.'));
        }
        $images = $this->Leads->Images->find('list', ['limit' => 200]);
        $users = $this->Leads->Users->find('list', ['limit' => 200]);
        $this->set(compact('lead', 'images', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $lead = $this->Leads->get($id, [
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lead = $this->Leads->patchEntity($lead, $this->request->getData());
            if ($this->Leads->save($lead)) {
                $this->Flash->success(__('The lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lead could not be saved. Please, try again.'));
        }
        $images = $this->Leads->Images->find('list', ['limit' => 200]);
        $users = $this->Leads->Users->find('list', ['limit' => 200]);
        $this->set(compact('lead', 'images', 'users'));
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


    public function wpLead() {
        $this->loadComponent('RapidFunnel');
        $this->loadModel('LeadLogs');

        $status = "Error";
        $requestData = $this->request->getData();
        $lead = $this->Leads->find()->where(['Leads.email' => $requestData['email']])->first();
        if (empty($lead)) {
            $lead = $this->Leads->newEmptyEntity();
            if ($this->request->is('post')) {
                $lead = $this->Leads->patchEntity($lead, $this->request->getData());
                $lead->status = true;
                if ($this->Leads->save($lead)) {
                    $this->responseCode = SUCCESS_CODE;
                    $this->responseMessage = 'The lead has been saved.';
                    $status = "Saved";
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

        $url = "https://apiv2.rapidfunnel.com/v1/contacts";

        $this->loadModel('UsersLeads');

        $userLead = $this->UsersLeads->find('all')->first();

        $params = [
            'userId'    => ($userLead->user_id == 1) ? 181405 : 181406,
            'firstName' => empty($requestData['first_name']) ? 'NA' : $requestData['first_name'],
            'lastName'  => empty($requestData['last_name']) ? 'na@na.com' : $requestData['last_name'],
            'email'     => empty($requestData['email']) ? 'NA' : $requestData['email'],
            'phone[]'   => empty($requestData['phone']) ? 'NA' : $requestData['phone'],
            'company'   => empty($requestData['company']) ? 'NA' : $requestData['company'],
            'note'      => empty($requestData['note']) ? 'NA' : $requestData['note'],
            //'campaignId' => 564, // 564, 560
        ];

        $userLead->user_id = ($userLead->user_id == 1) ? 2 : 1;

        $this->UsersLeads->save($userLead);

        $requestData['API_PARAMS'] = $params;

        $this->loadComponent('RapidFunnel');
        $responseData = $this->RapidFunnel->postRf($url, $params, true);


        $leadLog = $this->LeadLogs->newEmptyEntity();

        $leadLog->lead_id = $lead->id;
        $leadLog->first_name = $lead->first_name;
        $leadLog->last_name = $lead->last_name;
        $leadLog->email = $lead->email;
        $leadLog->ip = $requestData['ip'];
        $leadLog->lead_from = $requestData['lead_from'];
        $leadLog->request_json = json_encode($requestData);
        $leadLog->response_json = json_encode($responseData);
        $leadLog->status = $status;

        $this->LeadLogs->save($leadLog);

        echo $this->responseFormat();
        exit;
    }
}

