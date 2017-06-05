<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Cliente Entity
 *
 * @property int $CL_CODIGO
 * @property string $CL_NOMBRE
 * @property string $CL_DIRECCION
 * @property string $CL_TEL
 * @property string $CL_MOVIL
 * @property \Cake\I18n\Time $CL_FEC_ALTA
 * @property float $CL_LIMITE
 * @property \Cake\I18n\Time $CL_FEC_LIM
 * @property string $CL_COMENTA
 * @property string $CL_TIPO
 * @property bool $CL_ACTIVO
 * @property int $TB_CODIGO
 * @property int $CL_CODIGO_PUNTOS
 * @property bool $EMPLEADO
 */
class Cliente extends Entity
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

    protected function _getId()
    {
        return $this->_properties['id'];
    }

    protected function _getNombre()
    {
        return $this->_properties['nombre'].' '.$this->_properties['apellidos'];
    }

    protected function _getNombreListados()
    {
        return $this->_properties['apellidos'].' '.$this->_properties['nombre'];
    }

    protected function _getApellido()
    {
        return $this->_properties['apellidos'];
    }

    
}
