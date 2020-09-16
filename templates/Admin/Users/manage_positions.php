<style>
    .actions{width: 32% !important;}
</style>
<?php
$params = [
    'heading' => 'Distributors',
    'fields'  => [
        [
            'label'                => 'Name',
            'sort_by'              => 'Users.name',
            'name'                 => 'user_id',
            'related_model_fields' => ['name']
        ],
        [
            'label'                => 'Email',
            'sort_by'              => 'Users.email',
            'name'                 => 'user_id',
            'related_model_fields' => ['email']
        ],
        [
            'name'    => 'position_no',
            'label'   => 'Position Number',
            'sort_by' => 'UsersPositions.position_no',
        ],
        [
            'name'    => 'position_order',
            'sort_by' => 'UsersPositions.position_order',
            'label'   => 'Position Order',
        ],
        [
            'name'    => 'lead_limit',
            'sort_by' => 'UsersPositions.lead_limit',
            'label'   => 'Max Lead Limit',
        ],
        //['name' => 'subscription_status'],
    ],
    'search'  => [
        'match' => [
            'Users' => ['name', 'email', 'phone']
        ]
    ]
];

$this->AdminListing->create($params, [

    [
        'label' => 'Change Position Order',
        'url'   => ['controller' => 'Users', 'action' => 'getUserPosition'],
        'id'    => true,
        'class' => 'btn-u btn-u-sea btn-u-sm rounded change-position',
        'icon'  => 'fa fa-eye'
    ],
    [
        'label' => 'Update Max Lead Limit',
        'url'   => ['controller' => 'Users', 'action' => 'editUserPosition'],
        'id'    => true,
        'class' => 'btn-u btn-u-dark btn-u-sm rounded change-limit',
        'icon'  => 'fa fa-pencil'
    ],
]);
?>
<script>
    $(function () {
        //$.HSCore.components.HSModalWindow.init('[data-modal-target]');
        $('.change-position').click(function (e) {
            e.preventDefault();

            var newModal = new Custombox.modal({
                overlay: {
                    close: false
                },
                content: {
                    target: '#changePositionModal',
                    effect: 'slit',
                    animateFrom: 'left',
                    animateTo: 'left',
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
            var url = 'admin/users/getUserPosition/' + $(this).attr('data-id');
            $.get(SITE_URL + url, function (data) {
                $("#changePosition").html(data);
            });

        });
    })
</script>

<!-- Demo modal window -->
<div id="changePositionModal" class="text-left g-bg-white g-overflow-y-auto  g-pa-20"
     style="max-height: 700px; max-width: 600px; display: none; width: 80%;  ">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <i class="hs-icon hs-icon-close"></i>
    </button>
    <h4 class="g-mb-20">Change Position</h4>
    <div calss="modal-body" id="changePosition" style="position: relative;">
    </div>
    <div class="clear-both"></div>
</div>
<!-- End Demo modal window -->

<script>
    $(function () {
        //$.HSCore.components.HSModalWindow.init('[data-modal-target]');
        $('.change-limit').click(function (e) {
            e.preventDefault();

            var newModal = new Custombox.modal({
                overlay: {
                    close: false
                },
                content: {
                    target: '#changeLimitModal',
                    effect: 'slit',
                    animateFrom: 'left',
                    animateTo: 'left',
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
            var url = 'admin/users/editUserPositionLeadLimit/' + $(this).attr('data-id');
            $.get(SITE_URL + url, function (data) {
                $("#changeLimit").html(data);
            });

        });
    })
</script>

<!-- Demo modal window -->
<div id="changeLimitModal" class="text-left g-bg-white g-overflow-y-auto  g-pa-20"
     style="max-height: 700px; max-width: 600px; display: none; width: 80%;  ">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <i class="hs-icon hs-icon-close"></i>
    </button>
    <h4 class="g-mb-20">Update Max Lead Limit</h4>
    <div calss="modal-body" id="changeLimit" style="position: relative;">
    </div>
    <div class="clear-both"></div>
</div>
<!-- End Demo modal window -->
