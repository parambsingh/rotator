<script>
    $(function () {
        $('.load-video-media').click(function (e) {
            e.preventDefault();

            var newModal = new Custombox.modal({
                overlay: {
                    close: false
                },
                content: {
                    target: '#videoMediaModal',
                    id: 'videoMediaModal',
                    effect: 'slide',
                    animateFrom: 'top',
                    animateTo: 'top',
                    positionX: 'center',
                    positionY: 'center',
                    speedIn: 300,
                    speedOut: 300,
                    fullscreen: false,
                    onClose: function () {
                    }
                }
            });
            newModal.open();

            $("#videoMedia").html("Loading ..");
            $('.loaded-video-id').removeClass('current-video-id');
            $(this).children('input').addClass('current-video-id');
            $('.loaded-video').removeClass('current-video');
            $(this).next('img').addClass('current-video');
            localStorage.setItem('uploadedVideoId', $(this).attr('data-video_id'));
            var url = 'admin/images/videoMedia/' + $(this).attr('data-model') + "/" + $(this).attr('data-category') + "/" + $(this).attr('data-user_id');
            $.get(SITE_URL + url, function (data) {
                $("#videoMedia").html(data);
            });
        });
    });
</script>

<!-- Demo modal window -->
<div id="videoMediaModal" class="text-left g-bg-white g-overflow-y-auto  g-pa-20 box-shadow"
     style="z-index:99999999; max-height: 600px; max-width: 1000px; display: none; width: 80%;  min-width: 800px;    min-height: 300px; ">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <i class="hs-icon hs-icon-close"></i>
    </button>
    <h4 class="g-mb-20">Upload Video</h4>
    <div calss="modal-body" id="videoMedia" style="position: relative;">
        Loading ...
    </div>
    <div class="clear-both"></div>
</div>
<!-- End Demo modal window -->
