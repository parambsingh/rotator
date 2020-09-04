<!-- Sidebar Nav u-side-nav-opened has-active active  -->
<?php
$menuItems = [
    [
        'label'            => 'Dashboard',
        'controller'       => 'Admins',
        'action'           => 'dashboard',
        'icon_class'       => 'fa fa-dashboard',
        'default_sub_menu' => false
    ],
//    [
//        'label'            => 'Notification Center',
//        'controller'       => 'Activities',
//        'icon_class'       => 'fa fa-bell',
//        'default_sub_menu' => false,
//        'custom_sub_menu'  => [
//            [
//                'label'      => 'Send Notification',
//                'controller' => 'Activities',
//                'action'     => 'sendNotification',
//                'icon_class' => 'fa fa-send',
//            ],
//            [
//                'label'      => 'Sent Notifications',
//                'controller' => 'Activities',
//                'action'     => 'sentNotifications',
//                'icon_class' => 'fa fa-send',
//            ],
//        ]
//    ],

    [
        'controller' => 'Users',
        'label' => ' Distributors',
        'icon_class' => 'fa fa-user',
    ],
    [
        'controller' => 'Leads',
        'icon_class' => 'fa fa-users',
    ],
    [
        'label'            => 'Email Campaigns',
        'controller'       => 'Emails',
        'action'           => 'scheduleEmail',
        'icon_class'       => 'fa fa-clock-o',
        'default_sub_menu' => false,
        'custom_sub_menu'  => [
            [
                'label'      => 'New Campaign',
                'controller' => 'EmailCampaigns',
                'action'     => 'add',
                'icon_class' => 'fa fa-plus',
            ],
            [
                'label'      => 'List Campaigns',
                'controller' => 'EmailCampaigns',
                'action'     => 'index',
                'icon_class' => 'fa fa-list',
            ],
            [
                'label'      => 'Not Seen Emails',
                'controller' => 'EmailCampaigns',
                'action'     => 'notSeenEmails',
                'icon_class' => 'fa fa-eye-slash',
            ],
            [
                'label'      => 'New Email Template',
                'controller' => 'EmailTemplates',
                'action'     => 'add',
                'icon_class' => 'fa fa-envelope',
            ],
            [
                'label'      => 'Email Templates',
                'controller' => 'EmailTemplates',
                'action'     => 'index',
                'icon_class' => 'fa fa-envelope',
            ],
        ]
    ],
    [
        'controller' => 'Subscriptions',
        'icon_class' => 'fa fa-cc',
        'default_sub_menu' => false,
    ],
    [
        'controller' => 'Plans',
        'icon_class' => 'fa fa-snowflake-o',
    ],
    [
        'controller' => 'Coupons',
        'icon_class' => 'fa fa-map',
    ],


//    [
//        'label'            => 'Cron Jobs',
//        'controller'       => 'Admins',
//        'action'           => 'crons',
//        'icon_class'       => 'fa fa-gear',
//        'default_sub_menu' => false
//    ],


];
?>
<div id="sideNav" class="col-auto u-sidebar-navigation-v1 u-sidebar-navigation box-shadow-light">
    <!-- hr style="background-color: #7484a8" / -->
    <?php $this->Sidebar->create($menuItems); ?>
</div>
<!-- End Sidebar Nav -->
