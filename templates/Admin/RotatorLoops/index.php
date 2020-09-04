<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $rotatorLoops
 */
?>
<div class="rotatorLoops index content">
    <?= $this->Html->link(__('New Rotator Loop'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Rotator Loops') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('round_no') ?></th>
                    <th><?= $this->Paginator->sort('user_position_id') ?></th>
                    <th><?= $this->Paginator->sort('lead_id') ?></th>
                    <th><?= $this->Paginator->sort('lead_status') ?></th>
                    <th><?= $this->Paginator->sort('rf_status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rotatorLoops as $rotatorLoop): ?>
                <tr>
                    <td><?= $this->Number->format($rotatorLoop->id) ?></td>
                    <td><?= $this->Number->format($rotatorLoop->round_no) ?></td>
                    <td><?= $this->Number->format($rotatorLoop->user_position_id) ?></td>
                    <td><?= $this->Number->format($rotatorLoop->lead_id) ?></td>
                    <td><?= h($rotatorLoop->lead_status) ?></td>
                    <td><?= h($rotatorLoop->rf_status) ?></td>
                    <td><?= h($rotatorLoop->created) ?></td>
                    <td><?= h($rotatorLoop->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $rotatorLoop->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rotatorLoop->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rotatorLoop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rotatorLoop->id)]) ?>
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
