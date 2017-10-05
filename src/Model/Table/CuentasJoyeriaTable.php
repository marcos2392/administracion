<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\Sistema;

/**
 * CuantasJoyeria Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 * @property \Cake\ORM\Association\BelongsTo $Sistemas
 * @property \Cake\ORM\Association\HasMany $Transacciones
 *
 * @method \App\Model\Entity\CuentaJoyeria get($primaryKey, $options = [])
 * @method \App\Model\Entity\CuentaJoyeria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CuentaJoyeria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CuentaJoyeria|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CuentaJoyeria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CuentaJoyeria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CuentaJoyeria findOrCreate($search, callable $callback = null, $options = [])
 */
class CuentasJoyeriaTable extends Table
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

        $this->table('cuentas_joyeria');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clientes');
        $this->belongsTo('Sistemas');
        $this->hasMany('Transacciones', [
            'conditions' => ['Transacciones.puntos' => false]
        ]);
        $this->hasMany('TransaccionesPuntos', [
            'className' => 'Transacciones',
            'conditions' => ['TransaccionesPuntos.puntos' => true]
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
            ->allowEmpty('id');

        $validator
            ->integer('cliente_id')
            ->notEmpty('cliente_id');

        $validator
            ->integer('sucursal_id')
            ->notEmpty('sucursal_id');

        $validator
            ->decimal('saldo')
            ->allowEmpty('saldo');

        $validator
            ->decimal('limite_credito')
            ->notEmpty('limite_credito');

        $validator
            ->date('fecha_limite')
            ->allowEmpty('fecha_limite');

        $validator
            ->decimal('diferencia_pago')
            ->allowEmpty('diferencia_pago');

        $validator
            ->decimal('falta_pagar')
            ->allowEmpty('falta_pagar');

        $validator
            ->dateTime('ultima_revision')
            ->allowEmpty('ultima_revision');

        return $validator;
    }

    public static function defaultConnectionName()
    {
        return 'jmeza';
    }
}
