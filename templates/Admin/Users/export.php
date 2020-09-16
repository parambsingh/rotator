<?php
$params = [
    'type'               => 'Distributors',
    'model'              => 'Users',
    'relatedModels'      => ['UsersPositions', 'States', 'Cities'],
    'mappingFields'      => [
        [
            'name'     => 'Users.distributor_id',
            'as'     => 'Users__distributor_id',
            'label'    => 'Distributor ID',
            'required' => true,
        ],
        [
            'name'     => 'Users.name',
            'as'     => 'Users__name',
            'label'    => 'Name',
            'required' => true,
        ],
        [
            'name'     => 'Users.email',
            'as'     => 'Users__email',
            'label'    => 'Email',
            'required' => true,
        ],
        [
            'name'     => 'Users.rf_email',
            'as'     => 'Users__rf_email',
            'label'    => 'RF Email',
            'required' => true,
        ],
        [
            'name'     => 'Users.phone',
            'as'     => 'Users__phone',
            'label'    => 'Phone',
            'required' => false,
        ],
//        [
//            'name'     => 'UsersPositions.position_no',
//            'as'     => 'Users__position_no',
//            'label'    => 'Position No.',
//            'required' => false,
//        ],
        [
            'name'     => 'UsersPositions.position_order',
            'as'     => 'Users__position_sequence',
            'label'    => 'Position Sequence',
            'required' => false,
        ],
        [
            'name'     => 'UsersPositions.lead_limit',
            'as'     => 'Users__lead_count',
            'label'    => 'Lead Count',
            'required' => false,
        ],
        [
            'name'     => 'Users.address',
            'as'     => 'Users__address',
            'label'    => 'Address',
            'required' => false,
        ],
        [
            'name'     => 'Cities.name',
            'as'     => 'Users__city',
            'label'    => 'City',
            'required' => false,
        ],
        [
            'name'     => 'States.name',
            'as'     => 'Users__state',
            'label'    => 'State',
            'required' => false,
        ],
        [
            'name'     => 'Users.zip',
            'as'     => 'Users__zip',
            'label'    => 'Zip',
            'required' => false,
        ],
        [
            'name'     => 'Users.created',
            'as'     => 'Users__created',
            'label'    => 'Created At',
            'required' => false,
        ],

    ],
    'defaultValueFields' => [
        [
            'name' => 'Users.id',
            'as' => 'Users__id',
        ],
        [
            'name' => 'UsersPositions.id',
            'as' => 'UsersPositions__id',
        ],
        [
            'name' => 'States.id',
            'as' => 'States__id',
        ],
        [
            'name' => 'Cities.id',
            'as' => 'Cities__id',
        ],
    ],
];
?>

<?= $this->element('Admin/exporter', $params) ?>