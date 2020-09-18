<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property int $distibuter_id
 * @property string $name
 * @property string $email
 * @property string $lead_email
 * @property string $password
 * @property string $forgot_password_token
 * @property int $image_id
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $role
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Distibuter $distibuter
 * @property \App\Model\Entity\Image $image
 * @property \App\Model\Entity\EmailCampaignRecipient[] $email_campaign_recipients
 * @property \App\Model\Entity\EmailTemplate[] $email_templates
 * @property \App\Model\Entity\Subscription[] $subscriptions
 * @property \App\Model\Entity\UsersPosition[] $users_positions
 * @property \App\Model\Entity\Lead[] $leads
 */
class User extends Entity {
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
        'distributor_id'            => true,
        'name'                      => true,
        'email'                     => true,
        'rf_email'                  => true,
        'password'                  => true,
        'forgot_password_token'     => true,
        'image_id'                  => true,
        'phone'                     => true,
        'address'                   => true,
        'city_id'                   => true,
        'state_id'                  => true,
        'zip'                       => true,
        'role'                      => true,
        'status'                    => true,
        'created'                   => true,
        'modified'                  => true,
        'image'                     => true,
        'email_campaign_recipients' => true,
        'email_templates'           => true,
        'subscriptions'             => true,
        'users_positions'           => true,
        'leads'                     => true,
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

    protected function _setPassword($password) {
        return (new DefaultPasswordHasher)->hash($password);
    }
}
