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
class CobradoresController extends AppController
{
    public function beforeFilter(Event $event) {

        $this->loadModel('Cobradores');
        
    }

    public function cobradores() {

        $cobradores=$this->Cobradores->find()
        ->where(['activo'=>true]);

        $this->set(compact('cobradores'));

    }

    public function nuevo() {

    	$cobrador='';
        $fecha=date('Y-m-d');

    	if ($this->request->is('post'))
        {
	    	$cobrador = ucwords(strtolower($this->request->getData('nombre') ?? ''));

	    	$cobradores = $this->Cobradores->newEntity();
            $cobradores->fecha=$fecha;
	    	$cobradores->nombre=$cobrador;

	    	$this->Cobradores->save($cobradores);

	    	$this->Flash->default("Se Creo el Crobador Correctamente.");
	    	$this->redirect(['action' => 'cobradores']);
	    }

	    $this->set(compact('cobrador'));
    }

    public function editar() {

        $id=$this->request->getParam('id');

        $cobradores=$this->Cobradores->get($id);
        $cobrador=$cobradores->nombre;

        $this->set(compact('cobradores','cobrador'));

    }

    public function actualizar() {

        $id=$this->request->getParam('id');
        $cobrador = ucwords(strtolower($this->request->getData('nombre') ?? ''));

        $cobradores=$this->Cobradores->get($id);
        $cobradores->nombre=$cobrador;

        $this->Cobradores->save($cobradores);

        $this->Flash->default("Se Modifico el Cobrador Correctamente.");
        $this->redirect(['action' => 'cobradores']);

    }

    public function eliminar() {

        $id=$this->request->getParam('id');

        $cobrador=$this->Cobradores->get($id);
        $cobrador->activo=false;

        $this->Cobradores->save($cobrador);

        $this->Flash->default("Se Elimino el Crobador Correctamente.");
        $this->redirect(['action' => 'cobradores']);


    }

}