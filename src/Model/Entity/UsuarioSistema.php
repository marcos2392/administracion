<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Estuche;

/**
 * Usuario Entity
 *
 * @property string $nombre_usuario
 * @property string $nombre
 * @property string $password
 * @property int $sucursal_id
 * @property bool $activo
 * @property bool $notificar_nueva_solicitud
 * @property bool $notas_proveedores
 *
 * @property \App\Model\Entity\Sucursal $sucursal
 * @property bool $admin
 * @property bool $superadmin
 * @property bool $rol_sucursal
 * @property bool $rol_eventos
 * @property integer $notificaciones_nuevas
 * @property integer $administracion_usuarios
 * @property integer $administracion_configuracion
 */
class UsuarioSistema extends Entity
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
