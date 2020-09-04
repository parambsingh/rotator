<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailCampaignRecipient Entity
 *
 * @property int $id
 * @property int $email_campaign_id
 * @property string $to_email
 * @property int $user_id
 * @property int $lead_id
 * @property string $status
 * @property int $no_of_attempts
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EmailCampaign $email_campaign
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Lead $lead
 */
class EmailCampaignRecipient extends Entity {
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
        'email_campaign_id' => true,
        'to_email'          => true,
        'user_id'           => true,
        'lead_id'           => true,
        'status'            => true,
        'is_seen'           => true,
        'no_of_attempts'    => true,
        'created'           => true,
        'modified'          => true,
        'email_campaign'    => true,
        'user'              => true,
        'lead'              => true,
    ];
}
