<?php
$params = [
    'heading' => 'Lead Logs',
    'fields'   => [
        ['name' => 'first_name'],
        ['name' => 'last_name'],
        ['name' => 'email'],
        ['name' => 'phone'],
        ['name' => 'status'],
        ['name' => 'created'],
    ],
    'search'   => [
        'match' => [
            'Leads' => ['first_name', 'last_name', 'email', 'phone']
        ]
    ]
];
$this->AdminListing->create($params, [
    [
        'label' => 'Detail',
        'url'   => ['controller' => 'Leads', 'action' => 'viewLog'],
        'id'    => true,
        'class' => 'btn-u btn-u-sea btn-u-sm rounded',
        'icon'  => 'fa fa-eye'
    ],
    'Delete' => [
        'url' => [
            'controller' => 'Leads', 'action' => 'deleteLog'
        ]
    ]
]);
