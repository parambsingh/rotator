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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rotatorLoop->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rotatorLoop->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Rotator Loops'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="rotatorLoops form content">
            <?= $this->Form->create($rotatorLoop) ?>
            <fieldset>
                <legend><?= __('Edit Rotator Loop') ?></legend>
                <?php
                    echo $this->Form->control('round_no');
                    echo $this->Form->control('user_position_id');
                    echo $this->Form->control('lead_id');
                    echo $this->Form->control('lead_status');
                    echo $this->Form->control('rf_status');
                    echo $this->Form->control('rf_response_json');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
