<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 */
$params = [
    'form' => [
        'options' => [
            'type' => 'post',
            'novalidate' => true,
            'id' => 'addStateForm'
        ],
        'heading' => 'New State'
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
    ]
];

$this->AdminForm->create($params);

