<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailCampaign Entity
 *
 * @property int $id
 * @property string $name
 * @property string $from_email
 * @property int $email_template_id
 * @property \Cake\I18n\FrozenTime $send_at
 * @property int $scheduled_count
 * @property int $sent_count
 * @property int $failed_count
 * @property int $opened_count
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EmailTemplate $email_template
 * @property \App\Model\Entity\EmailCampaignRecipient[] $email_campaign_recipients
 */
class EmailCampaign extends Entity {
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
        'name'                      => true,
        'from_email'                => true,
        'email_template_id'         => true,
        'send_at'                   => true,
        'scheduled_count'           => true,
        'sent_count'                => true,
        'failed_count'              => true,
        'opened_count'              => true,
        'status'                    => true,
        'created'                   => true,
        'modified'                  => true,
        'email_template'            => true,
        'email_campaign_recipients' => true,
    ];
}
