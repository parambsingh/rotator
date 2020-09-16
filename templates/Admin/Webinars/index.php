<style>
    #topBreadcrumb {
        display: none;
    }
</style>
<?php if (empty($webinarAccount)) { ?>
    <h3>Please enter API credentials - Go to <a href="<?= SITE_URL; ?>admin/webinars/settings">Settings</a></h3>
<?php } else { ?>
    <div class="card g-brd-gray-light-v7 g-rounded-3 g-mb-30">
        <header class="card-header g-brd-bottom-none g-px-15 g-px-30--sm g-pt-15 g-pt-20--sm g-pb-10 g-pb-15--sm">
            <div class="media">
                <h3 class="d-flex align-self-center text-uppercase g-font-size-12 g-font-size-default--md g-color-primary font-weight-bold g-mr-10 mb-0 w-100">
                    Webinars

                </h3>
                <button type="submit" class=" btn-u-md btn-u btn-u-blue rounded pull-right" id="webinarSettingBtn">
                    <?php if ($webinarAccount->status) { ?>
                        <i class="fa fa-refresh"></i> Refresh Token
                    <?php } else { ?>
                        <i class="fa fa-check"></i> Verify
                    <?php } ?>
                </button>
            </div>
        </header>

        <div class="card-block g-pa-15 g-pa-30--sm" id="loaderBox">
            <h5>Loading...<i class="fa fa-asterisk fa-spin"></i>
            </h5>
        </div>
        <div class="card-block g-pa-15 g-pa-30--sm" id="errorBox" style="display: none">
            <h3>Something went wrong, please refresh token.</h3>
        </div>
        <div class="card-block g-pa-15 g-pa-30--sm" id="webinarsBox" style="display: none">
            <div class="row text-bold">
                <div class="col-md-3">Name</div>
                <div class="col-md-3">Start At</div>
                <div class="col-md-3">End At</div>
                <div class="col-md-3">Description</div>
                <div class="col-md-12">
                    <hr/>
                </div>
            </div>
        </div>

    </div>
    <script>
        var newWindow = null;
        $(function () {
            $('#webinarSettingBtn').click(function () {
                var url = "https://api.getgo.com/oauth/v2/authorize?client_id=<?= $webinarAccount->client_id ?? ""; ?>&response_type=code&redirect_uri=<?= SITE_URL; ?>users/webinar";
                newWindow = window.open(url, "WebinarWindow", 'height=600,width=800');
                if (window.focus) {
                    newWindow.focus()
                }

                var timer = setInterval(function () {
                    if (newWindow.closed) {
                        clearInterval(timer);
                        window.location.reload();
                    }
                }, 3000);

            });

            setTimeout(function () {
                getWebinars();
            }, 1000);


            function getWebinars() {
                $.ajax({
                    url: SITE_URL + 'admin/webinars/getWebinars',
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        if (response.code == 200) {
                            $('#loaderBox').hide();
                            $('#webinarsBox').fadeIn();
                            $.each(response.data.webinars, function (ind, w) {
                                console.log(w);
                                $('#webinarsBox').append(renderWebinar(w));
                            });

                        } else {
                            $('#webinarsBox').html('<h4>Please Refresh the token</h4>');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#loaderBox').hide();
                        $('#errorBox').fadeIn();
                    }
                });
            }
        });

        function renderWebinar(w) {
            return `<div class="row"><div class="col-md-3">${w.subject}</div><div class="col-md-3">${w.times[0].startTime}</div><div class="col-md-3">${w.times[0].endTime}</div><div class="col-md-3">${w.description}</div><div class="col-md-12"><hr /></div></div>`;
        }
    </script>
<?php } ?>