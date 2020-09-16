<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersPosition Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $subscription_id
 * @property int $position_no
 * @property int $position_order
 * @property string $subscription_status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Subscription $subscription
 */
class UsersPosition extends Entity {
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
        'user_id'             => true,
        'subscription_id'     => true,
        'position_no'         => true,
        'position_order'      => true,
        'lead_limit'          => true,
        'occupied_leads'      => true,
        'subscription_status' => true,
        'slot_status'         => true,
        'created'             => true,
        'modified'            => true,
        'user'                => true,
        'subscription'        => true,
    ];
}
