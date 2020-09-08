<?php
$params = [
    'heading' => 'Distributors',
    'fields'  => [
        [
            'name'     => 'image_id',
            'type'     => 'image',
            'sortable' => false,
            'label'    => '<i class="fa fa-picture-o"></i>'
        ],
        ['name' => 'name'],
        ['name' => 'email'],
    //        [
    //            'name' => 'rf_email',
    //            'label' => 'RF Email',
    //        ],
        ['name' => 'phone'],
        [
            'name'  => 'status',
            'label' => 'Status',
            'type'  => 'status',
            'model' => 'Users',
        ],
    ],
    'search'  => [
        'match' => [
            'Users' => ['first_name', 'last_name', 'email', 'phone']
        ]
    ]
];
$this->AdminListing->create($params, ['Edit', 'Delete']);
?>

