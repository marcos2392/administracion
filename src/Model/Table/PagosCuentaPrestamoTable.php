<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PagosCuentaPrestamo Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CuentasPrestamo
 * @property \Cake\ORM\Association\BelongsTo $Transacciones
 * @property \Cake\ORM\Association\BelongsTo $Sucursales
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 *
 * @method \App\Model\Entity\PagoCuentaPrestamo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PagoCuentaPrestamo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PagoCuentaPrestamo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PagoCuentaPrestamo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PagoCuentaPrestamo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PagoCuentaPrestamo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PagoCuentaPrestamo findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PagosCuentaPrestamoTable extends Table
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

        $this->table('pagos_cuenta_prestamo');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CuentasPrestamo', [
            'foreignKey' => 'cuenta_prestamo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Transacciones');
        $this->belongsTo('Sucursales');
        $this->belongsTo('Usuarios');
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
            ->dateTime('fecha_pago')
            ->allowEmpty('fecha_pago');

        $validator
            ->date('fecha_limite')
            ->requirePresence('fecha_limite', 'create')
            ->notEmpty('fecha_limite');

        $validator
            ->numeric('cantidad_esperada')
            ->requirePresence('cantidad_esperada', 'create')
            ->notEmpty('cantidad_esperada');

        $validator
            ->numeric('cantidad_pago')
            ->allowEmpty('cantidad_pago');

        $validator
            ->integer('numero_pago')
            ->requirePresence('numero_pago', 'create')
            ->notEmpty('numero_pago');

        $validator
            ->numeric('saldo_anterior')
            ->allowEmpty('saldo_anterior');

        $validator
            ->numeric('saldo')
            ->allowEmpty('saldo');

        $validator
            ->numeric('atraso')
            ->allowEmpty('atraso');

        $validator
            ->numeric('cargo')
            ->allowEmpty('cargo');

        $validator
            ->boolean('legacy')
            ->notEmpty('legacy');

        $validator
            ->boolean('pasado')
            ->notEmpty('pasado');

        $validator
            ->boolean('adelantado')
            ->notEmpty('adelantado');

        $validator
            ->boolean('revisado')
            ->notEmpty('revisado');

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
        $rules->add($rules->existsIn(['cuenta_prestamo_id'], 'CuentasPrestamo'));
        $rules->add($rules->existsIn(['transaccion_id'], 'Transacciones'));
        $rules->add($rules->existsIn(['sucursal_id'], 'Sucursales'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));

        return $rules;
    }

    public static function defaultConnectionName()
    {
        return 'jmeza';
    }
}
