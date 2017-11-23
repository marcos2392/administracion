<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CortesCobranzas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cortes
 * @property \Cake\ORM\Association\BelongsTo $CobranzasCobradores
 *
 * @method \App\Model\Entity\CorteCobranza get($primaryKey, $options = [])
 * @method \App\Model\Entity\CorteCobranza newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CorteCobranza[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CorteCobranza|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CorteCobranza patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CorteCobranza[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CorteCobranza findOrCreate($search, callable $callback = null, $options = [])
 */
class CortesCobranzasTable extends Table
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

        $this->setTable('cortes_cobranzas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cortes', [
            'foreignKey' => 'corte_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CobranzasCobradores', [
            'foreignKey' => 'cobranza_cobrador_id',
            'joinType' => 'INNER'
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
            ->numeric('cantidad')
            ->requirePresence('cantidad', 'create')
            ->notEmpty('cantidad');

        $validator
            ->numeric('comision')
            ->requirePresence('comision', 'create')
            ->notEmpty('comision');

        $validator
            ->numeric('porcentaje_comision')
            ->requirePresence('porcentaje_comision', 'create')
            ->notEmpty('porcentaje_comision');

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
        $rules->add($rules->existsIn(['corte_id'], 'Cortes'));
        $rules->add($rules->existsIn(['cobranza_cobrador_id'], 'CobranzasCobradores'));

        return $rules;
    }
}
