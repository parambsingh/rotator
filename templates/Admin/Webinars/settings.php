<form method="post" accept-charset="utf-8" novalidate="novalidate" id="webinarSettingForm"
      action="javascript:void(0);">
    <div class="card g-brd-gray-light-v7 g-rounded-3 g-mb-30">
        <header class="card-header g-brd-bottom-none g-px-15 g-px-30--sm g-pt-15 g-pt-20--sm g-pb-10 g-pb-15--sm">
            <div class="media">
                <h3 class="d-flex align-self-center text-uppercase g-font-size-12 g-font-size-default--md g-color-primary font-weight-bold g-mr-10 mb-0">
                    Webinar Client Setting</h3>
            </div>
        </header>

        <div class="card-block g-pa-15 g-pa-30--sm">
            <div class="row p-lg-4">

                <div class="col-md-4">
                    <div class="form-group g-mb-30">
                        <label class="g-mb-10" for="ClientId">Client ID</label>

                        <div class="g-pos-rel">

                            <input type="text" name="client_id"
                                   class="form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus rounded-0 g-px-14 g-py-10  not-ignore"
                                   id="ClientId"
                                   placeholder="Client ID"
                                   autocomplete="off"
                                   value="<?= $webinarAccount->client_id ?? ""; ?>"
                            >

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group g-mb-30">
                        <label class="g-mb-10" for="ClientSecret">Client Secret</label>

                        <div class="g-pos-rel">

                            <input type="text" name="client_secret"
                                   class="form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus rounded-0 g-px-14 g-py-10  not-ignore"
                                   id="ClientSecret"
                                   placeholder="Client Secret"
                                   autocomplete="off"
                                   value="<?= $webinarAccount->client_secret ?? ""; ?>"
                            >

                        </div>
                    </div>
                </div>
                <div class="col-md-2  g-mt-30">
                    <button type="submit" class="btn-u-md btn-u btn-u-blue rounded" id="webinarSettingBtn">
                        <?php if ($webinarAccount->status) { ?>
                            <i class="fa fa-refresh"></i> Refresh Token
                        <?php } else { ?>
                            <i class="fa fa-check"></i> Verify
                        <?php } ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var newWindow = null;
    $(function () {
        $('#webinarSettingForm').validate({
            rules: {
                client_id: {
                    required: true,
                },
                client_secret: {
                    required: true,
                }
            },
            messages: {
                client_id: {
                    required: "Please enter client id.",
                },
                client_secret: {
                    required: "Please enter client secret.",
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: SITE_URL + 'admin/webinars/saveSettings',
                    type: "POST",
                    data: $('#webinarSettingForm').serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $('#webinarSettingBtn').html('<i class="fa fa-asterisk fa-spin"></i>... please wait');
                    },
                    success: function (response) {
                        var url = "https://api.getgo.com/oauth/v2/authorize?client_id=" + $('#ClientId').val() + "&response_type=code&redirect_uri=<?= SITE_URL; ?>users/webinar";
                        newWindow = window.open(url, "WebinarWindow", 'height=600,width=800');
                        if (window.focus) {
                            newWindow.focus()
                        }

                        var timer = setInterval(function () {
                            if (newWindow.closed) {
                                clearInterval(timer);
                                $('#webinarSettingBtn').html('<i class="fa fa-check"></i> Verified');
                            }
                        }, 3000);
                    }
                });

                return false;
            }
        });

        // newWindow.onbeforeunload = function () {
        //     $('#webinarSettingBtn').html('<i class="fa fa-check"></i> Verify');
        // }
    });
</script>