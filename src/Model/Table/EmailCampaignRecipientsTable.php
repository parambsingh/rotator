<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailCampaignRecipients Model
 *
 * @property \App\Model\Table\EmailCampaignsTable&\Cake\ORM\Association\BelongsTo $EmailCampaigns
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\LeadsTable&\Cake\ORM\Association\BelongsTo $Leads
 *
 * @method \App\Model\Entity\EmailCampaignRecipient newEmptyEntity()
 * @method \App\Model\Entity\EmailCampaignRecipient newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmailCampaignRecipient[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailCampaignRecipientsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('email_campaign_recipients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('EmailCampaigns', [
            'foreignKey' => 'email_campaign_id',
            'joinType'   => 'LEFT',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'LEFT',
        ]);
        $this->belongsTo('Leads', [
            'foreignKey' => 'lead_id',
            'joinType'   => 'LEFT',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('to_email')
            ->maxLength('to_email', 255)
            ->requirePresence('to_email', 'create')
            ->notEmptyString('to_email');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {

        return $rules;
    }
}
