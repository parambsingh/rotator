<?php
$params = [
    'fields' => [
        [
            'name'  => 'rf_contact',
            'label' => 'RF Contact ID'
        ],
        ['name' => 'first_name'],
        ['name' => 'last_name'],
        ['name' => 'email'],
        ['name' => 'phone'],
        [
            'name'  => 'status',
            'label' => 'Status',
            'type'  => 'status',
            'model' => 'Leads',
        ],
    ],
    'search' => [
        'match' => [
            'Leads' => ['first_name', 'last_name', 'email', 'phone']
        ]
    ]
];
$this->Listing->create($params, ['Edit', 'Delete']);
