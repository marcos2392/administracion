<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

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

    /*public function joyeria() {
        
        $joyeria=0;
        $cliente_id=$this->_properties['empleado_id'];

        if($cliente_id!=0)
        { 
            $saldo_joyeria=TableRegistry::get("CuentasJoyeria")->find()
            ->select(['saldo'=>'sum(saldo)'])
            ->where(["cliente_id"=>$cliente_id])
            ->first();

            $joyeria=$saldo_joyeria->saldo;
        }

        return $joyeria;
    }*/

    /*public function prestamo() {

        $prestamo=0;
        $cliente_id=$this->_properties['empleado_id'];

        if($cliente_id!=0)
        { 
            $saldo_prestamo=TableRegistry::get("CuentasPrestamo")->find()
            ->select(['saldo'=>'sum(saldo)'])
            ->where(["cliente_id"=>$cliente_id])
            ->first();

            $prestamo=$saldo_prestamo->saldo;
        }

        return $prestamo;
    }*/

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

}
