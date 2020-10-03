<div style="padding:0px 20px 20px 0px">
    <em style="font-style:normal;border-bottom:1px dotted;font-size:1em;color:#000000;">
        Hi <?= $contactFirstName ?>,
    </em>
    <p style="font-size:1em;margin-top:15px;color:#000000;">I already emailed you this page, but wanted to make sure
        you got it.</p>
    <p style="font-size:1em;margin-top:15px;color:#000000;">Here's the <a href="<?= $url; ?>" style="color:#000000;">link</a>.</p>
    <p style="font-size:1em;margin-top:15px;color:#000000;">Please let me know if you have any questions. Look forward
        to seeing you there!</p>
</div>
<div style="padding:0px 20px 10px 0px">
    <p style="padding:0px;color:#000000; font-family:Arial, SanSerif; font-size:16px;">
        Thanks,<br/>
        <?= $distributorName ?><br/>
        <?= empty($distributorPhone) ? "" : $distributorPhone; ?>
    </p>
</div>