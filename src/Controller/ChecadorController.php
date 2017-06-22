<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

/**
 * Reportes Controller
 *
 * @property \App\Model\Table\ReportesTable $Reportes
 */
class ChecadorController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('Empleados');
        $this->loadModel('Sucursales');
        $this->loadModel('Clientes');
        
    }

    public function reporte(){

    	$filtro = $this->request->getQuery('filtro') ?? 'semanal';
    	$fechas = $this->setFechasReporte();

    	$sucursal=$this->request->getQuery('sucursal');

    	$suc='';
        $sucursales=$this->Sucursales->find()
        ->order('nombre');

    	$this->set(compact('filtro','suc','sucursales','sucursal'));

    }
}