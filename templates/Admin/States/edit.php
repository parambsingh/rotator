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
            'id' => 'editStateForm'
        ],
        'heading' => 'Edit State'
    ],
    'fields' => [
        [
            'name' => 'name'
        ],
        [
            'name'=>'empty',
        ],
        [
            'name' => 'short_name'
        ],
        [
            'name'=>'empty',
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
