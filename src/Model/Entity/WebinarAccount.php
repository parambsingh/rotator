<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WebinarAccount Entity
 *
 * @property int $id
 * @property string|null $client_id
 * @property string|null $client_secret
 * @property string|null $code
 * @property string|null $account_json
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Client $client
 */
class WebinarAccount extends Entity {
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
        'client_id'     => true,
        'client_secret' => true,
        'code'          => true,
        'account_json'  => true,
        'status'        => true,
        'created'       => true,
        'modified'      => true,
    ];
}
