<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SaldoProveedores Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Proveedors
 *
 * @method \App\Model\Entity\SaldoProveedore get($primaryKey, $options = [])
 * @method \App\Model\Entity\SaldoProveedore newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SaldoProveedore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SaldoProveedore|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SaldoProveedore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SaldoProveedore[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SaldoProveedore findOrCreate($search, callable $callback = null, $options = [])
 */
class SaldoProveedoresTable extends Table
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

        $this->setTable('saldo_proveedores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Proveedores', [
            'foreignKey' => 'proveedor_id',
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
            ->requirePresence('saldo', 'create')
            ->notEmpty('saldo');

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
        $rules->add($rules->existsIn(['proveedor_id'], 'Proveedores'));

        return $rules;
    }
}
