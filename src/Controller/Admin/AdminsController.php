<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Auth\DefaultPasswordHasher;

/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminsController extends AppController {

    public function initialize(): void {
        parent::initialize();
        $this->Auth->allow(['login', 'forgotPassword', 'resetPassword', 'add', 'changeStatus']);
    }

    public function login() {
        //if already logged-in, redirect
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $admin = $this->Auth->identify();
            if ($admin) {

                $admin = $this->Admins->get($admin['id'], ['contain' => ['Images']]);

                $this->Auth->setUser($admin);
                if (isset($this->request->getData()['xx'])) {
                    $this->Cookie->write('remember_token', $this->encryptpass($this->request->getData('email')) . "^" . base64_encode($this->request->getData('password')), true);
                }
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Email or password is incorrect'));
                $this->redirect('/admin');
            }
        } elseif (empty($this->data)) {
            $rememberToken = $this->request->getCookie('remember_token');
            if (!is_null($rememberToken)) {
                $rememberToken = explode("^", $rememberToken);
                $data = $this->Admins->find('all', ['conditions' => ['remember_token' => $rememberToken[0]]], ['fields' => ['email',
                                                                                                                            'password']])->first();

                $this->request->getData()['email'] = $data->email;
                $this->request->getData()['password'] = base64_decode($rememberToken[1]);
                $admin = $this->Auth->identify();
                if ($admin) {
                    $this->Auth->setUser($admin);
                    $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->redirect('/admin');
                }
            }
        }
    }

    public function dashboard() {
        $this->loadModel('Users');
        $this->loadModel('Leads');
        $this->loadModel('RotatorLoops');

        $totalUsers = $this->Users->find('all')->count();
        $totalLeads = $this->Leads->find('all')->count();
        $totalRotatorLoops = $this->RotatorLoops->find('all')->count();

        $this->set(compact('totalUsers', 'totalLeads', 'totalRotatorLoops'));
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
        $admins = $this->paginate($this->Admins);

        $this->set(compact('admins'));
    }

    /**
     * View method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $admin = $this->Admins->get($id, [
            'contain' => ['Images'],
        ]);

        $this->set(compact('admin'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $admin = $this->Admins->newEmptyEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $images = $this->Admins->Images->find('list', ['limit' => 200]);
        $this->set(compact('admin', 'images'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $admin = $this->Admins->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $images = $this->Admins->Images->find('list', ['limit' => 200]);
        $this->set(compact('admin', 'images'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admins->get($id);
        if ($this->Admins->delete($admin)) {
            $this->Flash->success(__('The admin has been deleted.'));
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function logout() {
        $this->Auth->logout();
        $this->request->getSession()->destroy();
        $this->request->getCookie('remember_token');
        $this->Flash->success(__('You are now logged out'));
        return $this->redirect(['controller' => 'Admins', 'action' => 'login']);
    }

    public function profile() {

        $admin = $admin = $this->Admins->get($this->Auth->user('id'), ['contain' => ['Images']]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $admin = $this->Admins->patchEntity($admin, $this->request->getData());


            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));
                $admin = $this->Admins->get($admin->id, ['contain' => ['Images']]);
                $this->Auth->setUser($admin);

                return $this->redirect(['action' => 'profile']);
            } else {
                //pr($admin->errors()); die;
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        unset($admin->password);

        $this->set(compact('admin'));
    }

    public function changePassword() {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $admin = $this->Admins->find()->where(['id' => $this->Auth->user('id')])->first();
            if ((new DefaultPasswordHasher)->check($this->request->getData('current_password'), $admin->password)) {
                if ($this->request->getData('new_password') == $this->request->getData('confirm_password')) {
                    $admin->password = $this->request->getData('new_password');
                    if ($this->Admins->save($admin)) {
                        $this->Flash->success(__('Password has been reset.'));
                    } else {
                        $this->Flash->error(__('Password has not been set.'));
                    }
                } else {
                    $this->Flash->error(__('Confirm Password does not match with New Password'));
                }
            } else {
                $this->Flash->error(__('Invalid Current Password'));
            }
        }
        return $this->redirect(['controller' => 'admins', 'action' => 'profile']);
    }


    public function changeStatus() {

        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is('post')) {
            $model = $this->request->getData('model');
            $field = $this->request->getData('field');
            $id = $this->request->getData('id');

            $this->loadModel($model);

            $entity = $this->{$model}->find('all')->where(['id' => $id])->first();

            $entity->{$field} = ($entity->{$field} <= 0) ? 1 : 0;

            if ($this->{$model}->save($entity)) {
                if ($model == "Apartments") {
                    $this->loadModel('Users');
                    $user = $this->Users->find('all')->where(['id' => $entity->user_id])->first();
                    if ($user->no_of_apartments <= 1) {
                        $user->active = ($entity->{$field}) ? 1 : 0;
                        $this->Users->save($user);
                    }
                }
                $this->responseCode = SUCCESS_CODE;
                $this->responseData['new_status'] = $entity->{$field};
            }
        }

        echo $this->responseFormat();
    }

    public function getOptions() {
        $this->autoRender = false;
        $query = $this->request->getData('query');
        if (!empty($query)) {

            $value = empty($this->request->getData('value')) ? "id" : $this->request->getData('value');
            $label = empty($this->request->getData('label')) ? "name" : $this->request->getData('label');
            $match = $this->request->getData('match');
            $model = $this->request->getData('find');

            $this->loadModel($model);

            $options = $this->{$model}
                ->find('all')
                ->select(['value' => $model . "." . $value, 'label' => $model . "." . $label])
                ->where([$model . "." . $match => $query])
                ->where([$model . '.status' => true])
                ->order([$model . "." . $label => 'ASC'])
                ->all()
                ->toArray();
            echo json_encode(['suggestions' => $options]);
        } else {
            echo json_encode(['suggestions' => []]);
        }

        exit;
    }

    public function getSuggestions() {
        $this->autoRender = false;
        $query = $this->request->getQuery('query');
        if (!empty($query)) {
            $model = $this->request->getQuery('find');
            $this->loadModel($model);
            $match = empty($this->request->getQuery('match')) ? "name" : $this->request->getQuery('match');

            $matches = explode(",", $match);
            foreach ($matches as $m) {
                $conditions['OR'][$model . '.' . $m . ' LIKE'] = '%' . $query . '%';
            }

            $select = empty($this->request->getQuery('select')) ? $model . ".name" : $this->request->getQuery('select');

            if (!empty($this->request->getQuery('conditions'))) {
                foreach ($this->request->getQuery('conditions') as $field => $value) {
                    $conditions[$field] = $value;
                }
            }

            $cities = $this->$model
                ->find('all')
                ->select([$model . '.id', 'value' => $select])
                ->where($conditions)
                ->contain([])
                ->toArray();
            echo json_encode(['suggestions' => $cities]);
        } else {
            echo json_encode(['suggestions' => []]);
        }

        exit;
    }

    public function isUniqueEmail($id = null) {
        $this->autoRender = false;
        $this->loadModel('Users');
        if ($id === null) {
            $email = $this->request->getQuery('email');
            if ($this->Users->findByEmail($email)->count()) {
                $alreadyExists = "false";
            } else {
                $alreadyExists = "true";
            }
        } else {
            $count = $this->Users->find()
                ->where(['id !=' => $id, 'email' => $this->request->getQuery('email')])
                ->count();
            if ($count) {
                $alreadyExists = "false";
            } else {
                $alreadyExists = "true";
            }
        }
        echo $alreadyExists;
        exit;
    }

    public function crons() {

    }

    public function import() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $filePath = $this->request->getData('file_path');
        $model = $this->request->getData('model');
        $requiredFields = $this->request->getData('required_fields');
        $fieldMap = $this->request->getData('field_map');
        $defaultFields = $this->request->getData('default_value');
        $logs = [];
        $totalToImport = 0;
        $successfullyImported = 0;
        $notImported = 0;

        $this->loadModel($model);

        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if ($totalToImport > 0) {


                    foreach ($requiredFields as $requiredField => $dataIndex) {
                        $conditions[$requiredField] = $data[$dataIndex];
                    }

                    $entity = $this->{$model}->find()->where($conditions)->first();

                    $fullName = '<b>' . $data[0] . '</b>';

                    if (empty($entity)) {

                        $entity = $this->{$model}->newEmptyEntity();



//                        $fieldMap = array_filter($fieldMap);
//
//                        pr($fieldMap);

                        foreach ($fieldMap as $field => $dIndex) {
                            //var_dump($dIndex);
                            $dIndex = ($dIndex === 0) ? (int)$dIndex : $dIndex;

                            if (!empty($data[$dIndex]) || $dIndex === 0) {
                                $entity->{$field} = trim($data[$dIndex]);
                            }
                        }

//                        pr($entity);
//
//                        die;


                        foreach ($defaultFields as $field => $value) {
                            if (!empty($value)) {
                                $entity->{$field} = $value;
                            }
                        }


                        if ($this->{$model}->save($entity)) {
                            $successfullyImported++;
                            $logs[] = $fullName . " Saved Successfully";
                        } else {
                            $logs[] = $fullName . " Could not save.";
                            $notImported++;
                        }

                    } else {
                        $logs[] = $fullName . " already exists.";
                    }

                }

                $totalToImport++;
            }
            fclose($handle);
        }

        $this->responseCode = SUCCESS_CODE;
        $this->responseData['totalToImport'] = $totalToImport - 1;
        $this->responseData['successfullyImported'] = $successfullyImported;
        $this->responseData['notImported'] = $notImported;
        $this->responseData['logs'] = $logs;

        echo $this->responseFormat();
        exit;
    }

    public function uploadImportCsv() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;


        if ($this->request->is(['patch', 'post', 'put'])) {

            $file = $this->request->getData('file');
            $clientFileName = $file->getClientFilename();
            $fileSize = $file->getSize();

            $this->fileExt = pathinfo($clientFileName, PATHINFO_EXTENSION);

            $this->fileName = uniqid() . "." . $this->fileExt;
            $filePath = WWW_ROOT . 'files/csvs/' . $this->fileName;
            $fileUrl = SITE_URL . 'files/csvs/' . $this->fileName;


            if (!is_writable(WWW_ROOT . 'files/csvs/')) {

                if (!file_exists(WWW_ROOT . 'files')) {
                    mkdir(WWW_ROOT . 'files');
                }
                if (!file_exists(WWW_ROOT . 'files/csvs')) {
                    mkdir(WWW_ROOT . 'files/csvs');
                }
                chmod(WWW_ROOT . 'files', 0777);
            }


            if ($fileSize <= 50320921) {
                if (in_array(strtolower($this->fileExt), ['csv'])) {
                    $file->moveTo($filePath);

                    $this->responseCode = SUCCESS_CODE;
                    $this->responseData['path'] = $fileUrl;

                    if (($handle = fopen($fileUrl, "r")) !== FALSE) {
                        $row = 0;
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                            if ($row <= 0) {
                                $this->responseData['fields'] = $data;
                                break;
                            }

                            $row++;
                        }
                        fclose($handle);
                    }


                } else {
                    $this->responseMessage = __("Only CSV files are allowed.");
                }
            } else {
                $this->responseMessage = __("Sorry, the file is too large.");
            }
        } else {
            $this->responseMessage = __("Video file is too large, file must be less than 50 MB in size.");
        }


        echo $this->responseFormat();
        exit;
    }

}
