<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProveedorNotasPagadas Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $fecha
 * @property int $usuario_id
 * @property int $proveedor_id
 * @property string $descripcion
 * @property float $cantidad
 * @property int $nota_proveedor_id
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Proveedor $proveedor
 * @property \App\Model\Entity\NotaProveedore $nota_proveedore
 */
class ProveedorNotasPagadas extends Entity
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
