<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeadLog Entity
 *
 * @property int $id
 * @property int|null $lead_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $request_json
 * @property string|null $response_json
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Lead $lead
 */
class LeadLog extends Entity {
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
        'lead_id'       => true,
        'first_name'    => true,
        'last_name'     => true,
        'email'         => true,
        'ip'            => true,
        'lead_from'     => true,
        'request_json'  => true,
        'response_json' => true,
        'status'        => true,
        'created'       => true,
        'modified'      => true,
        'lead'          => true,
    ];
}