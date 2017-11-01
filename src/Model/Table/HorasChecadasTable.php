<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HorasChecadas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Empleados
 * @property \Cake\ORM\Association\BelongsTo $Sucursales
 *
 * @method \App\Model\Entity\HorasChecada get($primaryKey, $options = [])
 * @method \App\Model\Entity\HorasChecada newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HorasChecada[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HorasChecada|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HorasChecada patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HorasChecada[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HorasChecada findOrCreate($search, callable $callback = null, $options = [])
 */
class HorasChecadasTable extends Table
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

        $this->setTable('horas_checadas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empleados', [
            'foreignKey' => 'empleado_id'
        ]);
        $this->belongsTo('Sucursales', [
            'foreignKey' => 'sucursal_id'
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
            ->date('fecha_inicio')
            ->requirePresence('fecha_inicio', 'create')
            ->notEmpty('fecha_inicio');

        $validator
            ->date('fecha_termino')
            ->requirePresence('fecha_termino', 'create')
            ->notEmpty('fecha_termino');

        $validator
            ->numeric('hrs_checadas')
            ->requirePresence('hrs_checadas', 'create')
            ->notEmpty('hrs_checadas');

        $validator
            ->numeric('hrs_editadas')
            ->requirePresence('hrs_editadas', 'create')
            ->notEmpty('hrs_editadas');

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

    public static function defaultConnectionName()
    {
        return 'checador';
    }
}
