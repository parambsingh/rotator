<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $rotatorLoop
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Rotator Loop'), ['action' => 'edit', $rotatorLoop->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Rotator Loop'), ['action' => 'delete', $rotatorLoop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rotatorLoop->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Rotator Loops'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Rotator Loop'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="rotatorLoops view content">
            <h3><?= h($rotatorLoop->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Lead Status') ?></th>
                    <td><?= h($rotatorLoop->lead_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rf Status') ?></th>
                    <td><?= h($rotatorLoop->rf_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($rotatorLoop->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Round No') ?></th>
                    <td><?= $this->Number->format($rotatorLoop->round_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Position Id') ?></th>
                    <td><?= $this->Number->format($rotatorLoop->user_position_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lead Id') ?></th>
                    <td><?= $this->Number->format($rotatorLoop->lead_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($rotatorLoop->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($rotatorLoop->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Rf Response Json') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($rotatorLoop->rf_response_json)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
