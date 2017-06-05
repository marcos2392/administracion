<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Checadas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Empleados
 *
 * @method \App\Model\Entity\Checada get($primaryKey, $options = [])
 * @method \App\Model\Entity\Checada newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Checada[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Checada|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Checada patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Checada[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Checada findOrCreate($search, callable $callback = null, $options = [])
 */
class ChecadasTable extends Table
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

        $this->setTable('checadas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empleados', [
            'foreignKey' => 'empleados_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Sucursales');
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
            ->time('entrada')
            ->requirePresence('entrada', 'create')
            ->notEmpty('entrada');

        $validator
            ->time('salida')
            ->requirePresence('salida', 'create')
            ->notEmpty('salida');

        $validator
            ->time('horas')
            ->requirePresence('horas', 'create')
            ->notEmpty('horas');

        $validator
            ->boolean('retardo')
            ->requirePresence('retardo', 'create')
            ->notEmpty('retardo');

        $validator
            ->boolean('falta')
            ->requirePresence('falta', 'create')
            ->notEmpty('falta');

        $validator
            ->integer('descanso')
            ->requirePresence('descanso', 'create')
            ->notEmpty('descanso');

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

        return $rules;
    }

    public static function defaultConnectionName()
    {
        return 'checador';
    }
}
