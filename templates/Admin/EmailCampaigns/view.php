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
            <?= $this->Html->link(__('Edit Email Campaign'), ['action' => 'edit', $emailCampaign->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Email Campaign'), ['action' => 'delete', $emailCampaign->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailCampaign->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Email Campaigns'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Email Campaign'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="emailCampaigns view content">
            <h3><?= h($emailCampaign->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($emailCampaign->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('From Email') ?></th>
                    <td><?= h($emailCampaign->from_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($emailCampaign->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email Template Id') ?></th>
                    <td><?= $this->Number->format($emailCampaign->email_template_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scheduled Count') ?></th>
                    <td><?= $this->Number->format($emailCampaign->scheduled_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sent Count') ?></th>
                    <td><?= $this->Number->format($emailCampaign->sent_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Failed Count') ?></th>
                    <td><?= $this->Number->format($emailCampaign->failed_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Opened Count') ?></th>
                    <td><?= $this->Number->format($emailCampaign->opened_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Send At') ?></th>
                    <td><?= h($emailCampaign->send_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($emailCampaign->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($emailCampaign->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $emailCampaign->status ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
