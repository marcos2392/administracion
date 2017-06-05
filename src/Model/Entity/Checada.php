<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Checada Entity
 *
 * @property int $id
 * @property int $empleados_id
 * @property \Cake\I18n\Time $fecha
 * @property \Cake\I18n\Time $entrada
 * @property \Cake\I18n\Time $salida
 * @property \Cake\I18n\Time $horas
 * @property bool $retardo
 * @property bool $falta
 * @property int $descanso
 *
 * @property \App\Model\Entity\Empleado $empleado
 */
class Checada extends Entity
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

    public function minutos()
    {
        $hora=$this->horas->format("H:i");

        $separar[1]=explode(':',$hora);

        $minutos[1] = ($separar[1][0]*60)+$separar[1][1]; 
        $min=$minutos[1];
        
        return $min;
    }
}
