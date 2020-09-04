<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * RotatorLoops Controller
 *
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
            'contain' => [],
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
        $this->set(compact('rotatorLoop'));
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
        $this->set(compact('rotatorLoop'));
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
