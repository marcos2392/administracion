<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NominaEmpleada Entity
 *
 * @property int $id
 * @property int $empleados_id
 * @property \Cake\I18n\Time $fecha
 * @property \Cake\I18n\Time $fecha_inicio
 * @property \Cake\I18n\Time $fecha_fin
 * @property int $sucursal_id
 * @property \Cake\I18n\Time $horas
 * @property float $sueldo
 * @property float $infonavit
 * @property float $bono
 * @property float $comision
 * @property float $deduccion
 * @property float $extra
 * @property float $prestamo
 * @property float $joyeria
 * @property float $sueldo_final
 *
 * @property \App\Model\Entity\Empleado $empleado
 * @property \App\Model\Entity\Sucursal $sucursal
 */
class NominaEmpleada extends Entity
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
