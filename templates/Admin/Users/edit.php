<?php
$params = [
    'form'   => [
        'options' => [
            'type'       => 'post',
            'novalidate' => true,
            'id'         => 'editForm'
        ],
        'heading' => 'Edit Distributor'
    ],
    'fields' => [
        [
            'name'  => 'distributor_id'
        ],
        [
            'name' => 'name'
        ],
        [
            'name'     => 'email',
            'validate' => [
                'rules' => [
                    'required' => true,
                    'email'    => true,
                    'remote'   => SITE_URL . 'admin/admins/isUniqueEmail/' . $user->id,
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
            'name' => 'phone',
            'validate' => [
                'rules' => [
                    'required'  => false,
                    'maxlength' => 13,
                ]
            ]
        ],
        [
            'name'     => 'address',
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]
        ],
        [
            'name' => 'state',
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]
        ],
        [
            'name' => 'city',
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