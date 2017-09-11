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
        $this->loadModel('Checadas');
        $this->loadModel('Sucursales');
        $this->loadModel('Empleados');
        $this->loadModel('NominaEmpleadas');
        $this->loadModel('Transacciones');
        $this->loadModel('MovimientosCaja');
        $this->loadModel('Reparaciones');
        $this->loadModel('Joyeros');
        
    }

    public function inicio() {

        $fecha=date("Y-m-d");
    	$usuario=$this->getUsuario();
        $checadas='';

        $inicio_nomina=date("Y-m-d",strtotime('monday this week -7 days'));
        $termino_nomina=date("Y-m-d",strtotime('sunday this week - 7 days'));

        $pago_joyeria=0;

    	$suc='';
        $sucursales=$this->Sucursales->find()
        ->order('nombre');

         $sucursal = $usuario->admin ? ($this->request->getData('sucursal') ?? '0') : $usuario->sucursal->id;

         if ($this->request->is('post')) {

            $sucursal_capturada=$this->getnomina($sucursal);

            if($sucursal_capturada->isEmpty())
            {
                $checadas=$this->Checadas->find()
                ->contain('Sucursales')
                ->where(['sucursal'=>$sucursal])
                ->order('empleados_id');

                $sucursal_operaciones=$this->Sucursales->find()
                ->where(['id'=>$sucursal]);

                foreach($sucursal_operaciones as $so):
                    $comision=$so->comision;
                    $bono=$so->bono;
                    $comision_empleados=$so->comision_empleados;
                    $sistema_id=$so->sistema_id;
                endforeach;

                $conn = ConnectionManager::get('checador');
                $query = $conn->execute('SELECT *,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) AS horas_totales FROM checadas  where fecha between "'.$inicio_nomina.'" and "'.$termino_nomina.'" and sucursal= "'.$sucursal.'"  group by(empleados_id)');
                $horast = $query ->fetchAll('assoc');

                $registros=[];
                foreach($horast as $ht)
                {
                    $nombre=$this->Empleados->get($ht["empleados_id"]);
                    $registros[$ht["empleados_id"]]["hrs"]=$ht;
                    $registros[$ht["empleados_id"]]["empleado"]=$nombre;
                }

                foreach($registros as $id=>$reg):
                    $save = $this->NominaEmpleadas->newEntity();

                    $horastotales=$reg["hrs"]["horas_totales"];
                    $separar[1]=explode(':',$horastotales);
                    $horastotales=$separar[1][0]+($separar[1][1]/60);

                    $sueldo=round($reg["empleado"]->sueldo/48*($horastotales));

                    if($comision==true)
                    {
                        $venta_semanal=$this->Transacciones->find()
                        ->select(['vta'=>'sum(TR_ABONO)'])
                        ->where(["Convert(date,TR_FECHA) between '". $inicio_nomina ."' and '". $termino_nomina ."' and VE_SUCURSAL= '".$sistema_id."'"])
                        ->toArray(); 

                        foreach($venta_semanal as $vta):
                            $vs=$vta->vta;
                            $comision=round(($vs*$reg["empleado"]->porcentaje_comision)/48*($horastotales));
                        endforeach;
                    }

                    if($reg["empleado"]->joyeria==true)
                    {
                        $pago_joyeria=$this->getpagojoyeria($reg["empleado"]->empleado_id);
                    }
                    
                    $save->fecha=$fecha;
                    $save->fecha_inicio=$inicio_nomina;
                    $save->fecha_fin=$termino_nomina;
                    $save->sueldo=$sueldo;
                    $save->comision=$comision;
                    $save->empleados_id=$reg["empleado"]->id;
                    $save->sucursal_id=$reg["empleado"]->sucursal_id;
                    $save->horas=$horastotales;
                    $save->infonavit=$reg["empleado"]->infonavit;
                    $save->joyeria=$pago_joyeria;
                    $this->NominaEmpleadas->save($save);
                endforeach;  
            }
        }

        $sucursal_capturada=$this->getnomina($sucursal);
        $this->set(compact('sucursales','suc','sucursal','registros','venta_semanal','sucursal_capturada'));
    }

    public function PagoNominas(){

        $filtro = $this->request->getQuery('filtro') ?? 'semanal';
        $fechas = $this->setFechasReporte();

        $enviado = $this->request->getQuery('enviado') ?? false;


        $this->set(compact('inicio_nomina','termino_nomina','filtro'));
    }

    public function caja(){

        $usuario=$this->getUsuario();

        $fechas = $this->setFechasReporte();
        $filtro = $this->request->getQuery('filtro') ?? 'dia';
        $enviado = $this->request->getQuery('enviado') ?? false;

        $usuarios=$this->Usuarios->find()
        ->where(['caja'=>true])
        ->order('nombre');

        $usuario_caja=$this->request->getQuery('usuarios');
        
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
            
            $condicion[]=["usuario_id"=>$usuario_caja]; 
            $movimientos = $this->MovimientosCaja->find() 
            ->where($condicion)
            ->toArray();  
        }

        $this->set(compact('filtro','movimientos','fecha_inicio','fecha_fin','usuarios','usuario_caja'));
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

    private function getNomina($sucursal) {
        $sucursal_capturada=$this->NominaEmpleadas->find()
            ->contain('Empleados')
            ->where(['nominaempleadas.sucursal_id'=>$sucursal]);
        return $sucursal_capturada;
    }

    private function getPagoJoyeria($id) {
        $joyeria=$this->Transacciones->find()
        ->where(['CL_CODIGO'=>$id,'VE_SUCURSAL'=>0])
        ->toArray();

        foreach($joyeria as $joy):
            $pago_joyeria=$joy->TR_ABONO;
        endforeach;

        return $pago_joyeria;
    }
}