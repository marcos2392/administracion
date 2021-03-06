<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use \Cake\ORM\TableRegistry;

/**
 * Cobrador Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $fecha
 * @property string $nombre
 * @property bool $activo
 */
class Cobrador extends Entity
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

    public function tieneCobranza($cobranza_id) {

        $cobrador_id=$this->_properties['id'];

        $tiene_cobranza=TableRegistry::get('CobranzasCobradores')->find()
        ->where(['cobranza_id'=>$cobranza_id, 'cobrador_id'=>$cobrador_id])
        ->first();

        return $tiene_cobranza;
    }
}
