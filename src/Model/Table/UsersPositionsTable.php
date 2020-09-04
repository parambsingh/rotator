<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersPositions Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\SubscriptionsTable&\Cake\ORM\Association\BelongsTo $Subscriptions
 *
 * @method \App\Model\Entity\UsersPosition newEmptyEntity()
 * @method \App\Model\Entity\UsersPosition newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\UsersPosition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersPosition get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersPosition findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\UsersPosition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersPosition[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersPosition|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersPosition saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersPosition[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UsersPosition[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\UsersPosition[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UsersPosition[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersPositionsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('users_positions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'LEFT',
        ]);
        $this->belongsTo('Subscriptions', [
            'foreignKey' => 'subscription_id',
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
            ->integer('position_no')
            ->requirePresence('position_no', 'create')
            ->notEmptyString('position_no');

        $validator
            ->integer('position_order')
            ->requirePresence('position_order', 'create')
            ->notEmptyString('position_order');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['subscription_id'], 'Subscriptions'), ['errorField' => 'subscription_id']);

        return $rules;
    }
}
