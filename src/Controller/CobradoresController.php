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
        $this->loadModel('Cobranzas');
        
    }

    public function cobradores() {

        $cobradores=$this->Cobradores->find()
        ->where(['activo'=>true]);

        $this->set(compact('cobradores'));

    }

    public function nuevo() {

    	$cobrador = $this->Cobradores->newEntity();

        $cobranzas=$this->Cobranzas->find()
        ->toArray();

    	if ($this->request->is('post'))
        {
            $cobrador=$this->Cobradores->patchEntity($cobrador,$this->request->getData());

            $cobrador->fecha=date('Y-m-d');
            $cobrador->activo=true;

            if($this->Cobradores->save($cobrador))
            {
	    	  $this->Flash->default("Se Creo el Crobador Correctamente.");
              return $this->redirect(['action' => 'cobradores']);
            }
            else
            {
               $this->Flash->error("No se creo el Cobrador"); 
            }
	    }

	    $this->set(compact('cobrador','cobranzas'));
    }

    public function editar() {

        $id=$this->request->getParam('id');

        $cobranzas=$this->Cobranzas->find()
        ->toArray();

        $cobrador=$this->Cobradores->get($id,["contain"=>["CobranzasCobradores"]]);


        if ($this->request->is(['post','put','patch']))
        {
            $cobrador=$this->Cobradores->patchEntity($cobrador,$this->request->getData());

            if($this->Cobradores->save($cobrador))
            {
              $this->Flash->default("Se Actualizo el Crobador Correctamente.");
              return $this->redirect(['action' => 'cobradores']);
            }
            else
            {
               $this->Flash->error("No se modifico el Cobrador"); 
            }
        }

        $this->set(compact('cobrador','cobranzas'));

    }

    public function eliminar() {

        $id=$this->request->getParam('id');

        $cobrador=$this->Cobradores->get($id);
        $cobrador->activo=false;

        if($this->Cobradores->save($cobrador))
        {
            $this->Flash->default("Se Elimino el Crobador Correctamente.");
        }
        else
        {
            $this->Flash->default("No Se Elimino el Crobador.");
        }

        $this->redirect(['action' => 'cobradores']);


    }

}