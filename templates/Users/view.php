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
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($user->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($user->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lead Email') ?></th>
                    <td><?= h($user->lead_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Forgot Password Token') ?></th>
                    <td><?= h($user->forgot_password_token) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><?= $user->has('image') ? $this->Html->link($user->image->id, ['controller' => 'Images', 'action' => 'view', $user->image->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($user->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($user->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($user->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= h($user->state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($user->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Distibuter Id') ?></th>
                    <td><?= $this->Number->format($user->distibuter_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $user->status ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Leads') ?></h4>
                <?php if (!empty($user->leads)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Home Email') ?></th>
                            <th><?= __('Work Email') ?></th>
                            <th><?= __('Other Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Forgot Password Token') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Home Phone') ?></th>
                            <th><?= __('Work Phone') ?></th>
                            <th><?= __('Other Phone') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('State') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Company') ?></th>
                            <th><?= __('Interest') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->leads as $leads) : ?>
                        <tr>
                            <td><?= h($leads->id) ?></td>
                            <td><?= h($leads->first_name) ?></td>
                            <td><?= h($leads->last_name) ?></td>
                            <td><?= h($leads->email) ?></td>
                            <td><?= h($leads->home_email) ?></td>
                            <td><?= h($leads->work_email) ?></td>
                            <td><?= h($leads->other_email) ?></td>
                            <td><?= h($leads->password) ?></td>
                            <td><?= h($leads->forgot_password_token) ?></td>
                            <td><?= h($leads->image_id) ?></td>
                            <td><?= h($leads->phone) ?></td>
                            <td><?= h($leads->home_phone) ?></td>
                            <td><?= h($leads->work_phone) ?></td>
                            <td><?= h($leads->other_phone) ?></td>
                            <td><?= h($leads->address) ?></td>
                            <td><?= h($leads->city) ?></td>
                            <td><?= h($leads->state) ?></td>
                            <td><?= h($leads->zip) ?></td>
                            <td><?= h($leads->role) ?></td>
                            <td><?= h($leads->company) ?></td>
                            <td><?= h($leads->interest) ?></td>
                            <td><?= h($leads->note) ?></td>
                            <td><?= h($leads->status) ?></td>
                            <td><?= h($leads->created) ?></td>
                            <td><?= h($leads->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Leads', 'action' => 'view', $leads->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Leads', 'action' => 'edit', $leads->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Leads', 'action' => 'delete', $leads->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leads->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Email Campaign Recipients') ?></h4>
                <?php if (!empty($user->email_campaign_recipients)) : ?>
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
                        <?php foreach ($user->email_campaign_recipients as $emailCampaignRecipients) : ?>
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
                <h4><?= __('Related Email Templates') ?></h4>
                <?php if (!empty($user->email_templates)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Label') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Template') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->email_templates as $emailTemplates) : ?>
                        <tr>
                            <td><?= h($emailTemplates->id) ?></td>
                            <td><?= h($emailTemplates->user_id) ?></td>
                            <td><?= h($emailTemplates->label) ?></td>
                            <td><?= h($emailTemplates->subject) ?></td>
                            <td><?= h($emailTemplates->template) ?></td>
                            <td><?= h($emailTemplates->note) ?></td>
                            <td><?= h($emailTemplates->status) ?></td>
                            <td><?= h($emailTemplates->created) ?></td>
                            <td><?= h($emailTemplates->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'EmailTemplates', 'action' => 'view', $emailTemplates->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'EmailTemplates', 'action' => 'edit', $emailTemplates->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailTemplates', 'action' => 'delete', $emailTemplates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailTemplates->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Subscriptions') ?></h4>
                <?php if (!empty($user->subscriptions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Plan Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Coupon Id') ?></th>
                            <th><?= __('Subscription Token') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Discount') ?></th>
                            <th><?= __('Start At') ?></th>
                            <th><?= __('End At') ?></th>
                            <th><?= __('Response Json') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Cancelled At') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->subscriptions as $subscriptions) : ?>
                        <tr>
                            <td><?= h($subscriptions->id) ?></td>
                            <td><?= h($subscriptions->plan_id) ?></td>
                            <td><?= h($subscriptions->user_id) ?></td>
                            <td><?= h($subscriptions->coupon_id) ?></td>
                            <td><?= h($subscriptions->subscription_token) ?></td>
                            <td><?= h($subscriptions->amount) ?></td>
                            <td><?= h($subscriptions->discount) ?></td>
                            <td><?= h($subscriptions->start_at) ?></td>
                            <td><?= h($subscriptions->end_at) ?></td>
                            <td><?= h($subscriptions->response_json) ?></td>
                            <td><?= h($subscriptions->status) ?></td>
                            <td><?= h($subscriptions->cancelled_at) ?></td>
                            <td><?= h($subscriptions->created) ?></td>
                            <td><?= h($subscriptions->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Subscriptions', 'action' => 'view', $subscriptions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Subscriptions', 'action' => 'edit', $subscriptions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Subscriptions', 'action' => 'delete', $subscriptions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscriptions->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users Positions') ?></h4>
                <?php if (!empty($user->users_positions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Subscription Id') ?></th>
                            <th><?= __('Position No') ?></th>
                            <th><?= __('Position Order') ?></th>
                            <th><?= __('Subscription Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->users_positions as $usersPositions) : ?>
                        <tr>
                            <td><?= h($usersPositions->id) ?></td>
                            <td><?= h($usersPositions->user_id) ?></td>
                            <td><?= h($usersPositions->subscription_id) ?></td>
                            <td><?= h($usersPositions->position_no) ?></td>
                            <td><?= h($usersPositions->position_order) ?></td>
                            <td><?= h($usersPositions->subscription_status) ?></td>
                            <td><?= h($usersPositions->created) ?></td>
                            <td><?= h($usersPositions->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'UsersPositions', 'action' => 'view', $usersPositions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'UsersPositions', 'action' => 'edit', $usersPositions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UsersPositions', 'action' => 'delete', $usersPositions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersPositions->id)]) ?>
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
