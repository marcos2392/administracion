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
class ReparacionesController extends AppController
{
    public function beforeFilter(Event $event) {

        $this->loadModel('Joyeros');
        $this->loadModel('Sucursales');
        $this->loadModel('Reparaciones');
        
    }

    public function reparaciones() {

        $fecha=date('Y-m-d H:i');
        $usuario = $this->getUsuario();

        $joyeros=$this->Joyeros->find();
        $sucursales=$this->Sucursales->find()
        ->order('nombre');

        $joyero = $this->request->getData('joyero')?? '';
        $sucursal = $this->request->getData('sucursal')?? '';
        $cantidad = $this->request->getData('cantidad');


        if ($this->request->is('post'))
        {

            $recibo = $this->Reparaciones->newEntity();

            $recibo->fecha=$fecha;
            $recibo->usuario_id=$usuario->id;
            $recibo->joyero_id=$joyero;
            $recibo->sucursal_id=$sucursal;
            $recibo->cantidad=$cantidad;

            $this->Reparaciones->save($recibo);

            $this->Flash->default("Se Guardo Correctamente.");
        }
        
        $this->set(compact('joyeros','sucursales','joyero','sucursal'));
    }

    public function recibosCapturados(){

        $fecha=date('Y-m-d');

        $recibos=$this->Reparaciones->find()
        ->where(['date(fecha)'=>$fecha])
        ->contain(['Joyeros','Sucursales'])
        ->order('Sucursales.nombre')
        ->toArray();

        $this->set(compact('recibos'));

    }

    public function editar(){

        $id=$this->request->getParam('id');

        $joyeros=$this->Joyeros->find();
        $sucursales=$this->Sucursales->find()
        ->order('nombre');

        $recibo=$this->Reparaciones->get($id);

        $joyero=$recibo->joyero_id;
        $sucursal=$recibo->sucursal_id;
        $cantidad=$recibo->cantidad;

        $this->set(compact('joyero','sucursal','cantidad','joyeros','sucursales','id'));

    }

    public function actualizar(){

        $id=$this->request->getData('id');

        $recibo_editar=$this->Reparaciones->get($id);

        $joyero = $this->request->getData('joyero')?? '';
        $sucursal = $this->request->getData('sucursal')?? '';
        $cantidad = $this->request->getData('cantidad');

        $recibo_editar->joyero_id=$joyero;
        $recibo_editar->sucursal_id=$sucursal;
        $recibo_editar->cantidad=$cantidad;

        $this->Reparaciones->save($recibo_editar);

        $this->Flash->default("Se Edito el Recibo Correctamente.");

        $this->redirect(['action' => 'recibos_capturados']);

    }

    public function eliminar(){

        $id=$this->request->getParam('id');

        $recibo=$this->Reparaciones->get($id);

        $this->Reparaciones->delete($recibo);

        $this->Flash->default("Se Elimino el Recibo Correctamente.");
        $this->redirect(['action' => 'recibos_capturados']);

    }
}