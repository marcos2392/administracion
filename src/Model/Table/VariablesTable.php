<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Variables Model
 *
 * @method \App\Model\Entity\Variable get($primaryKey, $options = [])
 * @method \App\Model\Entity\Variable newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Variable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Variable|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Variable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Variable[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Variable findOrCreate($search, callable $callback = null, $options = [])
 */
class VariablesTable extends Table
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

        $this->setTable('variables');
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
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->boolean('estatus')
            ->requirePresence('estatus', 'create')
            ->notEmpty('estatus');

        return $validator;
    }
}
