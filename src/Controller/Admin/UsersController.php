<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Users Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $states = $this->Users->States->find('list')->where(['States.status' => true])->order(['States.name' => 'ASC'])->toArray();
        $cities = [];

        $this->set(compact('user', 'states', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $states = $this->Users->States->find('list')->where(['States.status' => true])->order(['States.name' => 'ASC'])->toArray();
        if(empty($user->state_id)){
            $cities = [];
        } else {
            $cities = $this->Users->Cities->find('list')->where(['Cities.state_id' => $user->state_id,
                                                                 'Cities.status'   => true])->order(['Cities.name' => 'ASC'])->toArray();
        }

        $this->set(compact('user', 'states', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function import() {

    }

    public function export() {

    }

    public function managePositions() {

        $limit = 200;

        $this->loadModel('UsersPositions');

//        $this->paginate['limit'] = $limit;
//        $this->paginate['maxLimit'] = 500;

        $this->paginate['sortWhitelist'] = [
            'Users.name',
            'Users.email',
            'UsersPositions.position_no',
            'UsersPositions.position_order',
        ];

        $query = $this->UsersPositions->find('all')->contain(['Users']);

        $userPositions = $this->paginate($query);

        $this->set(compact('userPositions', 'limit'));
    }

    public function getUserPosition($id = null) {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('UsersPositions');

        $userPosition = $this->UsersPositions->find('all')->contain(['Users'])->where(['UsersPositions.id' => $id])->first();

        $max = $this->UsersPositions->find('all')->count();

        $this->set(compact('userPosition', 'max'));
    }

    public function editUserPositionLeadLimit($id = null) {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('UsersPositions');

        $userPosition = $this->UsersPositions->find('all')->contain(['Users'])->where(['UsersPositions.id' => $id])->first();

        $max = $this->UsersPositions->find('all')->count();

        $this->set(compact('userPosition', 'max'));
    }


    public function changeUserPosition() {

        $this->responseCode = CODE_BAD_REQUEST;

        $id = $this->request->getData('user_position_id');
        $newP = $this->request->getData('position_order');

        $this->loadModel('UsersPositions');

        $userPosition = $this->UsersPositions->find('all')->contain(['Users'])->where(['UsersPositions.id' => $id])->first();

        $oldP = $userPosition->position_order;

        if ($oldP > $newP) {


            $this->UsersPositions->updateAll(['position_order = position_order + 1'], ['position_order >=' => $newP, 'position_order <' => $oldP]);

            $userPosition->position_order = $newP;

            $this->UsersPositions->save($userPosition);

        }

        if ($oldP < $newP) {


            $this->UsersPositions->updateAll(['position_order = position_order - 1'], ['position_order <=' => $newP, 'position_order >' => $oldP]);

            $userPosition->position_order = $newP;

            $this->UsersPositions->save($userPosition);

        }

        $this->responseData['page'] = ceil($newP / PAGE_LIMIT);

        echo $this->responseFormat();
        exit;

    }

    public function changeUserPositionLeadLimit() {

        $this->responseCode = CODE_BAD_REQUEST;

        $id = $this->request->getData('user_position_id');
        $leadLimit = $this->request->getData('lead_limit');

        $this->loadModel('UsersPositions');

        $userPosition = $this->UsersPositions->find('all')->contain(['Users'])->where(['UsersPositions.id' => $id])->first();

        $userPosition->lead_limit = $leadLimit;


        if ($this->UsersPositions->save($userPosition)) {
            $this->responseCode = SUCCESS_CODE;
        }


        echo $this->responseFormat();
        exit;

    }

    public function enterPositions() {
        $users = $this->Users->find('all')->all();
        $this->loadModel('UsersPositions');

        $order = 1;
        foreach ($users as $user) {
            $userPosition = $this->UsersPositions->newEmptyEntity();

            $userPosition->user_id = $user->id;
            $userPosition->subscription_id = 1;
            $userPosition->position_no = 1;
            $userPosition->position_order = $order;
            $userPosition->subscription_status = "Active";

            $order++;

            $this->UsersPositions->save($userPosition);
        }

        exit;

    }
}
