<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;

use Cake\ORM\TableRegistry;

/**
 * Reportes Controller
 *
 * @property \App\Model\Table\ReportesTable $Reportes
 */
class PrincipalController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('Usuarios');
        
    }

    public function inicio() {

    	/*$usuario=$this->getUsuario();

        $sucursales = TableRegistry::get('Sucursales');

        $usuarios=$sucursales->find();

        $this->set(compact('usuarios'));*/
    }
}