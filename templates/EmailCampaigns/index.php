<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailCampaign[]|\Cake\Collection\CollectionInterface $emailCampaigns
 */
?>
<div class="emailCampaigns index content">
    <?= $this->Html->link(__('New Email Campaign'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Email Campaigns') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('from_email') ?></th>
                    <th><?= $this->Paginator->sort('email_template_id') ?></th>
                    <th><?= $this->Paginator->sort('send_at') ?></th>
                    <th><?= $this->Paginator->sort('scheduled_count') ?></th>
                    <th><?= $this->Paginator->sort('sent_count') ?></th>
                    <th><?= $this->Paginator->sort('failed_count') ?></th>
                    <th><?= $this->Paginator->sort('opened_count') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emailCampaigns as $emailCampaign): ?>
                <tr>
                    <td><?= $this->Number->format($emailCampaign->id) ?></td>
                    <td><?= h($emailCampaign->name) ?></td>
                    <td><?= h($emailCampaign->from_email) ?></td>
                    <td><?= $emailCampaign->has('email_template') ? $this->Html->link($emailCampaign->email_template->id, ['controller' => 'EmailTemplates', 'action' => 'view', $emailCampaign->email_template->id]) : '' ?></td>
                    <td><?= h($emailCampaign->send_at) ?></td>
                    <td><?= $this->Number->format($emailCampaign->scheduled_count) ?></td>
                    <td><?= $this->Number->format($emailCampaign->sent_count) ?></td>
                    <td><?= $this->Number->format($emailCampaign->failed_count) ?></td>
                    <td><?= $this->Number->format($emailCampaign->opened_count) ?></td>
                    <td><?= h($emailCampaign->status) ?></td>
                    <td><?= h($emailCampaign->created) ?></td>
                    <td><?= h($emailCampaign->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $emailCampaign->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $emailCampaign->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $emailCampaign->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailCampaign->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
