<?php
declare(strict_types=1);

namespace App\Controller\Admin;


/**
 * Plans Controller
 *
 * @method \App\Model\Entity\Plan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlansController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $plans = $this->paginate($this->Plans);

        $this->set(compact('plans'));
    }

    /**
     * View method
     *
     * @param string|null $id Plan id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $plan = $this->Plans->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('plan'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $plan = $this->Plans->newEmptyEntity();
        if ($this->request->is('post')) {
            $plan = $this->Plans->patchEntity($plan, $this->request->getData());
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('The plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The plan could not be saved. Please, try again.'));
        }
        $this->set(compact('plan'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Plan id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $plan = $this->Plans->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $plan = $this->Plans->patchEntity($plan, $this->request->getData());
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('The plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The plan could not be saved. Please, try again.'));
        }
        $this->set(compact('plan'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Plan id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $plan = $this->Plans->get($id);
        if ($this->Plans->delete($plan)) {
            $this->Flash->success(__('The plan has been deleted.'));
        } else {
            $this->Flash->error(__('The plan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
