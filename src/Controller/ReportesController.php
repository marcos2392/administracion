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
class ReportesController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('Usuarios');
        $this->loadModel('Sucursales');
        $this->loadModel('Transacciones');
        $this->loadModel('MovimientosCaja');
        $this->loadModel('Reparaciones');
        $this->loadModel('Joyeros');
        $this->loadModel('Proveedores');
        $this->loadModel('MovimientosProveedores');
        $this->loadModel('SaldoProveedores');
        
    }

    public function caja(){

        $usuario=$this->getUsuario();

        $cantidad_dia_anterior=[];

        $fechas = $this->setFechasReporte();
        $filtro = $this->request->getQuery('filtro') ?? 'dia';
        $enviado = $this->request->getQuery('enviado') ?? false;

        $usuarios=$this->Usuarios->find()
        ->where(['caja'=>true])
        ->order('nombre');

        $usuario_caja=$this->request->getQuery('usuarios')?? $usuario->id;
        
        $movimientos=[];

        if ($enviado!==false)
        {
            if ($filtro == "dia") {
                $fecha=date('Y-m-d');
                $condicion = ["date(fecha)" => $fecha];

                $fecha_actual = date('Y-m-d H:i');
                $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha_actual ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

                $cantidad_anterior=$this->MovimientosCaja->find()
                ->where(['date(fecha) = "'.$nuevafecha.'" and usuario_id="'.$usuario_caja.'"'])
                ->order('fecha desc')
                ->first();

                $cantidad_dia_anterior=$cantidad_anterior->cantidad_existente;

            } 
            else 
            { 
                $fecha_inicio=date('d-M-Y', $fechas['f1']);
                $fecha_fin=date('d-M-Y', $fechas['f2']);
                $condicion = ["date(fecha) BETWEEN '" . date('Y-m-d', $fechas['f1']) . "' AND '" . date('Y-m-d', $fechas['f2']) . "'"]; 
            }
            
            $condicion[]=["usuario_id"=>$usuario_caja]; 
            $movimientos = $this->MovimientosCaja->find() 
            ->where($condicion)
            ->order('fecha')
            ->toArray();  
        }

        $this->set(compact('filtro','movimientos','fecha_inicio','fecha_fin','usuarios','usuario_caja','cantidad_dia_anterior'));
    }

    public function reparaciones(){

        $usuario=$this->getUsuario();

        $recibos=[];
        $enviado = $this->request->getQuery('enviado') ?? false;
        $fechas = $this->setFechasReporte();
        $filtro = $this->request->getQuery('filtro') ?? 'dia';

        $joyeros=$this->Joyeros->find();
        $joyero = $this->request->getQuery('joyero')?? '';

        if ($enviado!==false)
        { 
            if ($filtro == "dia") {
                $fecha=date('Y-m-d');
                $condicion = ["date(fecha)" => $fecha];
            } 
            else 
            { 
                $fecha_inicio=date('d-M-Y', $fechas['f1']);
                $fecha_fin=date('d-M-Y', $fechas['f2']);
                $condicion = ["date(fecha) BETWEEN '" . date('Y-m-d', $fechas['f1']) . "' AND '" . date('Y-m-d', $fechas['f2']) . "'"]; 
            }
            
            $info_joyero=$this->Joyeros->get($joyero);
            $joyero_nombre=$info_joyero->nombre;

            $condicion[]=["joyero_id"=>$joyero];
            $recibos = $this->Reparaciones->find()
            ->select([
                'cantidad' => 'sum(Reparaciones.cantidad)','sucursal_nombre'=>'Sucursales.nombre'])
            ->join([
                'Sucursales' => [
                    'table' => 'sucursales',
                    'type' => 'inner',
                    'conditions' => ['Sucursales.id = Reparaciones.sucursal_id']]])
            ->where($condicion)
            ->group('sucursal_id')
            
            ->toArray();
        }

        $this->set(compact('filtro','recibos','joyeros','joyero','joyero_nombre','fecha_inicio','fecha_fin','fecha'));

    }

    public function movimientosProveedores(){

        $usuario=$this->getUsuario();

        $proveedores=$this->Proveedores->find()
        ->where(['activo'=>true])
        ->order('nombre')
        ->toArray();

        $fechas = $this->setFechasReporte();
        $filtro = $this->request->getQuery('filtro') ?? 'dia';
        $enviado = $this->request->getQuery('enviado') ?? false;
        $proveedor = $this->request->getQuery('proveedor')?? '';
        
        $movimientos=[];

        if ($enviado!==false)
        { 
            if ($filtro == "dia") {
                $fecha=date('Y-m-d');
                $condicion = ["date(fecha)" => $fecha];
            } 
            else 
            { 
                $fecha_inicio=date('d-M-Y', $fechas['f1']);
                $fecha_fin=date('d-M-Y', $fechas['f2']);
                $condicion = ["date(fecha) BETWEEN '" . date('Y-m-d', $fechas['f1']) . "' AND '" . date('Y-m-d', $fechas['f2']) . "'"]; 
            }
            
            $condicion[]=["proveedor_id"=>$proveedor];
            $movimientos = $this->MovimientosProveedores->find()
            ->contain('Usuarios') 
            ->where($condicion)
            ->order('fecha')
            ->toArray();
        }

        $this->set(compact('filtro','movimientos','fecha_inicio','fecha_fin','proveedores','proveedor'));

    }

    public function saldosProveedores(){

        $saldos=$this->SaldoProveedores->find()
        ->contain('Proveedores')
        ->where(['Proveedores.activo'=>true])
        ->order('Proveedores.nombre')
        ->toArray();

        $this->set(compact('saldos'));

    }
}