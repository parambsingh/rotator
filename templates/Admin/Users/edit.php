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
            'name' => 'distributor_id',
            'type'  => 'number',
            'label'  => 'Rapid Funnel Distributor ID',
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
            'label'    => 'RF Email (Secondary Email)',
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
            'name'     => 'address',
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]
        ],
        [
            'name'     => 'state_id',
            'type'     => 'select',
            'options'  => $states,
            'id'       => 'StateId',
            'validate' => [
                'rules' => [
                    'required' => false
                ]
            ]
        ],
        [
            'name'     => 'city_id',
            'type'     => 'select',
            'options'  => $cities,
            'depend'   => [
                'id'    => 'StateId',
                'model' => 'Cities',
                'match' => 'state_id'
            ],
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
                    'maxlength' => 6,
                ]
            ]
        ],
    ]
];
$this->AdminForm->create($params);
?>