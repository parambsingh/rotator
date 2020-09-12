<?php
$params = [
    'heading' => 'Subscriptions',
    'fields'  => [
        [
            'name'     => 'plan_id',
            'related_model_fields'     => ['name'],
        ],
        [
            'name'     => 'user_id',
            'related_model_fields'     => ['name'],
        ],
        [
            'name'     => 'coupon_id',
            'related_model_fields'     => ['name'],
        ],
        //['name' => 'subscription_token'],
        ['name' => 'amount'],
        ['name'  => 'status'],
        ['name'  => 'created'],
    ],
    'search'  => [
        'match' => [
            'Subscriptions' => ['subscription_token', 'amount'],
            'Users' => ['name'],
        ]
    ]
];
$this->AdminListing->create($params, ['view']);
?>
<style>
    #topBreadcrumb{display: none !important;}
</style>
