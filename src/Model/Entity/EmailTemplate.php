<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailTemplate Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $label
 * @property int $subject
 * @property string $template
 * @property string $note
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\EmailCampaign[] $email_campaigns
 */
class EmailTemplate extends Entity {
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
        'user_id'         => true,
        'label'           => true,
        'subject'         => true,
        'template'        => true,
        'note'            => true,
        'status'          => true,
        'created'         => true,
        'modified'        => true,
        'user'            => true,
        'email_campaigns' => true,
    ];
}
