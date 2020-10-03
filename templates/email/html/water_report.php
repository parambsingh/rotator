<div style="padding:0px 20px 20px 0px">
    <em style="font-style:normal;border-bottom:1px dotted;font-size:1em;color:#000000;">
        Hi <?= $contactFirstName ?>,
    </em>
    <p style="font-size:1em;margin-top:15px;color:#000000;">Here is your water report.</p>

    <p style="font-size:1em;margin-top:15px;color:#000000;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries. </p>
</div>
<div style="padding:0px 20px 10px 0px">
    <p style="padding:0px;color:#000000; font-family:Arial, SanSerif; font-size:16px;">
        Thanks,<br/>
        <?= $distributorName ?><br/>
        <?= empty($distributorPhone) ? "" : $distributorPhone; ?>
    </p>
</div>