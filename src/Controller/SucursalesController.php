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
class SucursalesController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('Sucursales');
        $this->loadModel('SucursalesSistemas');
        $this->loadModel('Usuarios');
        
    }

    public function sucursales() {

    	$usuario=$this->getUsuario();
        $sucursales=$this->Sucursales->find()
        ->order('nombre')
        ->toArray();

        $this->set(compact('sucursales'));
    }

    public function nuevo() {

        $sucursal = $this->Sucursales->newEntity();
        $sucursales_sistema=$this->SucursalesSistemas->find()
        ->toArray();

        $this->set(compact('sucursal','sucursales_sistema'));
    }

    public function crear() {

        $sucursal = $this->Sucursales->newEntity();

        $nombre = $this->request->getData('nombre') ?? '';
        $nombre = ucwords(strtolower($nombre));
        $comision= $this->request->getData('comision') ?? '';
        $generar_nomina = $this->request->getData('generar_nomina') ?? '';
        $venta_minima= $this->request->getData('venta_minima') ?? '';
        $cantidad_venta_minima= $this->request->getData('cantidad_venta_minima')==''? 0: $this->request->getData('cantidad_venta_minima');
        $comision_venta= $this->request->getData('comision_venta') ?? '';
        $porcentaje_venta= $this->request->getData('porcentaje_venta')==''? 0: $this->request->getData('porcentaje_venta');
        $sistema_id = $this->request->getData('sucursal_sistema') ?? '';

        $sucursal->nombre=$nombre;
        $sucursal->comision=$comision;
        $sucursal->generar_nomina=$generar_nomina;
        $sucursal->minimo_venta=$venta_minima;
        $sucursal->cantidad_minima_venta=$cantidad_venta_minima;
        $sucursal->comision_empleados=$comision_venta;
        $sucursal->porcentaje_comision_empleados=$porcentaje_venta;
        $sucursal->sistema_id=$sistema_id;

        if ($this->request->is('post'))
        {
            if($this->Sucursales->save($sucursal))
             {
                $this->Flash->default("Se Creo la Sucursal: ".$nombre." ,exitosamente.");
                $this->redirect(['action' => 'sucursales']);
             }
             else
             {
               $this->Flash->error("Hubo un Error al Crear la Sucursal.");
               $this->redirect(['action' => 'editar']);
             }
        }

        
    }

    public function editar() {

        $sucursal = $this->Sucursales->get($this->request->getParam('id'));
        
        $this->set(compact('sucursal'));
    }

    public function actualizar() {

        $sucursal = $this->Sucursales->get($this->request->getParam('id')); //debug($sucursal); die;

        $nombre = $this->request->getData('nombre') ?? '';
        $nombre = ucwords(strtolower($nombre));
        $comision= $this->request->getData('comision') ?? '';
        $generar_nomina = $this->request->getData('generar_nomina') ?? '';
        $venta_minima= $this->request->getData('venta_minima') ?? '';
        $cantidad_venta_minima= $this->request->getData('cantidad_venta_minima') ?? '';
        $comision_venta= $this->request->getData('comision_venta') ?? '';
        $porcentaje_venta= $this->request->getData('porcentaje_venta') ?? '';

        $sucursal->nombre=$nombre;
        $sucursal->comision=$comision;
        $sucursal->generar_nomina=$generar_nomina;
        $sucursal->minimo_venta=$venta_minima;
        $sucursal->cantidad_minima_venta=$cantidad_venta_minima;
        $sucursal->comision_empleados=$comision_venta;
        $sucursal->porcentaje_comision_empleados=$porcentaje_venta;
 
        if ($this->request->is('post'))
        {
            if($this->Sucursales->save($sucursal))
             {
                $this->Flash->default("Se actualizo la Sucursal: ".$nombre." ,exitosamente.");
                $this->redirect(['action' => 'sucursales']);
             }
             else
             {
               $this->Flash->error("Hubo un Error al Actualizar la Sucursal.");
               $this->redirect(['action' => 'editar']);
             }
        }
    }

    public function eliminar() {

        if ($this->Sucursales->get($this->request->getQuery('id'))) 
        {
            $sucursal = $this->Sucursales->get($this->request->getQuery('id'));
            $sucursal->status=0;

            $this->Sucursales->save($sucursal);

            $this->Flash->default("Se elimino la sucursal correctamente.");
            $this->redirect(['action' => 'sucursales']);
        }
        else
        {
            $this->Flash->default("no");
            $this->redirect(['action' => 'sucursales']);
        }
    }
}