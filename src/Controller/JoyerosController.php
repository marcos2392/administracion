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

        $joyeros=$this->Joyeros->find();

        $this->set(compact('joyeros'));

    }

    public function nuevo() {

    	$joyero='';
        $fecha=date('Y-m-d');

    	if ($this->request->is('post'))
        {
	    	$joyero = ucwords(strtolower($this->request->getData('nombre') ?? ''));

	    	$joyeros = $this->Joyeros->newEntity();
	    	$joyeros->nombre=$joyero;
            $joyeros->fecha=$fecha;

	    	$this->Joyeros->save($joyeros);

	    	$this->Flash->default("Se Creo el Joyero Correctamente.");
	    	$this->redirect(['action' => 'joyeros']);
	    }

	    $this->set(compact('joyero'));
        
    }

}