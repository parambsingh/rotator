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
            <?= $this->Html->link(__('Edit Lead'), ['action' => 'edit', $lead->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Lead'), ['action' => 'delete', $lead->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lead->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Leads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Lead'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="leads view content">
            <h3><?= h($lead->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($lead->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($lead->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($lead->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Home Email') ?></th>
                    <td><?= h($lead->home_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Work Email') ?></th>
                    <td><?= h($lead->work_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Other Email') ?></th>
                    <td><?= h($lead->other_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($lead->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Forgot Password Token') ?></th>
                    <td><?= h($lead->forgot_password_token) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><?= $lead->has('image') ? $this->Html->link($lead->image->id, ['controller' => 'Images', 'action' => 'view', $lead->image->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($lead->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Home Phone') ?></th>
                    <td><?= h($lead->home_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Work Phone') ?></th>
                    <td><?= h($lead->work_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Other Phone') ?></th>
                    <td><?= h($lead->other_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($lead->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($lead->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= h($lead->state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($lead->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($lead->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= h($lead->company) ?></td>
                </tr>
                <tr>
                    <th><?= __('Interest') ?></th>
                    <td><?= h($lead->interest) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($lead->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($lead->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($lead->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $lead->status ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Note') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($lead->note)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($lead->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Distibuter Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Lead Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Forgot Password Token') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('State') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($lead->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->distibuter_id) ?></td>
                            <td><?= h($users->first_name) ?></td>
                            <td><?= h($users->last_name) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->lead_email) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->forgot_password_token) ?></td>
                            <td><?= h($users->image_id) ?></td>
                            <td><?= h($users->phone) ?></td>
                            <td><?= h($users->address) ?></td>
                            <td><?= h($users->city) ?></td>
                            <td><?= h($users->state) ?></td>
                            <td><?= h($users->zip) ?></td>
                            <td><?= h($users->role) ?></td>
                            <td><?= h($users->status) ?></td>
                            <td><?= h($users->created) ?></td>
                            <td><?= h($users->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Email Campaign Recipients') ?></h4>
                <?php if (!empty($lead->email_campaign_recipients)) : ?>
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
                        <?php foreach ($lead->email_campaign_recipients as $emailCampaignRecipients) : ?>
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
            <div class="related">
                <h4><?= __('Related Rotator Loops') ?></h4>
                <?php if (!empty($lead->rotator_loops)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Round No') ?></th>
                            <th><?= __('User Position Id') ?></th>
                            <th><?= __('Lead Id') ?></th>
                            <th><?= __('Lead Status') ?></th>
                            <th><?= __('Rf Status') ?></th>
                            <th><?= __('Rf Response Json') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($lead->rotator_loops as $rotatorLoops) : ?>
                        <tr>
                            <td><?= h($rotatorLoops->id) ?></td>
                            <td><?= h($rotatorLoops->round_no) ?></td>
                            <td><?= h($rotatorLoops->user_position_id) ?></td>
                            <td><?= h($rotatorLoops->lead_id) ?></td>
                            <td><?= h($rotatorLoops->lead_status) ?></td>
                            <td><?= h($rotatorLoops->rf_status) ?></td>
                            <td><?= h($rotatorLoops->rf_response_json) ?></td>
                            <td><?= h($rotatorLoops->created) ?></td>
                            <td><?= h($rotatorLoops->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'RotatorLoops', 'action' => 'view', $rotatorLoops->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'RotatorLoops', 'action' => 'edit', $rotatorLoops->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'RotatorLoops', 'action' => 'delete', $rotatorLoops->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rotatorLoops->id)]) ?>
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
