<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Empleados Model
 *
 * @method \App\Model\Entity\Empleado get($primaryKey, $options = [])
 * @method \App\Model\Entity\Empleado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Empleado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Empleado|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Empleado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Empleado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Empleado findOrCreate($search, callable $callback = null, $options = [])
 */
class EmpleadosTable extends Table
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

        $this->setTable('empleados');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('sucursales');
        
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
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->requirePresence('apellidos', 'create')
            ->notEmpty('apellidos');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->integer('descanso')
            ->requirePresence('descanso', 'create')
            ->notEmpty('descanso');

        $validator
            ->time('entrada')
            ->requirePresence('entrada', 'create')
            ->notEmpty('entrada');

        $validator
            ->time('salida')
            ->requirePresence('salida', 'create')
            ->notEmpty('salida');

        $validator
            ->integer('sucursal')
            ->requirePresence('sucursal', 'create')
            ->notEmpty('sucursal');

        return $validator;
    }
}
