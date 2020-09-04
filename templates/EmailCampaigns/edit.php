<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailCampaign $emailCampaign
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $emailCampaign->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $emailCampaign->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Email Campaigns'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="emailCampaigns form content">
            <?= $this->Form->create($emailCampaign) ?>
            <fieldset>
                <legend><?= __('Edit Email Campaign') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('from_email');
                    echo $this->Form->control('email_template_id', ['options' => $emailTemplates]);
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
