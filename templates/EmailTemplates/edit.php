<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailTemplate $emailTemplate
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $emailTemplate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $emailTemplate->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Email Templates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="emailTemplates form content">
            <?= $this->Form->create($emailTemplate) ?>
            <fieldset>
                <legend><?= __('Edit Email Template') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('label');
                    echo $this->Form->control('subject');
                    echo $this->Form->control('template');
                    echo $this->Form->control('note');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
