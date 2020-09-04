<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Subscriptions Controller
 *
 * @property \App\Model\Table\SubscriptionsTable $Subscriptions
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Plans', 'Users', 'Coupons'],
        ];
        $subscriptions = $this->paginate($this->Subscriptions);

        $this->set(compact('subscriptions'));
    }

    /**
     * View method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subscription = $this->Subscriptions->get($id, [
            'contain' => ['Plans', 'Users', 'Coupons', 'UsersPositions'],
        ]);

        $this->set(compact('subscription'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subscription = $this->Subscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
            if ($this->Subscriptions->save($subscription)) {
                $this->Flash->success(__('The subscription has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
        }
        $plans = $this->Subscriptions->Plans->find('list', ['limit' => 200]);
        $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
        $coupons = $this->Subscriptions->Coupons->find('list', ['limit' => 200]);
        $this->set(compact('subscription', 'plans', 'users', 'coupons'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subscription = $this->Subscriptions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
            if ($this->Subscriptions->save($subscription)) {
                $this->Flash->success(__('The subscription has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
        }
        $plans = $this->Subscriptions->Plans->find('list', ['limit' => 200]);
        $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
        $coupons = $this->Subscriptions->Coupons->find('list', ['limit' => 200]);
        $this->set(compact('subscription', 'plans', 'users', 'coupons'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscription = $this->Subscriptions->get($id);
        if ($this->Subscriptions->delete($subscription)) {
            $this->Flash->success(__('The subscription has been deleted.'));
        } else {
            $this->Flash->error(__('The subscription could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
