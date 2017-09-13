<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Movimientosproveedor Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $fecha
 * @property int $usuario_id
 * @property int $proveedor_id
 * @property string $tipo
 * @property string $descripcion
 * @property float $cantidad
 * @property float $saldo
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Proveedor $proveedor
 */
class Movimientosproveedor extends Entity
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
}
