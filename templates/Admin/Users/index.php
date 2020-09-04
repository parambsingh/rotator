<?php
$params = [
    'fields' => [
        [
            'name'     => 'image_id',
            'type'     => 'image',
            'sortable' => false,
            'label'    => '<i class="fa fa-picture-o"></i>'
        ],
        ['name' => 'first_name'],
        ['name' => 'last_name'],
        ['name' => 'email'],
        ['name' => 'phone'],
        [
            'name'  => 'status',
            'label' => 'Status',
            'type'  => 'status',
            'model' => 'Users',
        ],
    ],
    'search' => [
        'match' => [
            'Users' => ['first_name', 'last_name', 'email', 'phone']
        ]
    ]
];
$this->AdminListing->create($params, ['Edit', 'Delete']);
?>

