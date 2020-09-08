<?php
$params = [
    'form'   => [
        'options' => [
            'type'       => 'post',
            'novalidate' => true,
            'id'         => 'addForm'
        ],
        'heading' => 'New Coupon'
    ],
    'fields' => [
        [
            'name'  => 'status',
            'type'  => 'hidden',
            'value' => 1
        ],
        [
            'name'  => 'no_of_subscriptions',
            'type'  => 'hidden',
            'value' => 0
        ],
        [ 'name'  => 'name'],
        [ 'name'  => 'empty'],
        [
            'name'     => 'description',
            'type'     => 'textarea',
            'validate' => [
                'rules' => [
                    'required' => false
                ],

            ]
        ],
        [ 'name'  => 'empty'],
        [
            'name' => 'type',
            'type' => 'select',
            'options' => ['$'=>'$', '%'=>'%'],
            'style' => "height:42px !important;",
        ],
        [ 'name'  => 'empty'],
        [
            'name' => 'discount',
            'type' => 'number',
        ],
    ]
];
$this->AdminForm->create($params);
?>