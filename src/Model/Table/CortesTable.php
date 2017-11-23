<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cortes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cobradores
 * @property \Cake\ORM\Association\BelongsToMany $Cobranzas
 *
 * @method \App\Model\Entity\Corte get($primaryKey, $options = [])
 * @method \App\Model\Entity\Corte newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Corte[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Corte|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corte patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Corte[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Corte findOrCreate($search, callable $callback = null, $options = [])
 */
class CortesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('cortes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cobradores', [
            'foreignKey' => 'cobrador_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Cobranzas', [
            'foreignKey' => 'corte_id',
            'targetForeignKey' => 'cobranza_id',
            'joinTable' => 'cortes_cobranzas'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmpty('fecha');

        $validator
            ->allowEmpty('folios');

        $validator
            ->numeric('total')
            ->requirePresence('total', 'create')
            ->notEmpty('total');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['cobrador_id'], 'Cobradores'));

        return $rules;
    }
}
