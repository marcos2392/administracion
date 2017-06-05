<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transacciones Model
 *
 * @method \App\Model\Entity\Transaccione get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transaccione newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Transaccione[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transaccione|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaccione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transaccione[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transaccione findOrCreate($search, callable $callback = null, $options = [])
 */
class TransaccionesTable extends Table
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

        $this->table('transacciones');
        $this->displayField('TR_ID');
        $this->primaryKey('TR_ID');

        $this->hasOne('NotasFiscales')
            ->setName('NotasFiscales')
            ->setForeignKey('TR_ID')
            ->setProperty('nota_fiscal');
        $this->belongsTo('Sucursales')
            ->setName('Sucursales')
            ->setForeignKey('VE_SUCURSAL')
            ->setProperty('sucursal');
        $this->belongsTo('Clientes')
            ->setName('Clientes')
            ->setForeignKey('CL_CODIGO')
            ->setProperty('cliente');
        $this->hasMany('VentasDetalle')
            ->setName('VentasDetalle')
            ->setForeignKey('TR_ID')
            ->setProperty('ventas_detalle');
        $this->belongsTo('Vendedoras')
            ->setName('Vendedoras')
            ->setForeignKey('VDORA_ID')
            ->setProperty('vendedora');
        $this->belongsTo('Productos')
            ->setName('Productos')
            ->setForeignKey('PR_CODIGO')
            ->setProperty('producto');
        $this->hasOne('puntos_detalles', [
            'condicions' => ['recomendacion' => false]
        ]);
        $this->hasOne('DetallesCuentaCobranza');
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
            ->integer('TR_ID')
            ->allowEmpty('TR_ID', 'create');

        $validator
            ->integer('CL_CODIGO')
            ->allowEmpty('CL_CODIGO');

        $validator
            ->integer('VE_ID')
            ->allowEmpty('VE_ID');

        $validator
            ->dateTime('TR_FECHA')
            ->allowEmpty('TR_FECHA');

        $validator
            ->decimal('TR_ABONO')
            ->allowEmpty('TR_ABONO');

        $validator
            ->decimal('TR_DEVOLUCION')
            ->allowEmpty('TR_DEVOLUCION');

        $validator
            ->decimal('TR_VENTA')
            ->allowEmpty('TR_VENTA');

        $validator
            ->decimal('TR_SALDOANTERIOR')
            ->allowEmpty('TR_SALDOANTERIOR');

        $validator
            ->decimal('VE_SALDO')
            ->allowEmpty('VE_SALDO');

        $validator
            ->allowEmpty('VE_TIPO');

        $validator
            ->allowEmpty('VE_SUCURSAL');

        $validator
            ->allowEmpty('TR_TIPO_PAGO');

        $validator
            ->integer('VDORA_ID')
            ->allowEmpty('VDORA_ID');

        $validator
            ->boolean('TR_CANCELADO')
            ->allowEmpty('TR_CANCELADO');

        return $validator;
    }

    public static function defaultConnectionName()
    {
        return 'jmeza';
    }
}
