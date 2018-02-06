<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cobradores Model
 *
 * @property \Cake\ORM\Association\HasMany $CuentasCobranza
 *
 * @method \App\Model\Entity\Cobrador get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cobrador newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cobrador[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cobrador|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cobrador patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cobrador[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cobrador findOrCreate($search, callable $callback = null, $options = [])
 */
class CobradoresSistemaTable extends Table
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

        $this->table('cobradores');
        $this->displayField('nombre');
        $this->primaryKey('id');

        $this->hasMany('CuentasCobranza', [
            'foreignKey' => 'cobrador_id',
            'conditions' => ['saldo >' => 0]
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
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->boolean('eliminado')
            ->notEmpty('eliminado');

        return $validator;
    }

    public static function defaultConnectionName()
    {
        return 'jmeza';
    }
}
