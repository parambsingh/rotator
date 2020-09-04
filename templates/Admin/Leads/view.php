<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $lead
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
                    <th><?= __('Image Id') ?></th>
                    <td><?= $this->Number->format($lead->image_id) ?></td>
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
        </div>
    </div>
</div>
