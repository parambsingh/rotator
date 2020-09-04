<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $coupons
 */
?>
<div class="coupons index content">
    <?= $this->Html->link(__('New Coupon'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Coupons') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('discount') ?></th>
                    <th><?= $this->Paginator->sort('no_of_usage') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coupons as $coupon): ?>
                <tr>
                    <td><?= $this->Number->format($coupon->id) ?></td>
                    <td><?= h($coupon->name) ?></td>
                    <td><?= h($coupon->type) ?></td>
                    <td><?= $this->Number->format($coupon->discount) ?></td>
                    <td><?= $this->Number->format($coupon->no_of_usage) ?></td>
                    <td><?= h($coupon->status) ?></td>
                    <td><?= h($coupon->created) ?></td>
                    <td><?= h($coupon->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $coupon->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $coupon->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $coupon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coupon->id)]) ?>
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
