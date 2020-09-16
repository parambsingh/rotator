<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BadWord $badWord
 */
$params = [
    'form' => [
        'options' => [
            'type' => 'post',
            'novalidate' => true,
            'id' => 'editCityForm'
        ],
        'heading' => 'Edit City'
    ],
    'fields' => [
        [
            'name' => 'state_id',
            'type'=>'select',
            'options'=>$states
        ],
        [
            'name'=>'empty',
        ],
        [
            'name' => 'name',
            'label' => 'City Name'
        ],
        [
            'name' => 'status',
            'type' => 'toggle',
            'columns' => 12,
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]
        ]
    ]
];

$this->AdminForm->create($params);
