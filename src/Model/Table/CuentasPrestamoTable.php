<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CuentasPrestamo Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 * @property \Cake\ORM\Association\BelongsTo $Prestamos
 * @property \Cake\ORM\Association\BelongsTo $Sistemas
 * @property \Cake\ORM\Association\HasMany $PagosCuentaPrestamo
 * @property \Cake\ORM\Association\HasMany $Transacciones
 * @property \Cake\ORM\Association\HasMany $CuentaCobranza
 *
 * @method \App\Model\Entity\CuentaPrestamo get($primaryKey, $options = [])
 * @method \App\Model\Entity\CuentaPrestamo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CuentaPrestamo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CuentaPrestamo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CuentaPrestamo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CuentaPrestamo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CuentaPrestamo findOrCreate($search, callable $callback = null, $options = [])
 */
class CuentasPrestamoTable extends Table
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

        $this->table('cuentas_prestamo');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Prestamos', [
            'foreignKey' => 'prestamo_id'
        ]);
        $this->belongsTo('Sistemas');
        $this->hasMany('PagosCuentaPrestamo');
        $this->hasMany('Transacciones');
        $this->hasOne('CuentasCobranza', [
            'joinType' => 'LEFT'
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
            ->numeric('saldo')
            ->requirePresence('saldo', 'create')
            ->notEmpty('saldo');

        $validator
            ->numeric('cantidad_pago')
            ->requirePresence('cantidad_pago', 'create')
            ->notEmpty('cantidad_pago');

        $validator
            ->numeric('cantidad_prestamo')
            ->requirePresence('cantidad_prestamo', 'create')
            ->notEmpty('cantidad_prestamo');

        $validator
            ->numeric('porcentaje_interes')
            ->requirePresence('porcentaje_interes', 'create')
            ->notEmpty('porcentaje_interes');

        $validator
            ->numeric('cantidad_final')
            ->requirePresence('cantidad_final', 'create')
            ->notEmpty('cantidad_final');

        $validator
            ->date('fecha_solicitud')
            ->requirePresence('fecha_solicitud', 'create')
            ->notEmpty('fecha_solicitud');

        $validator
            ->integer('plazo')
            ->requirePresence('plazo', 'create')
            ->notEmpty('plazo');

        $validator
            ->requirePresence('tipo_plazo', 'create')
            ->notEmpty('tipo_plazo');

        $validator
            ->date('fecha_final')
            ->requirePresence('fecha_final', 'create')
            ->notEmpty('fecha_final');

        $validator
            ->boolean('atrasado')
            ->notEmpty('atrasado');

        return $validator;
    }

    public static function defaultConnectionName()
    {
        return 'jmeza';
    }
    
}
