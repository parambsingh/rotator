<?php
declare(strict_types=1);

namespace App\Controller;

use LogMeIn\GoToWebinar\Client;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {

    public function initialize(): void {
        parent::initialize();
        $this->Auth->allow([
            'login',
            'register',
            'forgotPassword',
            'forgotPasswordApi',
            'resetPasswordApi',
            'resetPassword',
            'add',
            'changeStatus',
            'isUniqueEmail',
            'getOptions',
            'getSuggestions',
            'webinar',
            'clickFunnel',
        ]);
    }

    public function login() {
        //if already logged-in, redirect
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {

                $user = $this->Users->get($user['id'], ['contain' => ['Images']]);

                $this->Auth->setUser($user);
                // if (isset($this->request->getData()['remember_me'])) {
                //   // $this->Cookie->write('remember_me', $this->encryptpass($this->request->getData('email')) . "^" . base64_encode($this->request->getData('password')), true);
                // }
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Email or password is incorrect'));
                $this->redirect('/sign-in');
            }
        }

        // elseif (empty($this->data)) {
        //     $rememberToken = $this->request->getCookie('remember_me');
        //     if (!is_null($rememberToken)) {
        //         $rememberToken = explode("^", $rememberToken);
        //         $data = $this->Users->find('all', ['conditions' => ['remember_me' => $rememberToken[0]]], ['fields' => ['email',
        //                                                                                                                 'password']])->first();

        //         $this->request->getData()['email'] = $data->email;
        //         $this->request->getData()['password'] = base64_decode($rememberToken[1]);
        //         $user = $this->Auth->identify();
        //         if ($user) {
        //             $this->Auth->setUser($user);
        //             $this->redirect($this->Auth->redirectUrl());
        //         } else {
        //             $this->redirect('/admin');
        //         }
        //     }
        // }
    }

    public function logout() {
        $this->Auth->logout();
        $this->request->getSession()->destroy();
        $this->request->getCookie('remember_me');
        $this->Flash->success(__('You are now logged out'));
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function dashboard() {
        $this->loadModel('Leads');
        $this->loadModel('EmailCampaigns');

        $totalLeads = $this->Leads->find('all')->where(['Leads.user_id' => $this->authUserId])->count();

        $emailCampaign = $this->EmailCampaigns->find('all')->select([
            'EmailCampaigns__scheduled_total' => 'SUM(scheduled_count)',
            'EmailCampaigns__sent_total'      => 'SUM(sent_count)',
            'EmailCampaigns__failed_total'    => 'SUM(failed_count)',
            'EmailCampaigns__opened_total'    => 'SUM(opened_count)',
        ])
            ->where([
                'EmailCampaigns.from_email' => $this->Auth->user('email')
            ])
            ->first();

        //pr($emailCampaign); die;

        $this->set(compact('totalLeads', 'emailCampaign'));
    }

    public function register() {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->status = true;
            $user->rf_email = $this->request->getData('email');
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Thank You for joining with us.'));

                return $this->redirect(['action' => 'login']);
            } else {
                pr($user->getErrors());
                die;
            }
            $this->Flash->error(__('Could not register. Please, try again.'));
        }

        $states = $this->Users->States->find('list')->where(['States.status' => true])->order(['States.name' => 'ASC'])->toArray();
        $this->set(compact('user', 'states'));
    }

    public function resetPasswordApi() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $captcha = "";


            if (isset($_POST['g-recaptcha-response']))
                $captcha = $_POST['g-recaptcha-response'];

            if (empty($captcha)) {
                $this->responseMessage = "Please check the the captcha form.";
            }

            $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_SECRET . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);

            if ($response['success'] == false) {
                $this->responseMessage = 'Incorrect Re-captcha';
            } else {
                $user = $this->Users->findByForgotPasswordToken($this->request->getData('forgot_password_token'))->first();
                if ($user) {
                    /*
                     * Restrict user to edit only while listed fields
                     */
                    $editableFields = ['password', 'verify_password', 'forgot_password_token'];
                    foreach ($this->request->getData() as $field => $val) {
                        if (!in_array($field, $editableFields)) {
                            unset($this->request->getData()[$field]);
                        }
                    }
                    $user['forgot_password_token'] = "";
                    $user = $this->Users->patchEntity($user, $this->request->getData());
                    if ($this->Users->save($user)) {
                        $this->responseMessage = __('Your password has been updated.');
                        $this->responseCode = SUCCESS_CODE;
                    } else {
                        $this->responseMessage = __('Something went wrong. Please, try again.');
                    }
                } else {
                    $this->responseMessage = __('Forgot password token has been expired. Please, try again.');
                }
            }
        }
        echo $this->responseFormat();
    }

    public function forgotPassword() {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $content['HEADER']['heading'] = "Forgot password";
        $content['HEADER']['text'] = "Don't worry we are gald to help you.";

        $this->set('content', $content);
        $this->set('bgImage', 'login-bg.jpg');
    }

    public function forgotPasswordApi() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $captcha = "";


            if (isset($_POST['g-recaptcha-response']))
                $captcha = $_POST['g-recaptcha-response'];

            if (empty($captcha)) {
                $this->responseMessage = "Please check the the captcha form.";
            }

            $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_SECRET . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);

            if ($response['success'] == false) {
                $this->responseMessage = 'Incorrect Re-captcha';
            } else {
                $user = $this->Users->findByEmail($this->request->getData('email'))->first();

                if (!empty($user)) {

                    if ($user->status) {
                        $user->forgot_password_token = md5(uniqid());
                        $resetUrl = SITE_URL . 'users/reset-password/' . $user->forgot_password_token;
                        if ($this->Users->save($user)) {
                            $options = [
                                'layout'      => 'designed_without_unsubscribe',
                                'emailFormat' => 'both',
                                'template'    => 'forgot_password',
                                'to'          => EMAIL_TEST_MODE ? ADMIN_EMAIL : $this->request->getData('email'),
                                'subject'     => _('Reset Password'),
                                'viewVars'    => [
                                    'name'     => $user->first_name,
                                    'resetUrl' => $resetUrl,
                                ]
                            ];

                            $this->loadComponent('EmailManager');
                            try {
                                $this->EmailManager->sendEmail($options);
                                $this->responseCode = SUCCESS_CODE;
                                $this->responseMessage = __('A link to reset the password with the instruction has been sent to your inbox');
                            } catch (\Error $e) {
                                $this->responseMessage = __('Something Went Wrong, could not send email.');
                            }
                        }
                    } else {
                        $this->responseCode = EMAIL_DOESNOT_REGISTERED;
                        $this->responseMessage = __('Your account has been disabled by administrator, please send a message from "Contact Us" page.');
                    }

                } else {
                    $this->responseCode = EMAIL_DOESNOT_REGISTERED;
                    $this->responseMessage = __('Email does not exists');
                }

            }
        }

        echo $this->responseFormat();
    }

    public function resetPassword($forgotPasswordToken) {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }


        $user = $this->Users->findByForgotPasswordToken($forgotPasswordToken)->first();
        if (!empty($user)) {
            $this->set('forgotPasswordToken', $forgotPasswordToken);
        } else {
            $this->Flash->error(__('Forgot password token has been expired. Please, try again.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function profile() {

        $user = $this->Users->get($this->authUserId, ['contain' => ['Images']]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The admin has been saved.'));
                $user = $this->Users->get($user->id, ['contain' => ['Images']]);
                $this->Auth->setUser($user);

                return $this->redirect(['action' => 'profile']);
            } else {
                //pr($user->errors()); die;
            }
            $this->Flash->error(__('The profile could not be updated. Please, try again.'));
        }
        unset($user->password);

        $states = $this->Users->States->find('list')->where(['States.status' => true])->order(['States.name' => 'ASC'])->toArray();
        if (empty($user->state_id)) {
            $cities = [];
        } else {
            $cities = $this->Users->Cities->find('list')->where(['Cities.state_id' => $user->state_id,
                                                                 'Cities.status'   => true])->order(['Cities.name' => 'ASC'])->toArray();
        }

        $this->set(compact('user', 'states', 'cities'));
    }

    public function changePassword() {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->find()->where(['id' => $this->Auth->user('id')])->first();
            if ((new DefaultPasswordHasher)->check($this->request->getData('current_password'), $user->password)) {
                if ($this->request->getData('new_password') == $this->request->getData('confirm_password')) {
                    $user->password = $this->request->getData('new_password');
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Password has been reset.'));
                        return $this->redirect(['controller' => 'Users', 'action' => 'profile']);
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
        return $this->redirect(['controller' => 'Users', 'action' => 'profile']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Distibuters', 'Images'],
        ];
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
            'contain' => ['Images', 'Leads', 'UsersPositions'],
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
                $this->assignNewPosition($user->id);
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
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
            'contain' => ['Leads'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $this->set(compact('user'));
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

    public function isUniqueEmail($id = null) {
        $this->autoRender = false;
        $email = $this->request->getQuery('email');
        $conditions = ['Users.email' => $email];

        if ($id !== null) {
            $conditions['Users.id !='] = $id;
        }
        $count = $this->Users->find()->where($conditions)->count();
        echo ($count) ? "false" : "true";
        exit;
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

    //Client ID: 9f2772bb-95db-4d15-898a-b24578d843bf
    //Client secret: IoANxTGpO/j2MArypJAb3A==

    //OWYyNzcyYmItOTVkYi00ZDE1LTg5OGEtYjI0NTc4ZDg0M2JmOklvQU54VEdwTy9qMk1BcnlwSkFiM0E9PQ==
    public function webinar() {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('WebinarAccounts');
        $webinarAccount = $this->WebinarAccounts->find('all')->first();
        $webinarAccount->code = empty($_REQUEST['code']) ? "" : $_REQUEST['code'];
        $this->WebinarAccounts->save($webinarAccount);
    }


    public function clickFunnel() {
        header('Content-Type: application/json');
        if ($json = json_decode(file_get_contents("php://input"), true)) {
            $data = $json;
        } else {
            $data = $_REQUEST;
        }

        //$data = json_decode(file_get_contents(WWW_ROOT . 'paid.json'), true);

        file_put_contents(WWW_ROOT . 'click-funnel-data.txt', print_r($data, true));

        if (strtolower($data['status']) == "paid") {

            $userData = $data['contact'];
            $product = $data['products'][0];
            $amount = $data['original_amount'];
            $amountInCents = $data['original_amount_cents'];
            $subscriptionToken = $data['subscription_id'];
            switch ($product['id']){
                case "3087851": {
                    $qty = 2;
                    break;
                }
                case "3087852": {
                    $qty = 3;
                    break;
                }
                case "3087854": {
                    $qty = 4;
                    break;
                }
                default: {
                    $qty = 1;
                    break;
                }
            }

            if (!empty($userData['name']) && !empty($userData['email'])) {

                $user = $this->Users->find('all')->where(['email' => $userData['email']])->first();

                if (empty($user)) {

                    $user = $this->Users->newEmptyEntity();

                    $user->name = $userData['name'];
                    $user->email = $userData['email'];
                    if(!empty($userData['rapid_funnel_distributor_id'])){
                        $user->distributor_id = $userData['rapid_funnel_distributor_id'];
                    }

                    $user->password = "Test123";
                    $user->status = true;
                    $user->zip = $userData['zip'];
                    $user->address = $userData['address'];
                    $user->click_funnel_json = json_encode($data);

                    $otherFields = ['phone', 'address', 'zip'];
                    foreach ($otherFields as $field) {
                        $user->{$field} = empty($userData[$field]) ? "" : $userData[$field];
                    }

                    $this->loadModel('Cities');
                    $this->loadModel('States');

                    //Match State
                    $state = [];
                    if (!empty($userData['state'])) {
                        $state = $this->States->find('all')
                            ->where([
                                'OR' => [
                                    'name LIKE'       => '%' . $userData['state'] . '%',
                                    'short_name LIKE' => '%' . $userData['state'] . '%',
                                ]
                            ])->first();
                        if (!empty($state)) {
                            $user->state_id = $state->id;
                        }
                    }

                    //Match City
                    $city = [];
                    if (!empty($userData['city'])) {
                        $cityConditions = ['name LIKE' => '%' . $userData['city'] . '%'];
                        if (!empty($state)) {
                            $cityConditions[] = ['state_id' => $state->id];
                        }
                        $city = $this->Cities->find('all')->where($cityConditions)->first();
                        if (!empty($city)) {
                            $user->city_id = $city->id;
                        }
                    }

                    if ($this->Users->save($user)) {
                        $subscriptionId = $this->saveSubscription($product, $user, $amount, $amountInCents, $subscriptionToken);
                        $this->assignNewPosition($user->id, (100 * $qty), $subscriptionId);

                        //Save Subscription
                    }
                } else {
                    // $subscriptionId = $this->saveSubscription($product, $user, $amount, $amountInCents, $subscriptionToken);
                    // $this->assignNewPosition($user->id, (100 * $qty) , $subscriptionId);
                }
            }

            echo json_encode(['time' => date(SQL_DATETIME)]);
        } else {
            echo json_encode(array('Failed'));
        }
        exit;
    }

    public function saveSubscription($product, $user, $amount, $amountInCents, $subscriptionToken) {
        $this->loadModel('Plans');
        $this->loadModel('Subscriptions');

        $plan = $this->Plans->find('all')->where(['stripe_plan' => $product['stripe_plan']])->first();

        if (empty($plan)) {
            $plan = $this->Plans->newEmptyEntity();
            $plan->name = $product['name'];
            $plan->stripe_plan = $product['stripe_plan'];
            $plan->price = $amountInCents / 100;
            $plan->type = "Subscription";
            $plan->status = true;

            $this->Plans->save($plan);
        }


        $subscription = $this->Subscriptions->newEmptyEntity();

        $subscription->plan_id = $plan->id;
        $subscription->user_id = $user->id;
        $subscription->subscription_token = $subscriptionToken;
        $subscription->amount = $amountInCents / 100;
        $subscription->discount = 0;
        $subscription->start_at = date(SQL_DATETIME);
        $subscription->end_at = date(SQL_DATETIME, strtotime('+ 1 month'));
        $subscription->response_json = json_encode(['product' => $product, 'amount' => $amount]);
        $subscription->status = "active";

        $this->Subscriptions->save($subscription);

        return $subscription->id;

    }

}
