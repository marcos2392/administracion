<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

/**
 * CuentaPrestamo Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property float $saldo
 * @property float $cantidad_pago
 * @property float $cantidad_prestamo
 * @property float $porcentaje_interes
 * @property float $cantidad_final
 * @property \Cake\I18n\Time $fecha_solicitud
 * @property int $plazo
 * @property string $tipo_plazo
 * @property \Cake\I18n\Time $fecha_final
 * @property bool $atrasado
 * @property int $prestamo_id
 * @property int $sistema_id
 *
 * @property string $clase
 * @property string $proximo_pago_texto
 * @property \App\Model\Entity\PagoCuentaPrestamo $proximo_pago
 * @property string $ultimo_pago_texto
 * @property \App\Model\Entity\PagoCuentaPrestamo|null $proximo_pago
 * @property int $cantidad_pagos_pendientes
 * @property string $descripcion
 * @property bool $cobranza
 * @property \Cake\ORM\Query $cartas
 *
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\Prestamo $prestamo
 * @property \App\Model\Entity\Sistema $sistema
 * @property \App\Model\Entity\PagoCuentaPrestamo[] $pagos_cuenta_prestamo
 * @property \App\Model\Entity\Transaccion[] $transacciones
 * @property \App\Model\Entity\CuentaCobranza $cuenta_cobranza
 */
class CuentaPrestamo extends Entity
{
    /**
     * @var \App\Model\Entity\PagoCuentaPrestamo
     */
    private $_proximo_pago;
    /**
     * @var \App\Model\Entity\PagoCuentaPrestamo
     */
    private $_ultimo_pago;
    /**
     * @var int
     */
    private $_cantidad_pagos_pendientes;

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

    public function vencido(): bool
    {
        return $this->atrasado;
    }

    protected function _getClase(): string
    {
        return 'CuentasPrestamo';
    }

    protected function _getProximoPagoTexto()
    {
        return $this->saldo > 0 ? "{$this->proximo_pago->fecha_limite->format('d-M-Y')} (" . Number::currency($this->proximo_pago->esperado) . ")" : "ND";
    }

    protected function _getProximoPago()
    {
        if (!isset($this->_proximo_pago)) {
            $proximo_pago = TableRegistry::get('PagosCuentaPrestamo')
                ->find('proximoPago', ['cuenta_prestamo' => $this]);
            if (!$proximo_pago) {
                $proximo_pago = TableRegistry::get('PagosCuentaPrestamo')
                    ->find('pagoFinal', ['cuenta_prestamo' => $this]);
            }
            $this->_proximo_pago = $proximo_pago;
        }
        return $this->_proximo_pago;
    }

    /**
     * La fecha del último pago realizado y su cantidad, o ND en caso de no
     * existir
     * @return string
     */
    protected function _getUltimoPagoTexto()
    {
        return $this->ultimo_pago ? "{$this->ultimo_pago->fecha_limite->format('d-M-Y')} (" . Number::currency($this->ultimo_pago->cantidad_pago) . ")" : "ND";
    }

    /**
     * Regresa el registro del último pago realizado en este préstamo o null
     * si no ha hecho pagos
     * @return \App\Model\Entity\PagoCuentaPrestamo|null
     */
    protected function _getUltimoPago()
    {
        if (!isset($this->_ultimo_pago)) {
            $this->_ultimo_pago = TableRegistry::get('PagosCuentaPrestamo')
                ->find('ultimoPago', ['cuenta_prestamo' => $this]);
        }
        return $this->_ultimo_pago;
    }

    protected function _getCantidadPagosPendientes()
    {
        if (!isset($this->_cantidad_pagos_pendientes)) {
            $pagos_pendientes = TableRegistry::get('PagosCuentaPrestamo')
                ->find('cantidadPendientes', ['cuenta_prestamo' => $this])
                ->cantidad ?? 0;
            if ($this->saldo > 0 && $pagos_pendientes == 0) {
                $pagos_pendientes = 1;
            }
            $this->_cantidad_pagos_pendientes = $pagos_pendientes;
        }
        return $this->_cantidad_pagos_pendientes;
    }

    protected function _getDescripcion()
    {
        return "{$this->sistema->nombre} (" . Number::currency($this->cantidad_prestamo) . ")";
    }

    protected function _getCobranza()
    {
        return !!TableRegistry::get('CuentasCobranza')->find()
            ->where(['cuenta_prestamo_id' => $this->id])
            ->first();
    }

    protected function _getCartas()
    {
        $cartas = TableRegistry::get('Cartas')->find()
            ->contain(['TiposCarta'])
            ->where(['TiposCarta.prestamo' => true]);
        if (!$this->vencido()) {
            $cartas->where(['Cartas.atrasados' => false]);
        }
        return $cartas;
    }
}
