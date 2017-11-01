<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HorasChecada Entity
 *
 * @property int $id
 * @property int $empleado_id
 * @property int $sucursal_id
 * @property \Cake\I18n\Time $fecha_inicio
 * @property \Cake\I18n\Time $fecha_termino
 * @property float $hrs_checadas
 * @property float $hrs_editadas
 *
 * @property \App\Model\Entity\Empleado $empleado
 * @property \App\Model\Entity\Sucursal $sucursal
 */
class HorasChecada extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
