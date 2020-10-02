Hi <?= $contactFirstName ?>,

I already emailed you this page, but wanted to make sure you got it.
Here's the link: <?= $url; ?>
Please let me know if you have any questions. Look forward to seeing you there!

Thanks,
<?= $distributorName ?>
<?= empty($distributorPhone) ? "" : $distributorPhone; ?>
