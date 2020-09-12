<?php
$params = [
    'form'   => [
        'options' => [
            'type'       => 'post',
            'novalidate' => true,
            'id'         => 'editForm'
        ],
        'heading' => 'Edit Lead'
    ],
    'fields' => [
        [
            'name'  => 'status',
            'type'  => 'hidden',
            'value' => 1
        ],
        ['name' => 'first_name'],
        ['name' => 'last_name'],
        [
            'name'     => 'email',
            'validate' => [
                'rules' => [
                    'required' => true,
                    'email'    => true,
                    'remote'   => SITE_URL . 'leads/isUniqueEmail/' . $lead->id,
                ],

            ]
        ],
        [
            'name'     => 'home_email',
            'validate' => [
                'rules' => [
                    'required' => false,
                    'email'    => true,
                ],

            ]
        ],
        [
            'name'     => 'work_email',
            'validate' => [
                'rules' => [
                    'required' => false,
                    'email'    => true,
                ],

            ]
        ],
        [
            'name'     => 'other_email',
            'validate' => [
                'rules' => [
                    'required' => false,
                    'email'    => true,
                ],

            ]
        ],
        [
            'name'     => 'phone',
            'validate' => [
                'rules' => [
                    'required'  => false,
                    'maxlength' => 13,
                ]
            ]
        ],
        [
            'name'     => 'home_phone',
            'validate' => [
                'rules' => [
                    'required'  => false,
                    'maxlength' => 13,
                ]
            ]
        ],
        [
            'name'     => 'work_phone',
            'validate' => [
                'rules' => [
                    'required'  => false,
                    'maxlength' => 13,
                ]
            ]
        ],
        [
            'name'     => 'other_phone',
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
            'name'     => 'state',
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]
        ],
        [
            'name'     => 'city',
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