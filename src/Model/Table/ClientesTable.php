<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clientes Model
 *
 * @method \App\Model\Entity\Cliente get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cliente newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cliente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cliente|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cliente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cliente[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cliente findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientesTable extends Table
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

        $this->table('cliente');
        $this->displayField('CL_CODIGO');
        $this->primaryKey('CL_CODIGO');

        $this->belongsTo('tipos')
            ->setName('tipos')
            ->setForeignKey('CL_TIPO')
            ->setProperty('tipo');
        $this->belongsTo('sucursales')
            ->setName('sucursales')
            ->setForeignKey('TB_CODIGO')
            ->setProperty('sucursal');
        $this->hasOne('saldos')
            ->setName('saldos')
            ->setForeignKey('CL_CODIGO')
            ->setProperty('saldo');
        $this->hasMany('Transacciones', [
            'name' => 'Transacciones',
            'foreignKey' => 'CL_CODIGO',
            'propertyName' => 'transacciones'
        ]);
        $this->belongsTo('PagosPromotor', [
            'foreignKey' => 'pago_promotor_id'
        ]);
        $this->hasOne('CuentasCobranza');
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
            ->integer('CL_CODIGO')
            ->allowEmpty('CL_CODIGO', 'create');

        $validator
            ->requirePresence('CL_NOMBRE', 'create')
            ->notEmpty('CL_NOMBRE');

        $validator
            ->requirePresence('CL_DIRECCION', 'create')
            ->notEmpty('CL_DIRECCION');

        $validator
            ->requirePresence('CL_TEL', 'create')
            ->notEmpty('CL_TEL');

        $validator
            ->requirePresence('CL_MOVIL', 'create')
            ->notEmpty('CL_MOVIL');

        $validator
            ->date('CL_FEC_ALTA')
            ->allowEmpty('CL_FEC_ALTA');

        $validator
            ->decimal('CL_LIMITE')
            ->requirePresence('CL_LIMITE', 'create')
            ->notEmpty('CL_LIMITE');

        $validator
            ->date('CL_FEC_LIM')
            ->allowEmpty('CL_FEC_LIM');

        $validator
            ->requirePresence('CL_TIPO', 'create')
            ->notEmpty('CL_TIPO');

        $validator
            ->boolean('CL_ACTIVO')
            ->allowEmpty('CL_ACTIVO');

        $validator
            ->integer('TB_CODIGO')
            ->allowEmpty('TB_CODIGO');

        $validator
            ->integer('CL_CODIGO_PUNTOS')
            ->allowEmpty('CL_CODIGO_PUNTOS');

        return $validator;
    }

    public static function defaultConnectionName()
    {
        return 'jmeza';
    }
}
