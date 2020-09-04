<?php
echo $this->Html->css(['uploadfile']);
echo $this->Html->script(['jquery-ui', 'jquery.uploadfile', 'jquery.imgareaselect.min']);
?>
<div class="row">
    <div class="col-md-12">
        <!-- Tab panes -->
        <div id="nav-2-1-accordion-default-ver-big-icons" class="tab-content">
            <div class="tab-pane fade show active" id="nav-2-1-accordion-default-ver-big-icons--1" role="tabpanel">
                <div id="multipleFileUploader" style="display: none"></div>
                <input type="hidden" name="type" id="videoType" value="<?= $type; ?>"/>
                <input type="hidden" name="user" id="videoUserId" value="<?= $userId; ?>"/>
                <input type="hidden" name="category" id="videoCategory" value="<?= $category; ?>"/>
                <div class="file-upload-btn rounded-2x" id="videoUploadBtn">
                    <div
                            class="g-parent g-pos-rel g-height-230 g-bg-gray-light-v8--hover g-brd-around g-brd-style-dashed g-brd-gray-light-v7 g-brd-lightblue-v3--hover g-rounded-4 g-transition-0_2 g-transition--ease-in g-pa-15 g-pa-30--md g-mb-60">
                        <div class="d-md-flex align-items-center g-absolute-centered--md w-100 g-width-auto--md">
                            <div>
                                <div
                                        class="g-pos-rel g-width-80 g-width-100--lg g-height-80 g-height-100--lg g-bg-gray-light-v8 g-bg-white--parent-hover rounded-circle g-mb-20 g-mb-0--md g-transition-0_2 g-transition--ease-in mx-auto mx-0--md">
                                    <i class="fa fa-upload g-absolute-centered g-font-size-30 g-font-size-36--lg g-color-lightblue-v3"></i>
                                </div>
                            </div>
                            <div class="text-center text-md-left g-ml-20--md"><h3
                                        class="g-font-weight-400 g-font-size-16 g-color-black g-mb-10">Upload Your Video
                                    Tour</h3>
                                <p class="g-font-weight-300 g-color-black mb-0">Only MP4 & WEBM are supported.</p></div>
                        </div>
                    </div>
                </div>

                <div class="ajax-file-upload-container" id="ajaxContainer"></div>
                <label class="error" id="serverUploadError" style="display: none;">Something went wrong,
                    please try again.</label>

            </div>

            <div class="tab-pane fade" id="nav-2-1-accordion-default-ver-big-icons--2" role="tabpanel">
                <div class="row" id="galleryvideos"></div>
            </div>
            <button class="btn btn-primary" id="chooseSelectedvideo" style="display: none;">Choose</button>

        </div>

    </div>

</div>

<script>
    $(function () {

        var loadPage = 1;
        var loadingData = false;
        var thumbWidth = 200;
        var thumbHeight = 200;
        var $ias = null;

        $('#videoUploadBtn').on('click', function () {
            console.log('jjjjjjjjj');
            $('#ajax-upload-idVideo').click();
        });
        setTimeout(function () {
            $('#ajax-upload-idVideo').click();
        }, 300);


        var settings = {
            url: SITE_URL + "admin/images/upload-video",
            method: "POST",
            formData: {
                type: $('#videoType').val(),
                user_id: $('#videoUserId').val(),
                category: $('#videoCategory').val()
            },
            allowedTypes: "mp4,webm",
            fileName: "file",
            multiple: false,
            showQueueDiv: 'ajaxContainer',
            showError: true,
            dragdropWidth: '100%',
            statusBarWidth: '100%',
            showFileCounter: false,
            maxFileCount: 10,
            uniqueIdStr:"Video",
            onSuccess: function (files, data, xhr, pd) {
                var d = JSON.parse(data);
                if (d.code == 400) {
                    pd.progressbar.removeClass('ajax-file-upload-bar').addClass('ajax-file-upload-red').html("Failed");
                    $('#serverUploadError').html(d.message).fadeIn();
                } else {
                    localStorage.setItem('uploadedVideoId', d.data.id);
                    $('#ajaxContainer').html('');
                        $('.current-video-id').val(d.data.id);
                    $('.current-video').attr('src', SITE_URL + d.data.small_thumb);
                    $('.current-video').attr('data-file', SITE_URL + d.data.video);
                    var vType = "video/mp4";
                    if (d.data.video.includes('webm')) {
                        vType = "video/webm";
                    }
                    $('.current-video').next('.load-video-player').remove();

                    setTimeout(function () {
                        $('.current-video').after('<a class="u-badge-v4--lg g-width-100 g-height-100 g-mb-20 g-ml-20 load-video-player" href="javascript:void(0);" data-url="' + SITE_URL + d.data.video + '" data-type="' + vType + '" title="Click to Play" style="top:50%; right: 50%;"></a>')
                    }, 1000);
                    Custombox.modal.close();
                }
            },
            onSelect: function (files) {
            },
            onError: function (files, status, errMsg) {
                $("#finalStatus").html("<span color='red'>Upload is Failed</span>");
            }
        }
        $("#multipleFileUploader").uploadFile(settings);
    })
    ;
</script>
