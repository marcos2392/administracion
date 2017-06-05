<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VentasSucursales Model
 *
 * @method \App\Model\Entity\VentasSucursale get($primaryKey, $options = [])
 * @method \App\Model\Entity\VentasSucursale newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VentasSucursale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VentasSucursale|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentasSucursale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VentasSucursale[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VentasSucursale findOrCreate($search, callable $callback = null, $options = [])
 */
class VentasSucursalesTable extends Table
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

        $this->setTable('ventas_sucursales');
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
            ->numeric('venta')
            ->allowEmpty('venta');

        return $validator;
    }
}
