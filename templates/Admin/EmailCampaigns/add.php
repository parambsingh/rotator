<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $emailCampaign
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Email Campaigns'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="emailCampaigns form content">
            <?= $this->Form->create($emailCampaign) ?>
            <fieldset>
                <legend><?= __('Add Email Campaign') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('from_email');
                    echo $this->Form->control('email_template_id');
                    echo $this->Form->control('send_at');
                    echo $this->Form->control('scheduled_count');
                    echo $this->Form->control('sent_count');
                    echo $this->Form->control('failed_count');
                    echo $this->Form->control('opened_count');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
