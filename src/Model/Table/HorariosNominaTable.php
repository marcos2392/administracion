<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HorariosNomina Model
 *
 * @method \App\Model\Entity\HorariosNomina get($primaryKey, $options = [])
 * @method \App\Model\Entity\HorariosNomina newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HorariosNomina[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HorariosNomina|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HorariosNomina patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HorariosNomina[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HorariosNomina findOrCreate($search, callable $callback = null, $options = [])
 */
class HorariosNominaTable extends Table
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

        $this->setTable('horarios_nomina');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->time('entrada_real')
            ->allowEmpty('entrada_real');

        $validator
            ->time('salida_real')
            ->allowEmpty('salida_real');

        $validator
            ->time('entrada_nomina')
            ->allowEmpty('entrada_nomina');

        $validator
            ->time('salida_nomina')
            ->allowEmpty('salida_nomina');

        return $validator;
    }

    public static function defaultConnectionName()
    {
        return 'checador';
    }
}
