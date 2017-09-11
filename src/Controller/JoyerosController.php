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
class JoyerosController extends AppController
{
    public function beforeFilter(Event $event) {

        $this->loadModel('Joyeros');
        
    }

    public function joyeros() {

        $joyeros=$this->Joyeros->find()
        ->where(['activo'=>true]);

        $this->set(compact('joyeros'));

    }

    public function nuevo() {

    	$joyero='';
        $fecha=date('Y-m-d');

    	if ($this->request->is('post'))
        {
	    	$joyero = ucwords(strtolower($this->request->getData('nombre') ?? ''));

	    	$joyeros = $this->Joyeros->newEntity();
            $joyeros->fecha=$fecha;
	    	$joyeros->nombre=$joyero;

	    	$this->Joyeros->save($joyeros);

	    	$this->Flash->default("Se Creo el Joyero Correctamente.");
	    	$this->redirect(['action' => 'joyeros']);
	    }

	    $this->set(compact('joyero'));
    }

    public function editar() {

        $id=$this->request->getParam('id');

        $joyeros=$this->Joyeros->get($id);
        $joyero=$joyeros->nombre;

        $this->set(compact('joyeros','joyero'));

    }

    public function actualizar() {

        $id=$this->request->getParam('id');
        $joyero = ucwords(strtolower($this->request->getData('nombre') ?? ''));

        $joyeros=$this->Joyeros->get($id);
        $joyeros->nombre=$joyero;

        $this->Joyeros->save($joyeros);

        $this->Flash->default("Se Modifico el Joyero Correctamente.");
        $this->redirect(['action' => 'joyeros']);

    }

    public function eliminar() {

        $id=$this->request->getParam('id');

        $joyero=$this->Joyeros->get($id);
        $joyero->activo=false;

        $this->Joyeros->save($joyero);

        $this->Flash->default("Se Elimino el Joyero Correctamente.");
        $this->redirect(['action' => 'joyeros']);


    }

}