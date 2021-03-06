<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProveedoresNotasPagadas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 * @property \Cake\ORM\Association\BelongsTo $Proveedores
 * @property \Cake\ORM\Association\BelongsTo $NotaProveedores
 *
 * @method \App\Model\Entity\ProveedorNotasPagadas get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProveedorNotasPagadas newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProveedorNotasPagadas[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProveedorNotasPagadas|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProveedorNotasPagadas patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProveedorNotasPagadas[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProveedorNotasPagadas findOrCreate($search, callable $callback = null, $options = [])
 */
class ProveedoresNotasPagadasTable extends Table
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

        $this->setTable('proveedores_notas_pagadas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Proveedores', [
            'foreignKey' => 'proveedor_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('NotaProveedores', [
            'foreignKey' => 'nota_proveedor_id'
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
            ->allowEmpty('descripcion');

        $validator
            ->numeric('cantidad')
            ->requirePresence('cantidad', 'create')
            ->notEmpty('cantidad');

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
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));
        $rules->add($rules->existsIn(['proveedor_id'], 'Proveedores'));
        $rules->add($rules->existsIn(['nota_proveedor_id'], 'NotaProveedores'));

        return $rules;
    }
}
