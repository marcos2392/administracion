<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reparacione Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $fecha
 * @property int $usuario_id
 * @property int $joyero_id
 * @property int $sucursal_id
 * @property float $cantidad
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Joyero $joyero
 * @property \App\Model\Entity\Sucursal $sucursal
 */
class Reparacion extends Entity
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
