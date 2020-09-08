<?php
$params = [
    'heading' => 'Plans',
    'fields'  => [
        [
            'name'     => 'name'
        ],
        [
            'name'     => 'type'
        ],
        [
            'name'     => 'price',
        ],
        [
            'name'  => 'status',
            'label' => 'Status',
            'type'  => 'status',
            'model' => 'Plans',
        ],
        ['name'  => 'created'],
    ],
    'search'  => [
        'match' => [
            'Plans' => ['name', 'price']
        ]
    ]
];
$this->AdminListing->create($params);
