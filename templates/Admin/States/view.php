<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit State'), ['action' => 'edit', $state->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete State'), ['action' => 'delete', $state->id], ['confirm' => __('Are you sure you want to delete # {0}?', $state->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List States'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New State'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="states view content">
            <h3><?= h($state->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($state->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Short Name') ?></th>
                    <td><?= h($state->short_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($state->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($state->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($state->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $state->status ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cities') ?></h4>
                <?php if (!empty($state->cities)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('State Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('State Code') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($state->cities as $cities) : ?>
                        <tr>
                            <td><?= h($cities->id) ?></td>
                            <td><?= h($cities->state_id) ?></td>
                            <td><?= h($cities->name) ?></td>
                            <td><?= h($cities->state_code) ?></td>
                            <td><?= h($cities->status) ?></td>
                            <td><?= h($cities->created) ?></td>
                            <td><?= h($cities->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Cities', 'action' => 'view', $cities->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Cities', 'action' => 'edit', $cities->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cities', 'action' => 'delete', $cities->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cities->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Leads') ?></h4>
                <?php if (!empty($state->leads)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Home Email') ?></th>
                            <th><?= __('Work Email') ?></th>
                            <th><?= __('Other Email') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Home Phone') ?></th>
                            <th><?= __('Work Phone') ?></th>
                            <th><?= __('Other Phone') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('City Id') ?></th>
                            <th><?= __('State Id') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Company') ?></th>
                            <th><?= __('Interest') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Ip') ?></th>
                            <th><?= __('Lead From') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($state->leads as $leads) : ?>
                        <tr>
                            <td><?= h($leads->id) ?></td>
                            <td><?= h($leads->user_id) ?></td>
                            <td><?= h($leads->first_name) ?></td>
                            <td><?= h($leads->last_name) ?></td>
                            <td><?= h($leads->email) ?></td>
                            <td><?= h($leads->home_email) ?></td>
                            <td><?= h($leads->work_email) ?></td>
                            <td><?= h($leads->other_email) ?></td>
                            <td><?= h($leads->image_id) ?></td>
                            <td><?= h($leads->phone) ?></td>
                            <td><?= h($leads->home_phone) ?></td>
                            <td><?= h($leads->work_phone) ?></td>
                            <td><?= h($leads->other_phone) ?></td>
                            <td><?= h($leads->address) ?></td>
                            <td><?= h($leads->city_id) ?></td>
                            <td><?= h($leads->state_id) ?></td>
                            <td><?= h($leads->zip) ?></td>
                            <td><?= h($leads->role) ?></td>
                            <td><?= h($leads->company) ?></td>
                            <td><?= h($leads->interest) ?></td>
                            <td><?= h($leads->note) ?></td>
                            <td><?= h($leads->ip) ?></td>
                            <td><?= h($leads->lead_from) ?></td>
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
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($state->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Distributor Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Rf Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Forgot Password Token') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('City Id') ?></th>
                            <th><?= __('State Id') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($state->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->distributor_id) ?></td>
                            <td><?= h($users->name) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->rf_email) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->forgot_password_token) ?></td>
                            <td><?= h($users->image_id) ?></td>
                            <td><?= h($users->phone) ?></td>
                            <td><?= h($users->address) ?></td>
                            <td><?= h($users->city_id) ?></td>
                            <td><?= h($users->state_id) ?></td>
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
        </div>
    </div>
</div>
