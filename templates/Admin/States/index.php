<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State[]|\Cake\Collection\CollectionInterface $states
 */

$params = [
    'fields' => [
        ['name' => 'name'],
        ['name' => 'short_name'],
        [
            'name' => 'status',
            'type' => 'status',
            'model' => 'States'
        ]
    ]
];

$this->AdminListing->create($params, ['edit', 'delete']);
