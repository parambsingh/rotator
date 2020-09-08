<?php
$params = [
    'type'                 => 'Leads',
    'model'                => 'Leads',
    'mappingFields'       => [
        [
            'name'     => 'first_name',
            'label'    => 'First Name',
            'required' => true,
        ],
        [
            'name'     => 'last_name',
            'label'    => 'Last Name',
            'required' => true,
        ],
        [
            'name'     => 'email',
            'label'    => 'Email',
            'required' => true,
        ],
        [
            'name'     => 'home_email',
            'label'    => 'Home Email',
            'required' => false,
        ],
        [
            'name'     => 'work_email',
            'label'    => 'Work Email',
            'required' => false,
        ],
        [
            'name'     => 'other_email',
            'label'    => 'Other Email',
            'required' => false,
        ],
        [
            'name'     => 'phone',
            'label'    => 'Phone',
            'required' => false,
        ],
        [
            'name'     => 'home_phone',
            'label'    => 'Home Phone',
            'required' => false,
        ],
        [
            'name'     => 'work_phone',
            'label'    => 'Work Phone',
            'required' => false,
        ],
        [
            'name'     => 'other_phone',
            'label'    => 'Other Phone',
            'required' => false,
        ],

        [
            'name'     => 'address',
            'label'    => 'Address',
            'required' => false,
        ],
        [
            'name'     => 'city',
            'label'    => 'City',
            'required' => false,
        ],
        [
            'name'     => 'state',
            'label'    => 'State',
            'required' => false,
        ],
        [
            'name'     => 'zip',
            'label'    => 'Zip',
            'required' => false,
        ],
        [
            'name'     => 'company',
            'label'    => 'Company',
            'required' => false,
        ],
        [
            'name'     => 'interest',
            'label'    => 'Interest',
            'required' => false,
        ],
        [
            'name'     => 'note',
            'label'    => 'Note',
            'required' => false,
        ],

    ],
    'defaultValueFields' => [
        [
            'name'  => 'image_id',
            'value' => 0,
        ],
        [
            'name'  => 'status',
            'value' => true,
        ],
    ],
];
?>

<?= $this->element('Admin/import', $params) ?>