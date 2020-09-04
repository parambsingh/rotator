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
            <?= $this->Html->link(__('Edit Email Template'), ['action' => 'edit', $emailTemplate->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Email Template'), ['action' => 'delete', $emailTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailTemplate->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Email Templates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Email Template'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="emailTemplates view content">
            <h3><?= h($emailTemplate->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $emailTemplate->has('user') ? $this->Html->link($emailTemplate->user->id, ['controller' => 'Users', 'action' => 'view', $emailTemplate->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Label') ?></th>
                    <td><?= h($emailTemplate->label) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($emailTemplate->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= $this->Number->format($emailTemplate->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($emailTemplate->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($emailTemplate->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $emailTemplate->status ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Template') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($emailTemplate->template)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Note') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($emailTemplate->note)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Email Campaigns') ?></h4>
                <?php if (!empty($emailTemplate->email_campaigns)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('From Email') ?></th>
                            <th><?= __('Email Template Id') ?></th>
                            <th><?= __('Send At') ?></th>
                            <th><?= __('Scheduled Count') ?></th>
                            <th><?= __('Sent Count') ?></th>
                            <th><?= __('Failed Count') ?></th>
                            <th><?= __('Opened Count') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($emailTemplate->email_campaigns as $emailCampaigns) : ?>
                        <tr>
                            <td><?= h($emailCampaigns->id) ?></td>
                            <td><?= h($emailCampaigns->name) ?></td>
                            <td><?= h($emailCampaigns->from_email) ?></td>
                            <td><?= h($emailCampaigns->email_template_id) ?></td>
                            <td><?= h($emailCampaigns->send_at) ?></td>
                            <td><?= h($emailCampaigns->scheduled_count) ?></td>
                            <td><?= h($emailCampaigns->sent_count) ?></td>
                            <td><?= h($emailCampaigns->failed_count) ?></td>
                            <td><?= h($emailCampaigns->opened_count) ?></td>
                            <td><?= h($emailCampaigns->status) ?></td>
                            <td><?= h($emailCampaigns->created) ?></td>
                            <td><?= h($emailCampaigns->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'EmailCampaigns', 'action' => 'view', $emailCampaigns->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'EmailCampaigns', 'action' => 'edit', $emailCampaigns->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailCampaigns', 'action' => 'delete', $emailCampaigns->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailCampaigns->id)]) ?>
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
