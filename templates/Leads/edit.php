<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lead $lead
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $lead->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $lead->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Leads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="leads form content">
            <?= $this->Form->create($lead) ?>
            <fieldset>
                <legend><?= __('Edit Lead') ?></legend>
                <?php
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('home_email');
                    echo $this->Form->control('work_email');
                    echo $this->Form->control('other_email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('forgot_password_token');
                    echo $this->Form->control('image_id', ['options' => $images]);
                    echo $this->Form->control('phone');
                    echo $this->Form->control('home_phone');
                    echo $this->Form->control('work_phone');
                    echo $this->Form->control('other_phone');
                    echo $this->Form->control('address');
                    echo $this->Form->control('city');
                    echo $this->Form->control('state');
                    echo $this->Form->control('zip');
                    echo $this->Form->control('role');
                    echo $this->Form->control('company');
                    echo $this->Form->control('interest');
                    echo $this->Form->control('note');
                    echo $this->Form->control('status');
                    echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
