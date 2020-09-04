<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailTemplate[]|\Cake\Collection\CollectionInterface $emailTemplates
 */
?>
<div class="emailTemplates index content">
    <?= $this->Html->link(__('New Email Template'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Email Templates') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('label') ?></th>
                    <th><?= $this->Paginator->sort('subject') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emailTemplates as $emailTemplate): ?>
                <tr>
                    <td><?= $this->Number->format($emailTemplate->id) ?></td>
                    <td><?= $emailTemplate->has('user') ? $this->Html->link($emailTemplate->user->id, ['controller' => 'Users', 'action' => 'view', $emailTemplate->user->id]) : '' ?></td>
                    <td><?= h($emailTemplate->label) ?></td>
                    <td><?= $this->Number->format($emailTemplate->subject) ?></td>
                    <td><?= h($emailTemplate->status) ?></td>
                    <td><?= h($emailTemplate->created) ?></td>
                    <td><?= h($emailTemplate->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $emailTemplate->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $emailTemplate->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $emailTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailTemplate->id)]) ?>
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
