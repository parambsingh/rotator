<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Leads Model
 *
 * @property \App\Model\Table\ImagesTable&\Cake\ORM\Association\BelongsTo $Images
 * @property \App\Model\Table\EmailCampaignRecipientsTable&\Cake\ORM\Association\HasMany $EmailCampaignRecipients
 * @property \App\Model\Table\RotatorLoopsTable&\Cake\ORM\Association\HasMany $RotatorLoops
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Lead newEmptyEntity()
 * @method \App\Model\Entity\Lead newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Lead[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lead get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lead findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Lead patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lead[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lead|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lead saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeadsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('leads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Images', [
            'foreignKey' => 'image_id',
            'joinType'   => 'LEFT',
        ]);
        $this->hasMany('EmailCampaignRecipients', [
            'foreignKey' => 'lead_id',
        ]);
        $this->hasMany('RotatorLoops', [
            'foreignKey' => 'lead_id',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey'       => 'lead_id',
            'targetForeignKey' => 'user_id',
            'joinTable'        => 'users_leads',
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
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');


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
