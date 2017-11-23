<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CobranzaCobrador Entity
 *
 * @property int $id
 * @property int $cobrador_id
 * @property int $cobranza_id
 * @property float $porcentaje_comision
 *
 * @property \App\Model\Entity\Cobrador $cobrador
 * @property \App\Model\Entity\Cobranza $cobranza
 * @property \App\Model\Entity\CorteCobranza[] $cortes_cobranzas
 */
class CobranzaCobrador extends Entity
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
