<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subscription Entity
 *
 * @property int $id
 * @property int $plan_id
 * @property int $user_id
 * @property int $coupon_id
 * @property string $subscription_token
 * @property string $amount
 * @property string $discount
 * @property \Cake\I18n\FrozenTime $start_at
 * @property \Cake\I18n\FrozenTime $end_at
 * @property string $response_json
 * @property string $status
 * @property \Cake\I18n\FrozenTime $cancelled_at
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Plan $plan
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Coupon $coupon
 * @property \App\Model\Entity\UsersPosition[] $users_positions
 */
class Subscription extends Entity {
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
        'plan_id'            => true,
        'user_id'            => true,
        'coupon_id'          => true,
        'subscription_token' => true,
        'amount'             => true,
        'discount'           => true,
        'start_at'           => true,
        'end_at'             => true,
        'response_json'      => true,
        'status'             => true,
        'cancelled_at'       => true,
        'created'            => true,
        'modified'           => true,
        'plan'               => true,
        'user'               => true,
        'coupon'             => true,
        'users_positions'    => true,
    ];
}
