<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DetalleCuentaCobranza Entity
 *
 * @property int $id
 * @property float $saldo_antes
 * @property float $saldo_despues
 * @property int $porcentaje_cargo
 * @property \Cake\I18n\Time $fecha
 * @property int $usuario_id
 * @property bool $cambio_cobrador
 * @property bool $pago
 * @property int $cuenta_cobranza_id
 *
 * @property float $diferencia
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\CuentaCobranza $cuenta_cobranza
 * @property \App\Model\Entity\Transaccion $transaccion
 */
class DetalleCuentaCobranza extends Entity
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

    protected function _getCliente()
    {
        return $this->cuenta_cobranza->cliente;
    }

    protected function _getTipo()
    {
        if ($this->porcentaje_cargo) {
            $tipo = 'Paso a cobranza';
        } elseif ($this->pago) {
            $tipo = 'Pago';
        } elseif ($this->importado) {
            $tipo = 'Último pago sistema viejo';
        } elseif ($this->cambio_cobrador) {
            $tipo = 'Cambio de cobrador';
        } elseif ($this->modificacion_saldo) {
            $tipo = 'Modificación de saldo';
        } else {
            $tipo = '';
        }
        return $tipo;
    }

    protected function _getDiferencia()
    {
        return $this->saldo_antes - $this->saldo_despues;
    }
}
