<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BadWord $badWord
 */
$params = [
    'form'   => [
        'options' => [
            'type'       => 'post',
            'novalidate' => true,
            'id'         => 'addCityForm'
        ],
        'heading' => 'New Company'
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