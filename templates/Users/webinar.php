<?= $this->Html->script(['vendor/jquery/jquery.min']); ?>
<?= $this->Html->css(['vendor/bootstrap/bootstrap.min','vendor/icon-awesome/css/font-awesome.min']); ?>

<h3 id="webinarMessage" class="text-center mt-5">Processing, please wait... <i class="fa fa-asterisk fa-spin"></i></h3>
<script>
    var SITE_URL = "<?= SITE_URL; ?>";
    $(function () {
        $.ajax({
            url: SITE_URL + 'admin/webinars/getAccountDetail',
            type: "GET",
            dataType: "json",
            success: function (response) {

                $('#webinarMessage').html(response.message);
                setTimeout(function () {
                    window.close();
                    self.close();
                    web_window.close();
                }, 1000);

            }
        });
    });
</script>