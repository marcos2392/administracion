<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reparaciones Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 * @property \Cake\ORM\Association\BelongsTo $Joyeros
 * @property \Cake\ORM\Association\BelongsTo $Sucursales
 *
 * @method \App\Model\Entity\Reparacione get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reparacione newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reparacione[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reparacione|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reparacione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reparacione[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reparacione findOrCreate($search, callable $callback = null, $options = [])
 */
class ReparacionesTable extends Table
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

        $this->setTable('reparaciones');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Joyeros', [
            'foreignKey' => 'joyero_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sucursales', [
            'foreignKey' => 'sucursal_id',
            'joinType' => 'INNER'
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
            ->dateTime('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmpty('fecha');

        $validator
            ->numeric('cantidad')
            ->requirePresence('cantidad', 'create')
            ->notEmpty('cantidad');

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
        $rules->add($rules->existsIn(['joyero_id'], 'Joyeros'));
        $rules->add($rules->existsIn(['sucursal_id'], 'Sucursales'));

        return $rules;
    }
}
