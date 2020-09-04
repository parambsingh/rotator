<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $coupon
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Coupon'), ['action' => 'edit', $coupon->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Coupon'), ['action' => 'delete', $coupon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coupon->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Coupons'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Coupon'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="coupons view content">
            <h3><?= h($coupon->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($coupon->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($coupon->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($coupon->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount') ?></th>
                    <td><?= $this->Number->format($coupon->discount) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Of Usage') ?></th>
                    <td><?= $this->Number->format($coupon->no_of_usage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($coupon->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($coupon->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $coupon->status ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($coupon->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
