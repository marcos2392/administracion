<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NominaEmpleadas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Empleados
 * @property \Cake\ORM\Association\BelongsTo $Sucursals
 *
 * @method \App\Model\Entity\NominaEmpleada get($primaryKey, $options = [])
 * @method \App\Model\Entity\NominaEmpleada newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NominaEmpleada[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NominaEmpleada|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NominaEmpleada patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NominaEmpleada[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NominaEmpleada findOrCreate($search, callable $callback = null, $options = [])
 */
class NominaEmpleadasTable extends Table
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

        $this->setTable('nomina_empleadas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empleados', [
            'foreignKey' => 'empleados_id',
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

        $validator
            ->dateTime('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmpty('fecha');

        $validator
            ->date('fecha_inicio')
            ->requirePresence('fecha_inicio', 'create')
            ->notEmpty('fecha_inicio');

        $validator
            ->date('fecha_fin')
            ->requirePresence('fecha_fin', 'create')
            ->notEmpty('fecha_fin');

        $validator
            ->time('horas')
            ->requirePresence('horas', 'create')
            ->notEmpty('horas');

        $validator
            ->numeric('sueldo')
            ->requirePresence('sueldo', 'create')
            ->notEmpty('sueldo');

        $validator
            ->numeric('infonavit')
            ->requirePresence('infonavit', 'create')
            ->notEmpty('infonavit');

        $validator
            ->numeric('bono')
            ->requirePresence('bono', 'create')
            ->notEmpty('bono');

        $validator
            ->numeric('comision')
            ->requirePresence('comision', 'create')
            ->notEmpty('comision');

        $validator
            ->numeric('deduccion')
            ->requirePresence('deduccion', 'create')
            ->notEmpty('deduccion');

        $validator
            ->numeric('extra')
            ->requirePresence('extra', 'create')
            ->notEmpty('extra');

        $validator
            ->numeric('prestamo')
            ->requirePresence('prestamo', 'create')
            ->notEmpty('prestamo');

        $validator
            ->numeric('joyeria')
            ->requirePresence('joyeria', 'create')
            ->notEmpty('joyeria');

        $validator
            ->numeric('sueldo_final')
            ->requirePresence('sueldo_final', 'create')
            ->notEmpty('sueldo_final');

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
        $rules->add($rules->existsIn(['empleados_id'], 'Empleados'));
        $rules->add($rules->existsIn(['sucursal_id'], 'Sucursales'));

        return $rules;
    }
}
