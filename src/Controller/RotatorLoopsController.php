<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RotatorLoops Controller
 *
 * @property \App\Model\Table\RotatorLoopsTable $RotatorLoops
 * @method \App\Model\Entity\RotatorLoop[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RotatorLoopsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['UserPositions', 'Leads'],
        ];
        $rotatorLoops = $this->paginate($this->RotatorLoops);

        $this->set(compact('rotatorLoops'));
    }

    /**
     * View method
     *
     * @param string|null $id Rotator Loop id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rotatorLoop = $this->RotatorLoops->get($id, [
            'contain' => ['UserPositions', 'Leads'],
        ]);

        $this->set(compact('rotatorLoop'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rotatorLoop = $this->RotatorLoops->newEmptyEntity();
        if ($this->request->is('post')) {
            $rotatorLoop = $this->RotatorLoops->patchEntity($rotatorLoop, $this->request->getData());
            if ($this->RotatorLoops->save($rotatorLoop)) {
                $this->Flash->success(__('The rotator loop has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rotator loop could not be saved. Please, try again.'));
        }
        $userPositions = $this->RotatorLoops->UserPositions->find('list', ['limit' => 200]);
        $leads = $this->RotatorLoops->Leads->find('list', ['limit' => 200]);
        $this->set(compact('rotatorLoop', 'userPositions', 'leads'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rotator Loop id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rotatorLoop = $this->RotatorLoops->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rotatorLoop = $this->RotatorLoops->patchEntity($rotatorLoop, $this->request->getData());
            if ($this->RotatorLoops->save($rotatorLoop)) {
                $this->Flash->success(__('The rotator loop has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rotator loop could not be saved. Please, try again.'));
        }
        $userPositions = $this->RotatorLoops->UserPositions->find('list', ['limit' => 200]);
        $leads = $this->RotatorLoops->Leads->find('list', ['limit' => 200]);
        $this->set(compact('rotatorLoop', 'userPositions', 'leads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rotator Loop id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rotatorLoop = $this->RotatorLoops->get($id);
        if ($this->RotatorLoops->delete($rotatorLoop)) {
            $this->Flash->success(__('The rotator loop has been deleted.'));
        } else {
            $this->Flash->error(__('The rotator loop could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
