<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sucursales Model
 *
 * @property \Cake\ORM\Association\HasMany $Empleados
 * @property \Cake\ORM\Association\HasMany $Usuarios
 *
 * @method \App\Model\Entity\Sucursal get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sucursal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sucursal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sucursal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sucursal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sucursal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sucursal findOrCreate($search, callable $callback = null, $options = [])
 */
class SucursalesSistemasTable extends Table
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

        $this->setTable('sucursal');
        $this->setDisplayField('TB_CODIGO');
        $this->setPrimaryKey('TB_CODIGO');
        
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

    public static function defaultConnectionName()
    {
        return 'jmeza';
    }
}
