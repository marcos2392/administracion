<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Empleado Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellidos
 * @property bool $status
 * @property int $descanso
 * @property \Cake\I18n\Time $entrada
 * @property \Cake\I18n\Time $salida
 * @property int $sucursal
 */
class Empleado extends Entity
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

    protected function _getNcompleto() {
        return $this->_properties['nombre'].' '.$this->_properties['apellidos'];
    }

    public function desc() {
        $descanso=$this->_properties['descanso'];
        return $this->nombredia($descanso);
    }

    public function diaExtra() {
        $diaextra=$this->_properties['dia_extra'];
        return $this->nombredia($diaextra);
    }

    public function tipoExtra() {
        $tipoextra=$this->_properties['tipo_extra'];
        return $this->extra($tipoextra);
    }

    protected function nombreDia($dia){
        switch ($dia) {

            case 0:
                $dia= "";
                break;
            case 1:
                $dia= "Lunes";
                break;
            case 2:
                $dia= "Martes";
                break;
            case 3:
                $dia= "Miercoles";
                break;
            case 4:
                $dia= "Jueves";
                break;
            case 5:
                $dia= "Viernes";
                break;
            case 6:
                $dia= "Sabado";
                break;
            case 7:
                $dia= "Domingo";
                break;
            case 8:
                $dia= "Sab-Dom";
                break;
        }
        return $dia;
    }

    protected function extra($tipo){
        switch ($tipo) {

            case 0:
                $tipo= "";
                break;
            case 1:
                $tipo= "Entrada";
                break;
            case 2:
                $tipo= "Salida";
                break;
            case 3:
                $tipo= "Descanso";
                break;
        }
        return $tipo;
    }
}
