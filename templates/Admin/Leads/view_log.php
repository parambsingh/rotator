<style>
    .table tr {width:100%;}
    .table tr th {width:30% !important; float: left;}
    .table tr td {width:70% !important; float: left;}
</style>
<div class="row">
    <div class="col-md-1">&nbsp;</div>
    <div class="col-md-10">
        <div class="leads view content">
            <h3><?= h($lead->email) ?></h3>
            <table class="table">
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
                    <th><?= __('IP') ?></th>
                    <td><?= h($lead->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lead From') ?></th>
                    <td><?= h($lead->lead_from) ?></td>
                </tr>
                <tr>
                    <th><?= __('Request JSON') ?></th>
                    <td><?= json_encode(json_decode($lead->request_json), JSON_PRETTY_PRINT) ?></td>
                </tr>
                <tr>
                    <th><?= __('Response JSON') ?></th>
                    <td><?= json_encode(json_decode($lead->response_json), JSON_PRETTY_PRINT) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($lead->status) ?></td>
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

        </div>
    </div>
</div>
