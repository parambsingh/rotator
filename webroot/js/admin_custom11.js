<script>
$(document).ready(function () {
    alert('okay');
    $('.active-deactive').click(function () {
        var model = $(this).attr('data-meodel');
        var field = $(this).attr('data-field');
        var id = $(this).attr('id').split('_')[1];
        $.ajax({
            url: SITE_URL + "/admin/admins/changeStatus/",
            type: "POST",
            data: {model, field, id,},
            dataType: "json",
            success: function (response) {

                if (response.code == 200) {
                    console.log(response);
                } else {
                    //$().showFlashMessage("error", response.message);
                }
            }
        });
    });

});
</script>
