<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\Tipo;

/**
 * Transaccion Entity
 *
 * @property int $TR_ID
 * @property int $CL_CODIGO
 * @property int $VE_ID
 * @property \Cake\I18n\Time $TR_FECHA
 * @property float $TR_ABONO
 * @property float $TR_DEVOLUCION
 * @property float $TR_VENTA
 * @property float $TR_SALDOANTERIOR
 * @property float $VE_SALDO
 * @property string $VE_TIPO
 * @property string $VE_SUCURSAL
 * @property string $TR_TIPO_PAGO
 * @property int $VDORA_ID
 * @property bool $TR_CANCELADO
 */
class Transaccion extends Entity
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
        'TR_ID' => false
    ];

    private $cantidad_devoluciones = null;
    private $cantidad_ventas = null;

    protected function _getFecha()
    {
        return $this->_properties['TR_FECHA'];
    }

    protected function _getVenta()
    {
        return $this->_properties['TR_VENTA'];
    }

    protected function _getDevolucion()
    {
        return $this->_properties['TR_DEVOLUCION'];
    }

    protected function _getPago()
    {
        return $this->_properties['TR_ABONO'];
    }

    protected function _getSaldoAnterior()
    {
        return $this->_properties['TR_SALDOANTERIOR'];
    }

    protected function _getSaldo()
    {
        return $this->_properties['VE_SALDO'];
    }

    protected function _getSucursalId()
    {
        return $this->_properties['VE_SUCURSAL'];
    }

    protected function _getTipo()
    {
        return trim($this->_properties['VE_TIPO']);
    }

    protected function _getId()
    {
        return $this->_properties['TR_ID'];
    }

    protected function _getCantidadDevoluciones()
    {
        if (!is_null($this->cantidad_devoluciones)) {
            return $this->cantidad_devoluciones;
        }
        $this->generarCantidadesVentaDevolucion();
        return $this->cantidad_devoluciones;
    }

    protected function _getCantidadVentas()
    {
        if (!is_null($this->cantidad_ventas)) {
            return $this->cantidad_ventas;
        }
        $this->generarCantidadesVentaDevolucion();
        return $this->cantidad_ventas;
    }

    private function generarCantidadesVentaDevolucion()
    {
        $cantidad_ventas = 0;
        $cantidad_devoluciones = 0;
        foreach ($this->ventas_detalle as $venta_detalle) {
            if (trim($venta_detalle->VE_TIPO) == "Venta") {
                $cantidad_ventas += $venta_detalle->VE_PIEZAS;
            } elseif (trim($venta_detalle->VE_TIPO) == "Devolucion") {
                $cantidad_devoluciones += $venta_detalle->VE_PIEZAS;
            }
        }
        $this->cantidad_ventas = $cantidad_ventas;
        $this->cantidad_devoluciones = $cantidad_devoluciones;
    }

    public function cobranza()
    {
        return trim($this->VE_TIPO) == Tipo::COBRANZA;
    }
}
