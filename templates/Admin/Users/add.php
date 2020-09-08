<?php
$params = [
    'form'   => [
        'options' => [
            'type'       => 'post',
            'novalidate' => true,
            'id'         => 'addForm'
        ],
        'heading' => 'New Distributor'
    ],
    'fields' => [
        [
            'name'  => 'status',
            'type'  => 'hidden',
            'value' => 1
        ],
        [
            'name'  => 'role',
            'type'  => 'hidden',
            'value' => 'Distributor'
        ],
        [
            'name'  => 'distributor_id'
        ],
        [
            'name'  => 'name'
        ],
        [
            'name'     => 'email',
            'validate' => [
                'rules' => [
                    'required' => true,
                    'email'    => true,
                    'remote'   => SITE_URL . 'admin/admins/isUniqueEmail',
                ],

            ]
        ],
        [
            'name'     => 'rf_email',
            'label' => 'RF Email',
            'validate' => [
                'rules' => [
                    'required' => false,
                    'email'    => true,
                ],

            ]
        ],
        [
            'name' => 'password',
            'type' => 'password',
            'value' => 'Rotator123',
        ],
        [
            'name' => 'phone',
            'validate' => [
                'rules' => [
                    'required'  => false,
                    'maxlength' => 13,
                ]
            ]
        ],
        [
            'name' => 'address',
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]

        ],
        [
            'name'    => 'state',
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]
        ],
        [
            'name'    => 'city',
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]
        ],
        [
            'name'     => 'zip',
            'validate' => [
                'rules' => [
                    'required'  => false,
                    'maxlength' => 5,
                ]
            ]
        ],
    ]
];
$this->AdminForm->create($params);
?>