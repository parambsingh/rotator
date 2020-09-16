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
            'id' => 'addCityForm'
        ],
        'heading' => 'New City'
    ],
    'fields' => [
        [
            'name' => 'state_id',
            'type' => 'select',
            'options' => $states
        ],
        [
            'name' => 'empty',
        ],
        [
            'name' => 'name',
            'label' => 'City Name'
        ],
    ]
];

$this->AdminForm->create($params);
