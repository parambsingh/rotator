<link href="https://vjs.zencdn.net/7.7.5/video-js.css" rel="stylesheet"/>
<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
<div id="videoPlayerListModal"
     class="text-left g-color-white g-bg-black g-overflow-y-auto "
     style="display: none; width: auto; min-width: 640px; height: auto; min-height: 480px; padding: 3%;">
    <button type="button" class="close" onclick="Custombox.modal.close();" style="margin: -50px -50px 0 0">
        <i class="hs-icon hs-icon-close"></i>
    </button>

    <div calss="modal-body text-center" style="position: relative;">
        <video
                id="tourVideoPlayerJS"
                class="video-js"
                controls
                preload="auto"
                width="640"
                height="480"
                data-setup="{}"
        ></video>
        <script src="https://vjs.zencdn.net/7.7.5/video.js"></script>

    </div>
    <div class="clear-both"></div>
</div>
<script>
    var vgsPlayer, poster, url;

    $(function () {
        $('.load-video-player').hide();
        setTimeout(function () {
            $('.load-video-player').fadeIn();
            vgsPlayer = videojs('tourVideoPlayerJS', {
                techOrder: ["html5"],
                autoplay: false,
            });

            vgsPlayer.poster("<?=  SITE_URL . 'files/images/default_video.png'; ?>");
        }, 1500);

        $('.container-fluid').on('click', '.load-video-player', function (e) {
            e.preventDefault();

            url = $(this).attr('data-url');
            poster = "<?=  SITE_URL . 'files/images/default_video.png'; ?>";


            var newModal = new Custombox.modal({
                content: {
                    target: '#videoPlayerListModal',
                    effect: 'slide',
                    animateFrom: 'top',
                    animateTo: 'bottom',
                    positionX: 'center',
                    positionY: 'center',
                    speedIn: 300,
                    speedOut: 300,
                    fullscreen: false,
                    onClose: function () {
                        vgsPlayer.pause();
                    },
                    onOpen: function () {
                        var v = "";
                        if (url.includes('mp4')) {
                            v = {
                                type: "video/mp4",
                                src: url
                            };
                        } else {
                            v = {
                                type: "video/webm",
                                src: url
                            }
                        }

                        vgsPlayer.src([v]);
                        vgsPlayer.poster(poster);
                        vgsPlayer.play();
                    }
                }
            });
            newModal.open();

        });
    });
</script>