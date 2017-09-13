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

class ProveedoresController extends AppController
{
    public function beforeFilter(Event $event) {

        $this->loadModel('Proveedores');
        $this->loadModel('SaldoProveedores');
        
    }

    public function proveedores() {

    	$proveedores=$this->Proveedores->find()
        ->where(['activo'=>true])
        ->order('nombre')
        ->toArray();

        $this->set(compact('proveedores'));

    }

    public function nuevo() {

    	$proveedor='';
        $fecha=date('Y-m-d H:i:s');

    	if ($this->request->is('post'))
        {
	    	$proveedor = ucwords(strtolower($this->request->getData('nombre') ?? ''));

	    	$proveedores = $this->Proveedores->newEntity();
            $proveedores->fecha=$fecha;
	    	$proveedores->nombre=$proveedor;

	    	$this->Proveedores->save($proveedores);

            $proveedor_id=$this->Proveedores->find()
            ->order('id desc')
            ->first();

            $saldo_proveedor = $this->SaldoProveedores->newEntity();
            $saldo_proveedor->proveedor_id=$proveedor_id->id;

            $this->SaldoProveedores->save($saldo_proveedor);

	    	$this->Flash->default("Se Creo el Proveedor Correctamente.");
	    	$this->redirect(['action' => 'proveedores']);
	    }

	    $this->set(compact('proveedor'));
    }

    public function editar() {

        $id=$this->request->getParam('id');

        $proveedores=$this->Proveedores->get($id);
        $proveedor=$proveedores->nombre;

        $this->set(compact('proveedores','proveedor'));

    }

    public function actualizar() {

        $id=$this->request->getParam('id');
        $proveedor = ucwords(strtolower($this->request->getData('nombre') ?? ''));

        $proveedores=$this->Proveedores->get($id);
        $proveedores->nombre=$proveedor;

        $this->Proveedores->save($proveedores);

        $this->Flash->default("Se Modifico el Proveedor Correctamente.");
        $this->redirect(['action' => 'proveedores']);

    }

    public function eliminar() {

        $id=$this->request->getParam('id');

        $proveedor=$this->Proveedores->get($id);
        $proveedor->activo=false;

        $this->Proveedores->save($proveedor);

        $this->Flash->default("Se Elimino el Proveedor Correctamente.");
        $this->redirect(['action' => 'proveedores']);


    }
}