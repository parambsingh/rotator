<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EmailTemplates Controller
 *
 * @property \App\Model\Table\EmailTemplatesTable $EmailTemplates
 * @method \App\Model\Entity\EmailTemplate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailTemplatesController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->paginate['contain'] = ['Users'];
        $emailTemplates = $this->paginate($this->EmailTemplates->find('all')->where(['EmailTemplates.user_id'=>$this->authUserId]));

        $this->set(compact('emailTemplates'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Template id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $emailTemplate = $this->EmailTemplates->get($id, [
            'contain' => ['Users', 'EmailCampaigns'],
        ]);

        $this->set(compact('emailTemplate'));
    }

    public function preview($id) {
        $this->viewBuilder()->setLayout('ajax');
        $emailTemplate = $this->EmailTemplates->find('all')
            ->contain(['Images'])
            ->where(['EmailTemplates.id'=>$id,'EmailTemplates.user_id'=>$this->authUserId])
        ->first();

        $this->set(compact('emailTemplate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $emailTemplate = $this->EmailTemplates->newEmptyEntity();
        if ($this->request->is('post')) {
            $id = 0;
            $emailTemplate = $this->EmailTemplates->find()->where(['id' => $this->request->getData('id')])->first();
            if (empty($emailTemplate)) {
                $emailTemplate = $this->EmailTemplates->newEmptyEntity();
            }

            $emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->getData());
            $emailTemplate->user_id = $this->authUserId;
            if ($this->EmailTemplates->save($emailTemplate)) {
                $this->Flash->success(__('The email template has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The email template could not be saved. Please, try again.'));
            }

        }
        $this->set(compact('emailTemplate'));
    }


    public function save() {
        $id = 0;
        $emailTemplate = $this->EmailTemplates->find()->where(['id' => $this->request->getData('id')])->first();
        if (empty($emailTemplate)) {
            $emailTemplate = $this->EmailTemplates->newEmptyEntity();
        }
        if ($this->request->is('post')) {
            $emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->getData());
            $emailTemplate->user_id = $this->authUserId;
            if ($this->EmailTemplates->save($emailTemplate)) {
                $id = $emailTemplate->id;
            } else {
                pr($emailTemplate->getErrors());
            }
        }

        echo json_encode(['id' => $id]);
        exit;

    }

    /**
     * Edit method
     *
     * @param string|null $id Email Template id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $emailTemplate = $this->EmailTemplates->find('all')->where(['EmailTemplates.id'=>$id, 'EmailTemplates.user_id'=>$this->authUserId])->first();
        if(empty($emailTemplate)){
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['action' => 'index']);
        } else {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->getData());
                if ($this->EmailTemplates->save($emailTemplate)) {
                    $this->Flash->success(__('The email template has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The email template could not be saved. Please, try again.'));
            }
            $this->set(compact('emailTemplate', 'users'));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Template id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $emailTemplate = $this->EmailTemplates->get($id);
        if ($this->EmailTemplates->delete($emailTemplate)) {
            $this->Flash->success(__('The email template has been deleted.'));
        } else {
            $this->Flash->error(__('The email template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
