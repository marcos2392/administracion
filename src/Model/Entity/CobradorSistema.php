<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Cobrador Entity
 *
 * @property int $id
 * @property string $nombre
 * @property bool $eliminado
 *
 * @property int $total_clientes_prestamo
 *
 * @property \App\Model\Entity\CuentaCobranza[] $cuentas_cobranza
 */
class Cobrador extends Entity
{
    private $_total_clientes;
    private $_total_clientes_prestamo;
    private $_cartera;
    private $_cartera_prestamos;

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

    protected function _getTotalClientes()
    {
        if (!isset($this->_total_clientes)) {
            $c_query = TableRegistry::get('Clientes')->find();
            $this->_total_clientes = $c_query
                ->select(['total' => $c_query->func()->count('*')])
                ->contain(['CuentasCobranza'])
                ->where([
                    'Clientes.activo' => true,
                    'Clientes.cobranza' => true,
                    'CuentasCobranza.saldo >' => 0,
                    'CuentasCobranza.cobrador_id' => $this->id
                ])
                ->first()['total'];
        }
        return $this->_total_clientes;
    }

    protected function _getTotalClientesPrestamo()
    {
        if (!isset($this->_total_clientes_prestamo)) {
            $cp_query = TableRegistry::get('CuentasPrestamo')
                ->find('cuentasCobrador', ['cobrador' => $this]);
            $this->_total_clientes_prestamo = $cp_query
                ->select(['total' => $cp_query->func()->count('*')])
                ->first()['total'] ?? 0;
        }
        return $this->_total_clientes_prestamo;
    }

    protected function _getCartera()
    {
        if (!isset($this->_cartera)) {
            $cc_query = TableRegistry::get('CuentasCobranza')->find();
            $this->_cartera = $cc_query
                ->select(['total' => $cc_query->func()->sum('saldo')])
                ->contain(['Clientes'])
                ->where([
                    'Clientes.activo' => true,
                    'Clientes.cobranza' => true,
                    'CuentasCobranza.saldo >' => 0,
                    'CuentasCobranza.cobrador_id' => $this->id
                ])
                ->first()['total'];
        }
        return $this->_cartera;
    }

    protected function _getCarteraPrestamos()
    {
        if (!isset($this->_cartera_prestamos)) {
            $cp_query = TableRegistry::get('CuentasPrestamo')
                ->find('cuentasCobrador', ['cobrador' => $this]);
            $this->_cartera_prestamos = $cp_query
                ->select(['total' => $cp_query->func()->sum('saldo')])
                ->first()['total'] ?? 0;
        }
        return $this->_cartera_prestamos;
    }
}
