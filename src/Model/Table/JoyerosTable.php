<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Joyeros Model
 *
 * @method \App\Model\Entity\Joyero get($primaryKey, $options = [])
 * @method \App\Model\Entity\Joyero newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Joyero[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Joyero|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Joyero patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Joyero[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Joyero findOrCreate($search, callable $callback = null, $options = [])
 */
class JoyerosTable extends Table
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

        $this->setTable('joyeros');
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

        return $validator;
    }
}
