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
            <?= $this->Html->link(__('List Coupons'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="coupons form content">
            <?= $this->Form->create($coupon) ?>
            <fieldset>
                <legend><?= __('Add Coupon') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('type');
                    echo $this->Form->control('discount');
                    echo $this->Form->control('no_of_usage');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
