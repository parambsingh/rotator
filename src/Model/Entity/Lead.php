<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lead Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $home_email
 * @property string $work_email
 * @property string $other_email
 * @property string $password
 * @property string $forgot_password_token
 * @property int $image_id
 * @property string $phone
 * @property string $home_phone
 * @property string $work_phone
 * @property string $other_phone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $role
 * @property string $company
 * @property string $interest
 * @property string $note
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Image $image
 * @property \App\Model\Entity\EmailCampaignRecipient[] $email_campaign_recipients
 * @property \App\Model\Entity\RotatorLoop[] $rotator_loops
 * @property \App\Model\Entity\User[] $users
 */
class Lead extends Entity {
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id'                   => true,
        'rf_contact'                => true,
        'first_name'                => true,
        'last_name'                 => true,
        'email'                     => true,
        'home_email'                => true,
        'work_email'                => true,
        'other_email'               => true,
        'image_id'                  => true,
        'phone'                     => true,
        'home_phone'                => true,
        'work_phone'                => true,
        'other_phone'               => true,
        'address'                   => true,
        'city_id'                   => true,
        'state_id'                  => true,
        'zip'                       => true,
        'role'                      => true,
        'company'                   => true,
        'interest'                  => true,
        'note'                      => true,
        'ip'                        => true,
        'lead_from'                 => true,
        'status'                    => true,
        'lead_status'                    => true,
        'go_to_webinar_id'                    => true,
        'go_to_webinar_title'                    => true,
        'is_webinar_regiatered'                    => true,
        'created'                   => true,
        'modified'                  => true,
        'image'                     => true,
        'email_campaign_recipients' => true,
        'rotator_loops'             => true,
        'user'                      => true,
        'city'                      => true,
        'state'                     => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
}
