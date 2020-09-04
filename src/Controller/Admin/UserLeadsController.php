<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * UserLeads Controller
 *
 * @method \App\Model\Entity\UserLead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserLeadsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $userLeads = $this->paginate($this->UserLeads);

        $this->set(compact('userLeads'));
    }

    /**
     * View method
     *
     * @param string|null $id User Lead id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userLead = $this->UserLeads->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('userLead'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userLead = $this->UserLeads->newEmptyEntity();
        if ($this->request->is('post')) {
            $userLead = $this->UserLeads->patchEntity($userLead, $this->request->getData());
            if ($this->UserLeads->save($userLead)) {
                $this->Flash->success(__('The user lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user lead could not be saved. Please, try again.'));
        }
        $this->set(compact('userLead'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Lead id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userLead = $this->UserLeads->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userLead = $this->UserLeads->patchEntity($userLead, $this->request->getData());
            if ($this->UserLeads->save($userLead)) {
                $this->Flash->success(__('The user lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user lead could not be saved. Please, try again.'));
        }
        $this->set(compact('userLead'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Lead id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userLead = $this->UserLeads->get($id);
        if ($this->UserLeads->delete($userLead)) {
            $this->Flash->success(__('The user lead has been deleted.'));
        } else {
            $this->Flash->error(__('The user lead could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
