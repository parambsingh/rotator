<style>
    .actions{width: 33% !important;}
</style>
<?php
$params = [
    'heading' => 'Manage Distributor Position Sequence',
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
//        [
//            'name'    => 'position_no',
//            'label'   => 'Position Number',
//            'sort_by' => 'UsersPositions.position_no',
//        ],
        [
            'name'    => 'position_order',
            'sort_by' => 'UsersPositions.position_order',
            'label'   => 'Position Sequence',
        ],
        [
            'name'    => 'lead_limit',
            'sort_by' => 'UsersPositions.lead_limit',
            'label'   => 'Lead Count',
        ],
        [
            'name'    => 'occupied_leads',
            'sort_by' => 'UsersPositions.occupied_leads',
            'label'   => 'Occupied Leads',
        ],
        [
            'name'    => 'slot_status',
            'sort_by' => 'UsersPositions.slot_status',
            'label'   => 'Slot Status',
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
        'label' => 'Position Sequence',
        'url'   => ['controller' => 'Users', 'action' => 'getUserPosition'],
        'id'    => true,
        'class' => 'btn-u btn-u-sea btn-u-sm rounded change-position',
        'icon'  => 'fa fa-pencil'
    ],
    [
        'label' => 'Lead Count',
        'url'   => ['controller' => 'Users', 'action' => 'editUserPosition'],
        'id'    => true,
        'class' => 'btn-u btn-u-dark btn-u-sm rounded change-limit',
        'icon'  => 'fa fa-pencil'
    ],
    [
        'label' => 'Consecutive Leads',
        'url'   => ['controller' => 'Users', 'action' => 'getConsecutiveLimit'],
        'id'    => true,
        'class' => 'btn-u btn-u-danger btn-u-orange btn-u-sm rounded consecutive-limit',
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
                    positionX: 'center',
                    positionY: 'center',
                    speedIn: false,
                    speedOut: false,
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
    <h4 class="g-mb-20">Change Position Sequence</h4>
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
                    positionX: 'center',
                    positionY: 'center',
                    speedIn: false,
                    speedOut: false,
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
    <h4 class="g-mb-20">Update Lead Count</h4>
    <div calss="modal-body" id="changeLimit" style="position: relative;">
    </div>
    <div class="clear-both"></div>
</div>
<!-- End Demo modal window -->



<script>
    $(function () {
        //$.HSCore.components.HSModalWindow.init('[data-modal-target]');
        $('.consecutive-limit').click(function (e) {
            e.preventDefault();

            var newModal = new Custombox.modal({
                overlay: {
                    close: false
                },
                content: {
                    target: '#consecutiveLimitModal',
                    positionX: 'center',
                    positionY: 'center',
                    speedIn: false,
                    speedOut: false,
                    fullscreen: false,
                    onClose: function () {

                    }
                }
            });
            newModal.open();
            var url = 'admin/users/getConsecutiveLimit/' + $(this).attr('data-id');
            $.get(SITE_URL + url, function (data) {
                $("#consecutiveLimit").html(data);
            });

        });
    })
</script>

<!-- Demo modal window -->
<div id="consecutiveLimitModal" class="text-left g-bg-white g-overflow-y-auto  g-pa-20"
     style="max-height: 700px; max-width: 600px; display: none; width: 80%;  ">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <i class="hs-icon hs-icon-close"></i>
    </button>
    <h4 class="g-mb-20">Update Consecutive Leads</h4>
    <div calss="modal-body" id="consecutiveLimit" style="position: relative;">
    </div>
    <div class="clear-both"></div>
</div>
<!-- End Demo modal window -->