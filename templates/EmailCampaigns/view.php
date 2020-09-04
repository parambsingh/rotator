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
                    <th><?= __('Email Template') ?></th>
                    <td><?= $emailCampaign->has('email_template') ? $this->Html->link($emailCampaign->email_template->id, ['controller' => 'EmailTemplates', 'action' => 'view', $emailCampaign->email_template->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($emailCampaign->id) ?></td>
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
            <div class="related">
                <h4><?= __('Related Email Campaign Recipients') ?></h4>
                <?php if (!empty($emailCampaign->email_campaign_recipients)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email Campaign Id') ?></th>
                            <th><?= __('To Email') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Lead Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('No Of Attempts') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($emailCampaign->email_campaign_recipients as $emailCampaignRecipients) : ?>
                        <tr>
                            <td><?= h($emailCampaignRecipients->id) ?></td>
                            <td><?= h($emailCampaignRecipients->email_campaign_id) ?></td>
                            <td><?= h($emailCampaignRecipients->to_email) ?></td>
                            <td><?= h($emailCampaignRecipients->user_id) ?></td>
                            <td><?= h($emailCampaignRecipients->lead_id) ?></td>
                            <td><?= h($emailCampaignRecipients->status) ?></td>
                            <td><?= h($emailCampaignRecipients->no_of_attempts) ?></td>
                            <td><?= h($emailCampaignRecipients->created) ?></td>
                            <td><?= h($emailCampaignRecipients->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'EmailCampaignRecipients', 'action' => 'view', $emailCampaignRecipients->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'EmailCampaignRecipients', 'action' => 'edit', $emailCampaignRecipients->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailCampaignRecipients', 'action' => 'delete', $emailCampaignRecipients->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailCampaignRecipients->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
