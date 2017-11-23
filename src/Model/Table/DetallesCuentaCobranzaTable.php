<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DetallesCuentaCobranza Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 * @property \Cake\ORM\Association\BelongsTo $CuentasCobranza
 * @property \Cake\ORM\Association\BelongsTo $Transacciones
 *
 * @method \App\Model\Entity\DetalleCuentaCobranza get($primaryKey, $options = [])
 * @method \App\Model\Entity\DetalleCuentaCobranza newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DetalleCuentaCobranza[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DetalleCuentaCobranza|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DetalleCuentaCobranza patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DetalleCuentaCobranza[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DetalleCuentaCobranza findOrCreate($search, callable $callback = null, $options = [])
 */
class DetallesCuentaCobranzaTable extends Table
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

        $this->table('detalles_cuenta_cobranza');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'bindingKey' => 'id'
        ]);
        $this->belongsTo('CuentasCobranza');
        $this->belongsTo('Sucursales');
        $this->belongsTo('Cobradores');
        $this->belongsTo('Transacciones');
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
            ->numeric('saldo_antes')
            ->requirePresence('saldo_antes', 'create')
            ->notEmpty('saldo_antes');

        $validator
            ->numeric('saldo_despues')
            ->requirePresence('saldo_despues', 'create')
            ->notEmpty('saldo_despues');

        $validator
            ->integer('porcentaje_cargo')
            ->allowEmpty('porcentaje_cargo');

        $validator
            ->dateTime('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmpty('fecha');

        $validator
            ->boolean('cambio_cobrador')
            ->requirePresence('cambio_cobrador', 'create')
            ->notEmpty('cambio_cobrador');

        $validator
            ->boolean('pago')
            ->requirePresence('pago', 'create')
            ->notEmpty('pago');

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
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));
        $rules->add($rules->existsIn(['cuenta_cobranza_id'], 'CuentasCobranza'));

        return $rules;
    }

    /**
     * Regresa el ultimo pago de la cuenta dada
     * @return \App\Model\Entity\DetalleCuentaCobranza|null
     */

    public static function defaultConnectionName()
    {
        return 'jmeza';
    }
}
