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
            <?= $this->Html->link(__('List Plans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="plans form content">
            <?= $this->Form->create($plan) ?>
            <fieldset>
                <legend><?= __('Add Plan') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('type');
                    echo $this->Form->control('price');
                    echo $this->Form->control('no_of_subscriptions');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
