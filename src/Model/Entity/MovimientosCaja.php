<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MovimientosCaja Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $fecha
 * @property int $usuario_id
 * @property string $descripcion
 * @property string $tipo_movimiento
 * @property float $cantidad
 * @property float $cantidad_existente
 *
 * @property \App\Model\Entity\Usuario $usuario
 */
class MovimientosCaja extends Entity
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
