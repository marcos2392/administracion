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
class MovimientosProveedoresController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('MovimientosProveedores');
        $this->loadModel('Proveedores');
        $this->loadModel('SaldoProveedores');
    }

    public function inicio() {

    }

    public function movimientos(){

    	$usuario=$this->getUsuario();
    	$fecha=date('Y-m-d H:i:s');

    	$proveedores=$this->Proveedores->find()
    	->where(['activo'=>true])
        ->order('nombre')
    	->toArray();

    	$proveedor = $this->request->getData('proveedor') ?? '';
    	$descripcion = ucwords(strtolower($this->request->getData('descripcion') ?? ''));
        $tipo_movimiento = $this->request->getData('tipo_movimiento') ?? '';
        $cantidad = $this->request->getData('cantidad') ?? '';

        if ($this->request->is('post'))
        {

        	$ultimo_movimiento=$this->MovimientosProveedores->find()
            ->where(['proveedor_id'=>$proveedor])
            ->order('fecha desc')
            ->first();

            if($ultimo_movimiento==null)
            {
                $saldo=$this->SaldoProveedores->find()
                ->where(['proveedor_id'=>$proveedor])
                ->first();

                $saldo_actual=$saldo->saldo;
            } 
            else
            {
                $saldo_actual=$ultimo_movimiento->saldo;
            } 

            $saldo_nuevo=($tipo_movimiento=="Deposito")? $saldo_actual-$cantidad : $saldo_actual+$cantidad;

            $movimientos_proveedores = $this->MovimientosProveedores->newEntity();

            $movimientos_proveedores->fecha=$fecha;
            $movimientos_proveedores->usuario_id=$usuario->id;
            $movimientos_proveedores->proveedor_id=$proveedor;
            $movimientos_proveedores->tipo=$tipo_movimiento;
            $movimientos_proveedores->descripcion=$descripcion;
            $movimientos_proveedores->cantidad=$cantidad;
            $movimientos_proveedores->saldo_anterior=$saldo_actual;
            $movimientos_proveedores->saldo=$saldo_nuevo;

            $this->MovimientosProveedores->save($movimientos_proveedores);

            $saldo_proveedor=$this->SaldoProveedores->find()
            ->where(['proveedor_id'=>$proveedor])
            ->first();

            $saldo_nuevo=($tipo_movimiento=="Deposito")? $saldo_proveedor->saldo-$cantidad : $saldo_proveedor->saldo+$cantidad;
            $saldo_proveedor->saldo=$saldo_nuevo;

            $this->SaldoProveedores->save($saldo_proveedor);

            $this->Flash->default("Se Guardo ".$tipo_movimiento." Correctamente.");
            $this->redirect(['action' => 'movimientos']);

        }

    	$this->set(compact('proveedores','proveedor'));

    }

    public function editar(){

        $id=$this->request->getParam('id');

        $proveedores=$this->Proveedores->find()
    	->where(['activo'=>true])
    	->toArray();
        
        $movimiento=$this->MovimientosProveedores->get($id);

        $proveedor=$movimiento->proveedor_id;

        $this->set(compact('movimiento','proveedores','proveedor'));

    }

    public function actualizar(){

        $id=$this->request->getData('id');
        $descripcion = ucwords(strtolower($this->request->getData('descripcion') ?? ''));
        $tipo_movimiento = $this->request->getData('tipo_movimiento') ?? '';
        $cantidad = $this->request->getData('cantidad') ?? '';

        $tipo_movimiento=ucwords(strtolower($tipo_movimiento));

        $movimiento=$this->MovimientosProveedores->get($id);

        $movimiento->descripcion=$descripcion;
        $movimiento->tipo=$tipo_movimiento;
        $movimiento->cantidad=$cantidad;

        $this->MovimientosProveedores->save($movimiento);

        $this->RecalcularCantidades($movimiento->proveedor_id,$movimiento->fecha);

        $this->Flash->default("Se Modifico el Movimiento Correctamente.");
        $this->redirect(['action' => 'movimientos']);

    }

    public function eliminar(){

    	$filtro=$this->request->getQuery('filtro');
        $enviado=true;

        $id=$this->request->getParam('id');
        $movimiento=$this->MovimientosProveedores->get($id);

        $this->MovimientosProveedores->delete($movimiento);

        $this->RecalcularCantidades($movimiento->proveedor_id,$movimiento->fecha);

        $this->Flash->default("Se Elimino el Movimiento Correctamente.");
        $this->redirect(['controller'=>'Reportes','action' => 'movimientos_proveedores']);

    }

    private function RecalcularCantidades($proveedor,$fecha){

        $movimiento_anterior=$this->MovimientosProveedores->find()
        ->where(['fecha <'=>$fecha,'proveedor_id'=>$proveedor])
        ->first();

        $saldo=$movimiento_anterior->saldo;

        $recalcular=$this->MovimientosProveedores->find()
        ->where(['fecha > "'.$movimiento_anterior->fecha->format('Y-m-d H:i:s').'" and proveedor_id = "'.$proveedor.'" '])
        ->order('fecha')
        ->toArray();

        foreach($recalcular as $registro)
        {
            $movimiento=$this->MovimientosProveedores->get($registro->id);

            $movimiento->saldo_anterior=$saldo;
            $movimiento->saldo=($movimiento->tipo=="Nota")? $saldo+=$movimiento->cantidad : $saldo-=$movimiento->cantidad;

            $this->MovimientosProveedores->save($movimiento);
        }

        $saldo_proveedor=$this->SaldoProveedores->find()
        ->where(['proveedor_id'=>$proveedor])
        ->first();

        $saldo_proveedor->saldo=$saldo;

        $this->SaldoProveedores->save($saldo_proveedor);
    }

}