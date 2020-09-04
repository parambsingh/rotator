<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailCampaigns Model
 *
 * @property \App\Model\Table\EmailTemplatesTable&\Cake\ORM\Association\BelongsTo $EmailTemplates
 * @property \App\Model\Table\EmailCampaignRecipientsTable&\Cake\ORM\Association\HasMany $EmailCampaignRecipients
 *
 * @method \App\Model\Entity\EmailCampaign newEmptyEntity()
 * @method \App\Model\Entity\EmailCampaign newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaign[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaign get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailCampaign findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EmailCampaign patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaign[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaign|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailCampaign saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailCampaign[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmailCampaign[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmailCampaign[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmailCampaign[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailCampaignsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('email_campaigns');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('EmailTemplates', [
            'foreignKey' => 'email_template_id',
            'joinType'   => 'LEFT',
        ]);
        $this->hasMany('EmailCampaignRecipients', [
            'foreignKey' => 'email_campaign_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('from_email')
            ->maxLength('from_email', 255)
            ->requirePresence('from_email', 'create')
            ->notEmptyString('from_email');

        $validator
            ->dateTime('send_at')
            ->requirePresence('send_at', 'create')
            ->notEmptyDateTime('send_at');


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
        $rules->add($rules->existsIn(['email_template_id'], 'EmailTemplates'), ['errorField' => 'email_template_id']);

        return $rules;
    }
}
