<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SucursalesEmpleados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Empleados
 * @property \Cake\ORM\Association\BelongsTo $Sucursales
 *
 * @method \App\Model\Entity\SucursalesEmpleado get($primaryKey, $options = [])
 * @method \App\Model\Entity\SucursalesEmpleado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SucursalesEmpleado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SucursalesEmpleado|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SucursalesEmpleado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SucursalesEmpleado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SucursalesEmpleado findOrCreate($search, callable $callback = null, $options = [])
 */
class SucursalesEmpleadosTable extends Table
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

        $this->setTable('sucursales_empleados');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empleados', [
            'foreignKey' => 'empleado_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sucursales', [
            'foreignKey' => 'sucursal_id',
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
        $rules->add($rules->existsIn(['empleado_id'], 'Empleados'));
        $rules->add($rules->existsIn(['sucursal_id'], 'Sucursales'));

        return $rules;
    }
}
