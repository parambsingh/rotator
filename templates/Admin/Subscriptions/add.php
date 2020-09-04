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
            <?= $this->Html->link(__('List Subscriptions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="subscriptions form content">
            <?= $this->Form->create($subscription) ?>
            <fieldset>
                <legend><?= __('Add Subscription') ?></legend>
                <?php
                    echo $this->Form->control('plan_id');
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('coupon_id');
                    echo $this->Form->control('subscription_token');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('discount');
                    echo $this->Form->control('start_at');
                    echo $this->Form->control('end_at');
                    echo $this->Form->control('response_json');
                    echo $this->Form->control('status');
                    echo $this->Form->control('cancelled_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
