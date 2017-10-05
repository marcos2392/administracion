<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Error\Debugger;
use Cake\I18n\Number;
use App\Model\Entity\Sistema;

/**
 * CuentaJoyeria Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property float $saldo
 * @property \Cake\I18n\Time $fecha_limite
 * @property float $diferencia_pago
 * @property float $falta_pagar
 * @property \Cake\I18n\Time $ultima_revision
 * @property int $sucursal_id
 * @property float $limite_credito
 *
 * @property float $credito_disponible
 * @property float $porcentaje_etiqueta
 * @property string $clase
 * @property string $descripcion
 * @property bool $cobranza
 * @property \Cake\ORM\Query $cartas
 */
class CuentaJoyeria extends Entity
{
    /**
     * El límite default a usar cuando se crea un nuevo cliente
     *
     * @var int
     */
    const LIMITE_DEFAULT = 5000;

    /**
     * undocumented class variable
     *
     * @var \Cake\I18n\Time
     */
    private $_ultimo_pago;

    protected function _getContado()
    {
        return $this->sistema_id == Sistema::CONTADO_MAYOREO;
    }

    public function calcularPagoMinimo($saldo = null)
    {
        $saldo = is_null($saldo) ? (float)$this->saldo : (float)$saldo;

        $variables_table = TableRegistry::get('Variables');
        $pago_minimo_empleadas = (float)$variables_table->find()
            ->where(['Variables.nombre' => 'pago_minimo_empleado'])
            ->first()['valor'];
        $pago_minimo_general = (float)$variables_table->find()
            ->where(['Variables.nombre' => 'pago_minimo_cliente'])
            ->first()['valor'];

        $empleada = TableRegistry::get('Clientes')->get($this->cliente_id, [
            'select' => 'empleado'
        ])['empleado'];
        $pago_minimo = ($empleada) ? $pago_minimo_empleadas : $pago_minimo_general;

        if ($saldo <= $pago_minimo) {
            $cantidad_pago_minimo = $saldo;
        } elseif (($saldo * 0.1) <= $pago_minimo) {
            $cantidad_pago_minimo = $pago_minimo;
        } else {
            $cantidad_pago_minimo = $saldo * 0.1;
        }
        return ceil($cantidad_pago_minimo);
    }

    public function proximoPagoTexto()
    {
        $texto = Number::currency($this->proximoPago());
        if ($this->diferencia_pago < 0 && $this->proximoPago() < $this->saldo) {
            $signo = $this->diferencia_pago > 0 ? "-" : "+";
            $tipo_diferencia = $this->diferencia_pago > 0 ? "adelantado" : "atrasado";
            $texto .= "<br>(" . Number::currency($this->pagoMinimo()) . " $signo " . Number::currency(abs($this->diferencia_pago)) . " $tipo_diferencia)";
        }
        return $texto;
    }

    public function pagoMinimo()
    {
        return $this->calcularPagoMinimo($this->saldoMayorDelDia());
    }

    public function proximoPago()
    {
        if ($this->falta_pagar > 0) {
            return $this->falta_pagar;
        } else {
            return min(($this->pagoMinimo() - $this->diferencia_pago), $this->saldo);
        }
    }

    private function saldoMayorDelDia()
    {
        $transacciones_dia = TableRegistry::get('Transacciones')->find()
            ->where(['cliente_id' => $this->cliente_id, 'CONVERT(DATE, fecha) =' => date('Y-m-d')])
            ->order(['fecha ASC']);
        if ($transacciones_dia->isEmpty()) {
            return $this->saldo;
        }

        $saldo_mayor = $this->saldo;
        foreach ($transacciones_dia as $transaccion) {
            if (max($transaccion->saldo, $transaccion->saldo_anterior) > $saldo_mayor) {
                $saldo_mayor = max($transaccion->saldo, $transaccion->saldo_anterior);
            }
            if ($transaccion->pago > 0) {
                $saldo_mayor = $transaccion->saldo;
            }
        }
        return $saldo_mayor;
    }

    public function vencido()
    {
        $fl = ($this->fecha_limite) ? $this->fecha_limite->format('Y-m-d') : null;
        return $fl ? ($fl < date('Y-m-d')) : false;
    }

    public function ultimoPago()
    {
        if (!isset($this->_ultimo_pago)) {
            $this->_ultimo_pago = TableRegistry::get('Transacciones')->find()
                ->select(['fecha'])
                ->where(['cliente_id' => $this->cliente_id, 'pago >' => 0])
                ->order(['fecha DESC'])
                ->first();
        }
        return $this->_ultimo_pago;
    }

    protected function _getCreditoDisponible()
    {
        return $this->limite_credito - $this->saldo;
    }

    protected function _getPorcentajeEtiqueta()
    {
        return ($this->cliente->promocion) ? $this->cliente->promocion->porcentaje_etiqueta : $this->sistema->porcentaje_etiqueta;
    }

    /**
     * La clase a la que pertenece
     */
    protected function _getClase()
    {
        return 'CuentasJoyeria';
    }

    protected function _getDescripcion()
    {
        return $this->sistema->nombre;
    }

    protected function _getCobranza()
    {
        return !!TableRegistry::get('CuentasCobranza')->find()
            ->where(['cuenta_joyeria_id' => $this->id, 'saldo >' => 0])
            ->first();
    }

    protected function _getCartas()
    {
        $cartas = TableRegistry::get('Cartas')->find()
            ->contain(['TiposCarta'])
            ->where(['TiposCarta.joyeria' => true]);
        if (!$this->vencido()) {
            $cartas->where(['Cartas.atrasados' => false]);
        }
        return $cartas;
    }
}
