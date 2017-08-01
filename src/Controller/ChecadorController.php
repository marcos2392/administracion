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
class ChecadorController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('Checadas');
        $this->loadModel('Empleados');
        $this->loadModel('Sucursales');
        
    }

    public function inicio() {

    }

    public function reporte() {

        $usuario = $this->getUsuario();

        $sucursales = $this->Sucursales->find()
            ->where(['id != 0'])
            ->order(['nombre']);

        $sucursal = $usuario->admin ? ($this->request->getQuery('sucursal') ?? '0') : $usuario->sucursal_id;

        if($sucursal!=0)
        {
            $sucursal_nombre =  $this->Sucursales->get($sucursal)->nombre;
        }

        $filtro = $this->request->getQuery('filtro') ?? 'semanal';
        $fechas = $this->setFechasReporte();

        $inicio = date("Y-m-d", strtotime('monday this week -7 days'));
        $fin = date("Y-m-d", strtotime('sunday this week - 7 days'));

        if(!$usuario->admin)
        {
            $sucursal=$usuario->sucursal_id;
        }

        if ($filtro == "semanal") {
            $condicion = ["sucursal= '". $sucursal ."' and fecha between '" . $inicio . "' and '" . $fin . "'"];
        } 
        else 
        {
            $inicio = date('Y-m-d', $fechas['f1']); 
            $fin = date('Y-m-d', $fechas['f2']); 
            $condicion = ["sucursal= '".$sucursal."' and fecha between '" . $inicio . "' and '" . $fin . "'"];
        }

        if ($this->request->is('get')) {

            $registros=$this->Checadas->find()
            ->where($condicion)
            ->order('empleados_id, fecha,checadas.entrada'); 

            $registro=$this->checadas($registros);
        }

        $this->set(compact('inicio','fin','registro','filtro','sucursales','sucursal','sucursal_nombre','empleados'));
    }

    public function editar() {

        $sucursal=$this->request->getQuery('sucursal');

        $registros=$this->Checadas->find()
        ->where(['fecha between "2017-07-24" and "2017-07-30" and sucursal="'.$sucursal.'"'])
        ->order('empleados_id, fecha,checadas.entrada');

        $registro=$this->checadas($registros);

        $this->set(compact('registro','sucursal'));
    }

    public function actualizar() {

        $sucursal = $this->request->getQuery('sucursal'); //debug($sucursal); die;
        $empleados = $this->request->getData(); //debug($empleados); die;

        foreach($empleados as $emp)
        {
            foreach($emp as $id=>$e)
            {
                debug($id); die;
                debug($e); die;
            }
        }

        //$this->redirect(['action' => 'reporte', 'sucursal' => $sucursal,'venta_sucursal'=>$venta_sucursal]);
    }

    private function checadas($registros){

        $registro=[];

        foreach($registros as $reg)
        {
            if(!isset($registro[$reg->empleados_id]))
            {
                $registro[$reg->empleados_id]=[];
            }
            
            $empleados=$this->Empleados->find()
            ->where(['id'=>$reg->empleados_id]);

            foreach($empleados as $empleado)
            {
                $registro[$reg->empleados_id]["checadas"][]=$reg;
                $registro[$reg->empleados_id]["empleado"]=$empleado->ncompleto;
            }

            if(empty($registro)): $this->Flash->default('No se encontraron registros.'); endif;
        }

        return $registro;
    }
}