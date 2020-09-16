<?php
$params = [
    'heading' => 'Manage Distributor Position Order',
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
        ['name' => 'subscription_status'],
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
    ]
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
