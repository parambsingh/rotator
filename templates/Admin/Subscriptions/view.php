<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $subscription
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Subscription'), ['action' => 'edit', $subscription->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Subscription'), ['action' => 'delete', $subscription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscription->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Subscriptions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Subscription'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="subscriptions view content">
            <h3><?= h($subscription->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Subscription Token') ?></th>
                    <td><?= h($subscription->subscription_token) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($subscription->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($subscription->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Plan Id') ?></th>
                    <td><?= $this->Number->format($subscription->plan_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td><?= $this->Number->format($subscription->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Coupon Id') ?></th>
                    <td><?= $this->Number->format($subscription->coupon_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($subscription->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount') ?></th>
                    <td><?= $this->Number->format($subscription->discount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start At') ?></th>
                    <td><?= h($subscription->start_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('End At') ?></th>
                    <td><?= h($subscription->end_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cancelled At') ?></th>
                    <td><?= h($subscription->cancelled_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($subscription->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($subscription->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Response Json') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($subscription->response_json)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
