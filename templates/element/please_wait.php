<div id="pleaseWaitModal"
     class="text-left g-color-gray-dark-v1 g-bg-white g-overflow-y-auto  g-pa-20"
     style="display: none; width: auto; height: auto; padding: 10%; background-color: #007eef !important; color: #ffffff !important;">

    <div calss="modal-body" style="position: relative;">
        <div class="row">
            <div class="col-md-12 g-color-white">
                <h3 class="g-color-white"><span id="pleaseWaitMsg">Please wait ... </span><i class="fa fa-spin fa-spinner"></i></h3>

            </div>
        </div>
    </div>
    <div class="clear-both"></div>
</div>
<script>
    function pleaseWait(pleaseWaitMsg) {
        if(typeof pleaseWaitMsg != "undefined"){
            $('#pleaseWaitMsg').html(pleaseWaitMsg);
        }
        var pleaseWaitModal = new Custombox.modal({
            content: {
                target: '#pleaseWaitModal',
                id: 'pleaseWaitModal',
                effect: 'slide',
                speedIn: 300,
                speedOut: 300,
                fullscreen: false,
                onClose: function () {
                    //Do Something here
                }
            }
        });
        pleaseWaitModal.open();
    }
</script>