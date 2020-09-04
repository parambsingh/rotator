<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EmailCampaigns Controller
 *
 * @property \App\Model\Table\EmailCampaignsTable $EmailCampaigns
 * @method \App\Model\Entity\EmailCampaign[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailCampaignsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['EmailTemplates'],
        ];
        $emailCampaigns = $this->paginate($this->EmailCampaigns);

        $this->set(compact('emailCampaigns'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Campaign id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailCampaign = $this->EmailCampaigns->get($id, [
            'contain' => ['EmailTemplates', 'EmailCampaignRecipients'],
        ]);

        $this->set(compact('emailCampaign'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailCampaign = $this->EmailCampaigns->newEmptyEntity();
        if ($this->request->is('post')) {
            $emailCampaign = $this->EmailCampaigns->patchEntity($emailCampaign, $this->request->getData());
            if ($this->EmailCampaigns->save($emailCampaign)) {
                $this->Flash->success(__('The email campaign has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email campaign could not be saved. Please, try again.'));
        }
        $emailTemplates = $this->EmailCampaigns->EmailTemplates->find('list', ['limit' => 200]);
        $this->set(compact('emailCampaign', 'emailTemplates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Campaign id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailCampaign = $this->EmailCampaigns->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailCampaign = $this->EmailCampaigns->patchEntity($emailCampaign, $this->request->getData());
            if ($this->EmailCampaigns->save($emailCampaign)) {
                $this->Flash->success(__('The email campaign has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email campaign could not be saved. Please, try again.'));
        }
        $emailTemplates = $this->EmailCampaigns->EmailTemplates->find('list', ['limit' => 200]);
        $this->set(compact('emailCampaign', 'emailTemplates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Campaign id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailCampaign = $this->EmailCampaigns->get($id);
        if ($this->EmailCampaigns->delete($emailCampaign)) {
            $this->Flash->success(__('The email campaign has been deleted.'));
        } else {
            $this->Flash->error(__('The email campaign could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
