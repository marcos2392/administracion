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
        $this->loadModel('CobradoresSistema');
        $this->loadModel('Cobranzas');
        $this->loadModel('Empleados');
        
    }

    public function cobradores() {

        $cobradores=$this->Cobradores->find()
        ->where(['activo'=>true]);

        $this->set(compact('cobradores'));

    }

    public function nuevo() {

    	$cobrador = $this->Cobradores->newEntity();
        $fecha=date('Y-m-d H:i:s');
        $cobranzas=$this->Cobranzas->find()
        ->toArray();

    	if ($this->request->is('post'))
        {
            $cobrador=$this->Cobradores->patchEntity($cobrador,$this->request->getData());

            $cobrador_sistema=$this->CobradoresSistema->newEntity();
            $cobrador_sistema->nombre=ucwords(strtolower($cobrador->nombre));
            $cobrador_sistema->fecha=$fecha;
            $this->CobradoresSistema->save($cobrador_sistema);

            $cobrador_sistema=$this->CobradoresSistema->find()
            ->order('fecha desc')
            ->first();

            if($this->request->getData()["checkbox_empleado"])
            {
               $empleados=$this->Empleados->newEntity();
               $empleados->nombre=ucwords(strtolower($cobrador->nombre));
               $empleados->apellidos='';
               $empleados->descanso=0;
               $empleados->sucursal_id=12;
               $empleados->infonavit=0;
               $empleados->sueldo=0;
               $empleados->porcentaje_comision=0;
               $empleados->empleado_id=0;
               $empleados->joyeria=false;
               $empleados->prestamo=false;
               $empleados->fecha=$fecha;
               $this->Empleados->save($empleados);

               $empleado=$this->Empleados->find()
                ->order('fecha desc')
                ->first();

                $cobrador->empleados_id=$empleado->id;
            }

            $cobrador->fecha=$fecha;
            $cobrador->activo=true;
            $cobrador->id_cobrador_sistema=$cobrador_sistema->id;

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