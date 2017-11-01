<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HorariosNomina Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $entrada_real
 * @property \Cake\I18n\Time $salida_real
 * @property \Cake\I18n\Time $entrada_nomina
 * @property \Cake\I18n\Time $salida_nomina
 */
class HorariosNomina extends Entity
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
