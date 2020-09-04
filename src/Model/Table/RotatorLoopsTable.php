<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RotatorLoops Model
 *
 * @property \App\Model\Table\UserPositionsTable&\Cake\ORM\Association\BelongsTo $UserPositions
 * @property \App\Model\Table\LeadsTable&\Cake\ORM\Association\BelongsTo $Leads
 *
 * @method \App\Model\Entity\RotatorLoop newEmptyEntity()
 * @method \App\Model\Entity\RotatorLoop newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RotatorLoop[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RotatorLoop get($primaryKey, $options = [])
 * @method \App\Model\Entity\RotatorLoop findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RotatorLoop patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RotatorLoop[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RotatorLoop|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RotatorLoop saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RotatorLoop[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RotatorLoop[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RotatorLoop[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RotatorLoop[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RotatorLoopsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('rotator_loops');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UserPositions', [
            'foreignKey' => 'user_position_id',
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
            ->requirePresence('round_no', 'create')
            ->notEmptyString('round_no');

        $validator
            ->scalar('lead_status')
            ->maxLength('lead_status', 255)
            ->requirePresence('lead_status', 'create')
            ->notEmptyString('lead_status');

        $validator
            ->scalar('rf_status')
            ->maxLength('rf_status', 255)
            ->requirePresence('rf_status', 'create')
            ->notEmptyString('rf_status');

        $validator
            ->scalar('rf_response_json')
            ->requirePresence('rf_response_json', 'create')
            ->notEmptyString('rf_response_json');

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
        $rules->add($rules->existsIn(['user_position_id'], 'UserPositions'), ['errorField' => 'user_position_id']);
        $rules->add($rules->existsIn(['lead_id'], 'Leads'), ['errorField' => 'lead_id']);

        return $rules;
    }
}
