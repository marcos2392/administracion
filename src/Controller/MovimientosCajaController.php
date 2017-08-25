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
class MovimientosCajaController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('MovimientosCaja');
        $this->loadModel('Usuarios');
    }

    public function caja() {

        $usuario=$this->getUsuario();

        $usuarios_caja=[];
        $condicion=[];

        if($usuario->admin)
        {
            $usuarios=$this->Usuarios->find()
            ->where(['caja'=>true]);

            foreach($usuarios as $user)
            {
                $cantidad_actual=$this->MovimientosCaja->find()
                ->where(['usuario_id'=>$user->id])
                ->order('id desc')
                ->first();

                $usuarios_caja[$user->nombre]=($cantidad_actual!=null)? $cantidad_actual->cantidad_existente : 0 ;
            }
        }
        else
        {
            $cantidad_actual=$this->MovimientosCaja->find()
            ->where(['usuario_id'=>$usuario->id])
            ->order('id desc')
            ->first();

            $usuarios_caja[$usuario->nombre]=($cantidad_actual!=null)? $cantidad_actual->cantidad_existente : 0 ;
        }
        
        $this->set(compact('usuarios_caja'));
    }

    public function movimientos() {

        $usuario = $this->getUsuario();

        $descripcion = $this->request->getData('descripcion') ?? '';
        $tipo_movimiento = $this->request->getData('tipo_movimiento') ?? '';
        $cantidad = $this->request->getData('cantidad') ?? '';

        $descripcion=ucwords(strtolower($descripcion));
        $tipo_movimiento=ucwords(strtolower($tipo_movimiento));

        if ($this->request->is('post'))
        {
            $ultimo_movimiento=$this->MovimientosCaja->find()
            ->where(['usuario_id'=>$usuario->id])
            ->order('id desc')
            ->first();

            $cantidad_existente=($ultimo_movimiento!=null)? $ultimo_movimiento->cantidad_existente : 0;

            $movimiento_caja = $this->MovimientosCaja->newEntity();

            $movimiento_caja->usuario_id=$usuario->id;
            $movimiento_caja->descripcion=$descripcion;
            $movimiento_caja->tipo_movimiento=$tipo_movimiento;
            $movimiento_caja->cantidad=$cantidad;
            $movimiento_caja->cantidad_existente=($tipo_movimiento=="Ingreso")? $cantidad_existente+$cantidad : $cantidad_existente-$cantidad;

            $this->MovimientosCaja->save($movimiento_caja);

            $this->Flash->default("Se Guardo el Movimiento Correctamente.");
            $this->redirect(['action' => 'movimientos']);
        }
    }

    public function editar(){

        $id=$this->request->getParam('id');
        
        $movimiento=$this->MovimientosCaja->get($id);

        $this->set(compact('movimiento'));

    }

    public function actualizar(){

        $fecha=date('Y-m-d');
        $id=$this->request->getData('id');
        $descripcion = $this->request->getData('descripcion') ?? '';
        $tipo_movimiento = $this->request->getData('tipo_movimiento') ?? '';
        $cantidad = $this->request->getData('cantidad') ?? '';

        $descripcion=ucwords(strtolower($descripcion));
        $tipo_movimiento=ucwords(strtolower($tipo_movimiento));

        $movimiento=$this->MovimientosCaja->get($id);

        $movimiento->descripcion=$descripcion;
        $movimiento->tipo_movimiento=$tipo_movimiento;
        $movimiento->cantidad=$cantidad;

        $this->MovimientosCaja->save($movimiento);

        $this->RecalcularCantidades($id);

        $this->Flash->default("Se Modifico el Movimiento Correctamente.");
        $this->redirect(['action' => 'movimientos']);

    }

    public function eliminar(){

        $filtro=$this->request->getQuery('filtro');
        $enviado=true;

        $id=$this->request->getParam('id');
        $movimiento=$this->MovimientosCaja->get($id);

        $this->MovimientosCaja->delete($movimiento);

        $this->RecalcularCantidades($id);

        $this->redirect(['controller'=>'Reportes','action' => 'caja']);

    }

    private function RecalcularCantidades($id){

        $saldo_anterior=$this->MovimientosCaja->find()
        ->where(['id <'=>$id])
        ->first();

        $saldo=$saldo_anterior->cantidad_existente; 

        $recalcular=$this->MovimientosCaja->find()
        ->where(['id > "'.$saldo_anterior->id.'"'])
        ->order('id asc')
        ->toArray();

        foreach($recalcular as $registro)
        {
            $movimiento=$this->MovimientosCaja->get($registro->id);

            $movimiento->cantidad_existente=($movimiento->tipo_movimiento=="Ingreso")? $saldo+=$movimiento->cantidad : $saldo-=$movimiento->cantidad;

            $this->MovimientosCaja->save($movimiento);
        }
    }
}