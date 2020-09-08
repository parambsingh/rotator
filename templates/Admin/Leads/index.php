<?php
$params = [
    'fields' => [
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
            'Leads' => ['first_name', 'last_name', 'email', 'phone']
        ]
    ]
];
$this->AdminListing->create($params, ['Edit', 'Delete']);
