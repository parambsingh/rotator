<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Leads Controller
 *
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeadsController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->paginate['contain'] = ['Users'];
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
            'contain' => [],
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
        $lead = $this->Leads->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lead = $this->Leads->patchEntity($lead, $this->request->getData());
            if ($this->Leads->save($lead)) {
                $this->Flash->success(__('The lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lead could not be saved. Please, try again.'));
        }

        $states = $this->Leads->States->find('list')->where(['States.status' => true])->order(['States.name' => 'ASC'])->toArray();
        if(empty($lead->state_id)){
            $cities = [];
        } else {
            $cities = $this->Leads->Cities->find('list')->where(['Cities.state_id' => $lead->state_id,
                                                                 'Cities.status'   => true])->order(['Cities.name' => 'ASC'])->toArray();
        }

        $this->set(compact('lead', 'states', 'cities'));
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

    public function import() {

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function logs() {
        $this->loadModel('LeadLogs');
        $leads = $this->paginate($this->LeadLogs);

        $this->set(compact('leads'));
    }

    public function viewLog($id = null) {
        $this->loadModel('LeadLogs');
        $lead = $this->LeadLogs->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('lead'));
    }

    public function deleteLog($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $this->loadModel('LeadLogs');
        $lead = $this->LeadLogs->get($id);
        if ($this->LeadLogs->delete($lead)) {
            $this->Flash->success(__('The lead log has been deleted.'));
        } else {
            $this->Flash->error(__('The lead log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'logs']);
    }
}
