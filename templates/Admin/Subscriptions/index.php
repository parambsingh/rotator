<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $subscriptions
 */
?>
<div class="subscriptions index content">
    <?= $this->Html->link(__('New Subscription'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Subscriptions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('plan_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('coupon_id') ?></th>
                    <th><?= $this->Paginator->sort('subscription_token') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('discount') ?></th>
                    <th><?= $this->Paginator->sort('start_at') ?></th>
                    <th><?= $this->Paginator->sort('end_at') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('cancelled_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscriptions as $subscription): ?>
                <tr>
                    <td><?= $this->Number->format($subscription->id) ?></td>
                    <td><?= $this->Number->format($subscription->plan_id) ?></td>
                    <td><?= $this->Number->format($subscription->user_id) ?></td>
                    <td><?= $this->Number->format($subscription->coupon_id) ?></td>
                    <td><?= h($subscription->subscription_token) ?></td>
                    <td><?= $this->Number->format($subscription->amount) ?></td>
                    <td><?= $this->Number->format($subscription->discount) ?></td>
                    <td><?= h($subscription->start_at) ?></td>
                    <td><?= h($subscription->end_at) ?></td>
                    <td><?= h($subscription->status) ?></td>
                    <td><?= h($subscription->cancelled_at) ?></td>
                    <td><?= h($subscription->created) ?></td>
                    <td><?= h($subscription->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $subscription->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $subscription->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subscription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscription->id)]) ?>
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
