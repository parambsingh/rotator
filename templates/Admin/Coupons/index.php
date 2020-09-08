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
            'model' => 'Coupons',
        ],
        ['name'  => 'created'],
    ],
    'search'  => [
        'match' => [
            'Coupons' => ['name', 'discount']
        ]
    ]
];
$this->AdminListing->create($params);
