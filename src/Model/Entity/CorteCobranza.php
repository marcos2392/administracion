<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CorteCobranza Entity
 *
 * @property int $id
 * @property int $corte_id
 * @property int $cobranza_cobrador_id
 * @property float $cantidad
 * @property float $comision
 * @property float $porcentaje_comision
 *
 * @property \App\Model\Entity\Corte $corte
 * @property \App\Model\Entity\CobranzaCobrador $cobranza_cobrador
 */
class CorteCobranza extends Entity
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
