<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    echo $this->Form->control('distibuter_id');
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('lead_email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('forgot_password_token');
                    echo $this->Form->control('image_id', ['options' => $images]);
                    echo $this->Form->control('phone');
                    echo $this->Form->control('address');
                    echo $this->Form->control('city');
                    echo $this->Form->control('state');
                    echo $this->Form->control('zip');
                    echo $this->Form->control('role');
                    echo $this->Form->control('status');
                    echo $this->Form->control('leads._ids', ['options' => $leads]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
