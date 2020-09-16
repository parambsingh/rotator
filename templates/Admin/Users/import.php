<?php
$params = [
    'type'                 => 'Distributors',
    'model'                => 'Users',
    'mappingFields'       => [
        [
            'name'     => 'distributor_id',
            'label'    => 'Distributor ID',
            'required' => true,
        ],
        [
            'name'     => 'name',
            'label'    => 'Name',
            'required' => true,
        ],
        [
            'name'     => 'email',
            'label'    => 'Email',
            'required' => true,
        ],
        [
            'name'     => 'rf_email',
            'label'    => 'RF Email',
            'required' => true,
        ],
        [
            'name'     => 'phone',
            'label'    => 'Phone',
            'required' => false,
        ],
//        [
//            'name'     => 'position_no',
//            'label'    => 'Position No.',
//            'required' => false,
//        ],
        [
            'name'     => 'user_position',
            'label'    => 'Position Sequence',
            'required' => false,
        ],
        [
            'name'     => 'lead_limit',
            'label'    => 'Lead Count',
            'required' => false,
        ],
        [
            'name'     => 'address',
            'label'    => 'Address',
            'required' => false,
        ],
        [
            'name'     => 'city',
            'label'    => 'City',
            'required' => false,
        ],
        [
            'name'     => 'state',
            'label'    => 'State',
            'required' => false,
        ],
        [
            'name'     => 'zip',
            'label'    => 'Zip',
            'required' => false,
        ],
        [
            'name'     => 'created',
            'label'    => 'Created At',
            'required' => false,
        ],

    ],
    'defaultValueFields' => [
        [
            'name'  => 'password',
            'value' => "Test123",
        ],
        [
            'name'  => 'image_id',
            'value' => 0,
        ],
        [
            'name'  => 'status',
            'value' => true,
        ],
    ],
];
?>

<?= $this->element('Admin/importer', $params) ?>


