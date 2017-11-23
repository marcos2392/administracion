<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PagoCuentaPrestamo Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $cuenta_prestamo_id
 * @property \Cake\I18n\Time $fecha_pago
 * @property \Cake\I18n\Time $fecha_limite
 * @property float $cantidad_esperada
 * @property float $cantidad_pago
 * @property int $numero_pago
 * @property float $saldo_anterior
 * @property float $saldo
 * @property float $atraso
 * @property float $cargo
 * @property bool $legacy
 * @property int $transaccion_id
 * @property bool $pasado
 * @property bool $adelantado
 * @property int $sucursal_id
 * @property int $usuario_id
 * @property bool $revisado
 *
 * @property string $tipo
 * @property bool $completo
 * @property string $clase_pago
 * @property bool $realizado
 * @property float $esperado
 *
 * @property \App\Model\Entity\CuentaPrestamo $cuenta_prestamo
 * @property \App\Model\Entity\Transaccion $transaccion
 * @property \App\Model\Entity\Sucursal $sucursal
 * @property \App\Model\Entity\Usuario $usuario
 */
class PagoCuentaPrestamo extends Entity
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

    protected function _getTipo()
    {
        if ($this->adelantado) {
            return "adelantado";
        } elseif ($this->cantidad_pago > 0) {
            return "regular";
        } elseif (isset($this->cantidad_pago) && $this->cantidad_pago == 0) {
            return "vencido";
        }
    }

    protected function _getCompleto()
    {
        return ($this->cantidad_pago ?? 0) >= $this->cantidad_esperada;
    }

    protected function _getClasePago()
    {
        return $this->adelantado ? 'completo' : (isset($this->cantidad_pago) ? ($this->completo ? 'completo' : 'incompleto') : 'pendiente');
    }

    protected function _getRealizado()
    {
        return isset($this->cantidad_pago) && $this->cantidad_pago > 0;
    }

    protected function _getEsperado()
    {
        return $this->cantidad_esperada - ($this->cantidad_pago ?? 0);
    }
}
