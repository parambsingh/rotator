<?php
///pr($this->request->referer());die;
$params = [
    'form' => [
        'options' => [
            'type' => 'post',
            'novalidate' => true,
            'id' => 'adminProfileForm'
        ],
        'heading' => 'Profile'
    ],
    'fields' => [
        [
            'name' => 'image_id',
            'type' => 'image',
            'columns' => 12,
            'model' => 'Admins',
            'category' => 'Admin Profile'
        ],
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
                ],

            ]
        ],
        [
            'name'     => 'rf_email',
            'label' => 'RF Email (Secondary Email)',
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
                    'maxlength' => 5,
                ]
            ]
        ],
    ]
];

$changePassParams = [
    'form' => [
        'options' => [
            'type' => 'post',
            'novalidate' => true,
            'id' => 'changePasswordAdminsForm',
            'url' => ['controller' => 'Users', 'action' => 'changePassword']
        ],
        'heading' => 'Change Password',
        'cancel' => false,
    ],
    'fields' => [
        [
            'name' => 'current_password',
            'type' => 'password',
            'columns' => 12
        ],
        [
            'name' => 'new_password',
            'type' => 'password',
            'id' => 'Password',
            'columns' => 12,
            'validate' => [
                'rules' => [
                    'required' => true,
                    'pwcheck' => true,
                    'minlength' => 8
                ]
            ]
        ],
        [
            'name' => 'confirm_password',
            'type' => 'password',
            'columns' => 12,
            'validate' => [
                'rules' => [
                    'required' => true,
                    'equalTo' => "#Password"
                ]
            ]
        ]
    ],
    'submit' => [
        'label' => 'Change Password'
    ]
];

?>
<div class="row">
    <div class="col-md-8">
        <?php $this->CustomForm->create($params); ?>
    </div>
    <div class="col-md-4">
        <?php $this->CustomForm->create($changePassParams); ?>
    </div>
</div>

