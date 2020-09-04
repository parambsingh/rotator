<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $plan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Plan'), ['action' => 'edit', $plan->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Plan'), ['action' => 'delete', $plan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $plan->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Plans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Plan'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="plans view content">
            <h3><?= h($plan->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($plan->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($plan->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($plan->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($plan->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Of Subscriptions') ?></th>
                    <td><?= $this->Number->format($plan->no_of_subscriptions) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($plan->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($plan->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $plan->status ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($plan->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
