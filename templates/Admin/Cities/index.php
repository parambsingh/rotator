<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\City[]|\Cake\Collection\CollectionInterface $cities
 */

$params = [
    'fields' => [
        ['name' => 'name'],
        ['name' => 'state_code'],
        [
            'name' => 'status',
            'type' => 'status',
            'model' => 'Cities'
        ]
    ],
    'search' => [
        'match' => [
            'Cities' => ['name', 'state_code']
        ]
    ]
];

$this->AdminListing->create($params, ['edit', 'delete']);
