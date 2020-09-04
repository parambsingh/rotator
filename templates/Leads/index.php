<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lead[]|\Cake\Collection\CollectionInterface $leads
 */
?>
<div class="leads index content">
    <?= $this->Html->link(__('New Lead'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Leads') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('home_email') ?></th>
                    <th><?= $this->Paginator->sort('work_email') ?></th>
                    <th><?= $this->Paginator->sort('other_email') ?></th>
                    <th><?= $this->Paginator->sort('password') ?></th>
                    <th><?= $this->Paginator->sort('forgot_password_token') ?></th>
                    <th><?= $this->Paginator->sort('image_id') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('home_phone') ?></th>
                    <th><?= $this->Paginator->sort('work_phone') ?></th>
                    <th><?= $this->Paginator->sort('other_phone') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('zip') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th><?= $this->Paginator->sort('company') ?></th>
                    <th><?= $this->Paginator->sort('interest') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead): ?>
                <tr>
                    <td><?= $this->Number->format($lead->id) ?></td>
                    <td><?= h($lead->first_name) ?></td>
                    <td><?= h($lead->last_name) ?></td>
                    <td><?= h($lead->email) ?></td>
                    <td><?= h($lead->home_email) ?></td>
                    <td><?= h($lead->work_email) ?></td>
                    <td><?= h($lead->other_email) ?></td>
                    <td><?= h($lead->password) ?></td>
                    <td><?= h($lead->forgot_password_token) ?></td>
                    <td><?= $lead->has('image') ? $this->Html->link($lead->image->id, ['controller' => 'Images', 'action' => 'view', $lead->image->id]) : '' ?></td>
                    <td><?= h($lead->phone) ?></td>
                    <td><?= h($lead->home_phone) ?></td>
                    <td><?= h($lead->work_phone) ?></td>
                    <td><?= h($lead->other_phone) ?></td>
                    <td><?= h($lead->address) ?></td>
                    <td><?= h($lead->city) ?></td>
                    <td><?= h($lead->state) ?></td>
                    <td><?= h($lead->zip) ?></td>
                    <td><?= h($lead->role) ?></td>
                    <td><?= h($lead->company) ?></td>
                    <td><?= h($lead->interest) ?></td>
                    <td><?= h($lead->status) ?></td>
                    <td><?= h($lead->created) ?></td>
                    <td><?= h($lead->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $lead->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lead->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $lead->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lead->id)]) ?>
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
