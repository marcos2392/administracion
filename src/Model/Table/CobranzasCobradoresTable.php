<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CobranzasCobradores Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cobradores
 * @property \Cake\ORM\Association\BelongsTo $Cobranzas
 * @property \Cake\ORM\Association\HasMany $CortesCobranzas
 *
 * @method \App\Model\Entity\CobranzaCobrador get($primaryKey, $options = [])
 * @method \App\Model\Entity\CobranzaCobrador newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CobranzaCobrador[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CobranzaCobrador|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CobranzaCobrador patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CobranzaCobrador[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CobranzaCobrador findOrCreate($search, callable $callback = null, $options = [])
 */
class CobranzasCobradoresTable extends Table
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

        $this->setTable('cobranzas_cobradores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cobradores', [
            'foreignKey' => 'cobrador_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cobranzas', [
            'foreignKey' => 'cobranza_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CortesCobranzas', [
            'foreignKey' => 'cobranza_cobrador_id'
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
        $rules->add($rules->existsIn(['cobrador_id'], 'Cobradores'));
        $rules->add($rules->existsIn(['cobranza_id'], 'Cobranzas'));

        return $rules;
    }
}
