<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RotatorLoop Entity
 *
 * @property int $id
 * @property int $round_no
 * @property int $user_position_id
 * @property int $lead_id
 * @property string $lead_status
 * @property string $rf_status
 * @property string $rf_response_json
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\UserPosition $user_position
 * @property \App\Model\Entity\Lead $lead
 */
class RotatorLoop extends Entity {
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
        'round_no'         => true,
        'user_position_id' => true,
        'lead_id'          => true,
        'lead_status'      => true,
        'created'          => true,
        'modified'         => true,
        'user_position'    => true,
        'lead'             => true,
    ];
}
