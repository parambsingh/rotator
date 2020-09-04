<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
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
                    <th><?= __('Plan') ?></th>
                    <td><?= $subscription->has('plan') ? $this->Html->link($subscription->plan->name, ['controller' => 'Plans', 'action' => 'view', $subscription->plan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $subscription->has('user') ? $this->Html->link($subscription->user->id, ['controller' => 'Users', 'action' => 'view', $subscription->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Coupon') ?></th>
                    <td><?= $subscription->has('coupon') ? $this->Html->link($subscription->coupon->name, ['controller' => 'Coupons', 'action' => 'view', $subscription->coupon->id]) : '' ?></td>
                </tr>
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
            <div class="related">
                <h4><?= __('Related Users Positions') ?></h4>
                <?php if (!empty($subscription->users_positions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Subscription Id') ?></th>
                            <th><?= __('Position No') ?></th>
                            <th><?= __('Position Order') ?></th>
                            <th><?= __('Subscription Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($subscription->users_positions as $usersPositions) : ?>
                        <tr>
                            <td><?= h($usersPositions->id) ?></td>
                            <td><?= h($usersPositions->user_id) ?></td>
                            <td><?= h($usersPositions->subscription_id) ?></td>
                            <td><?= h($usersPositions->position_no) ?></td>
                            <td><?= h($usersPositions->position_order) ?></td>
                            <td><?= h($usersPositions->subscription_status) ?></td>
                            <td><?= h($usersPositions->created) ?></td>
                            <td><?= h($usersPositions->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'UsersPositions', 'action' => 'view', $usersPositions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'UsersPositions', 'action' => 'edit', $usersPositions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UsersPositions', 'action' => 'delete', $usersPositions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersPositions->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
