<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * Reportes Controller
 *
 * @property \App\Model\Table\ReportesTable $Reportes
 */
class NominasController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('Usuarios');
        $this->loadModel('Checadas');
        $this->loadModel('Sucursales');
        $this->loadModel('Empleados');
        $this->loadModel('NominaEmpleadas');
        $this->loadModel('Transacciones');
        $this->loadModel('VentasSucursales');
        
    }

    public function nominas() {

        $fecha=date("Y-m-d");
    	$usuario=$this->getUsuario();
        $checadas='';

        $inicio_nomina=date("Y-m-d",strtotime('monday this week -7 days'));
        $termino_nomina=date("Y-m-d",strtotime('sunday this week -7 days'));

        $pago_joyeria=0;

    	$suc='';
        $sucursales=$this->Sucursales->find()
        ->order('nombre');

         $sucursal=$this->request->getQuery('sucursal');

         $filtro = $this->request->getQuery('filtro') ?? 'semanal';
         $fechas = $this->setFechasReporte();

         $enviado = $this->request->getQuery('enviado') ?? false;

        $sucursal_operaciones=$this->Sucursales->find()
        ->where(['id'=>$sucursal]);

        foreach($sucursal_operaciones as $so):
            $sucursal_nombre=$so->nombre;
        endforeach;

         if ($enviado!==false) {
            if ($filtro == "rango") {
                $inicio_nomina=date('Y-m-d', $fechas['f1']); 
                $termino_nomina=date('Y-m-d', $fechas['f2']);
            } 

            $sucursal = $usuario->admin ? ($this->request->getQuery('sucursal') ?? '0') : $usuario->sucursal->id; 

            $sucursal_capturada=$this->getnomina($sucursal,$inicio_nomina);  

            if($sucursal_capturada->isEmpty())
            {
                foreach($sucursal_operaciones as $so):
                    $comision=$so->comision;
                    $bono=$so->bono;
                    $bono_empleado=$so->cantidad_bono;
                    $comision_empleados=$so->comision_empleados;
                    $porcentaje_comision_empleados=$so->porcentaje_comision_empleados;
                    $minimo_venta=$so->minimo_venta;
                    $cantidad_minima_venta=$so->cantidad_minima_venta;
                    $sistema_id=$so->sistema_id;
                    $horas_sucursal=$so->horas;
                endforeach;

                $conn = ConnectionManager::get('checador');
                $query = $conn->execute('SELECT *,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) AS horas_totales FROM checadas  where fecha between "'.$inicio_nomina.'" and "'.$termino_nomina.'" and sucursal= "'.$sucursal.'"  group by(empleados_id)');
                $horast = $query ->fetchAll('assoc');

                if($horast!="")
                {
                    $registros=[];
                    foreach($horast as $ht)
                    {
                        $nombre=$this->Empleados->get($ht["empleados_id"]);
                        $registros[$ht["empleados_id"]]["hrs"]=$ht;
                        $registros[$ht["empleados_id"]]["empleado"]=$nombre;
                    }

                    $save = $this->VentasSucursales->newEntity();
                    $save->venta=$this->ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id);
                    $this->VentasSucursales->save($save);

                    $venta_id=$this->idventa();
                    $ventasemanal=$this->ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id);
        
                    foreach($registros as $id=>$reg):
                        $save = $this->NominaEmpleadas->newEntity();

                        $horastotales=$this->gethorasoperacion($reg["hrs"]["horas_totales"]);

                        $sueldo=round($reg["empleado"]->sueldo/$horas_sucursal*($horastotales));

                        if($comision==true)
                        {
                            if($minimo_venta==true)
                            { 
                                if($ventasemanal<$cantidad_minima_venta)
                                {
                                    $ventasemanal=$cantidad_minima_venta; 
                                } 
                            }
                            $comision=round(($ventasemanal*$reg["empleado"]->porcentaje_comision)/48*($horastotales));
                        }

                        if($bono==true)
                        {
                            $bono_empleado=$bono_empleado;
                        }
                        else
                        {
                            $bono_empleado=0;
                        }

                        if($comision_empleados==true)
                        { 
                            $comision_empleados_venta=round($ventasemanal*$porcentaje_comision_empleados);

                            $suma_sueldos=0;
                            foreach($registros as $id=>$registro):
                                $suma_sueldos+=round($registro["empleado"]->sueldo/48*($hrstotales)); 
                            endforeach;

                            $comision=round(($sueldo/$suma_sueldos)*$comision_empleados_venta);
                        }

                        if($reg["empleado"]->joyeria==true)
                        {
                            $pago_joyeria=$this->getpagojoyeria($reg["empleado"]->empleado_id,$inicio_nomina,$termino_nomina);
                        }

                        $sueldo_final=$sueldo+$comision+$bono-$reg["empleado"]->infonavit-$pago_joyeria;
                        $save->fecha=$fecha;
                        $save->fecha_inicio=$inicio_nomina;
                        $save->fecha_fin=$termino_nomina;
                        $save->sueldo=$sueldo;
                        $save->comision=$comision;
                        $save->bono=$bono_empleado;
                        $save->empleados_id=$reg["empleado"]->id;
                        $save->sucursal_id=$reg["empleado"]->sucursal_id;
                        $save->horas=$horastotales;
                        $save->infonavit=$reg["empleado"]->infonavit;
                        $save->joyeria=$pago_joyeria;
                        $save->sueldo_final=$sueldo_final;
                        $save->venta_id=$venta_id; //Log::write("debug",$horas); //Log::write("debug",$inicio_nomina); Log::write("debug",$termino_nomina);
                        $this->NominaEmpleadas->save($save); 
                    endforeach; 
                } 
            }
        }
        $sucursal_capturada=$this->getnomina($sucursal,$inicio_nomina); 
        $this->set(compact('sucursales','suc','sucursal','registros','venta_semanal','sucursal_capturada','inicio_nomina','filtro','sucursal_nombre'));
    }

    public function editar() {

        $venta=0;
    	$sucursal = $this->request->getQuery('sucursal');
        $inicio_nomina = $this->request->getQuery('inicio');
        $sucursal_capturada=$this->getnomina($sucursal,$inicio_nomina);
        foreach($sucursal_capturada as $suc)
        {
            $venta_sucursal=$this->VentasSucursales->find()
            ->select(['venta_sucursal'=>'venta'])
            ->where(['id'=>$suc->venta_id])
            ->toArray(); 
        }
        foreach($venta_sucursal as $vta)
        {
            $venta=$vta->venta_sucursal; 
        }

        $this->set(compact('sucursal_capturada','sucursal','venta'));
    }

    public function actualizar() {

        $sucursal = $this->request->getQuery('sucursal');
        $empleados = $this->request->getData('empleados');
        $this->calcular($sucursal,$empleados);

        $this->redirect(['action' => 'nominas', 'sucursal' => $sucursal]);
    }

    private function getNomina($sucursal,$fecha_inicio) {
        $sucursal_capturada=$this->NominaEmpleadas->find() 
            ->contain('Empleados')
            ->where(["nominaempleadas.sucursal_id"=>$sucursal,"date(nominaempleadas.fecha_inicio)"=>$fecha_inicio])
            ->order("empleados.nombre");
        return $sucursal_capturada;
    }

    private function getPagoJoyeria($id,$inicio_nomina,$termino_nomina) {
        $pago_joyeria=0;
        $joyeria=$this->Transacciones->find()
        ->where(["convert(date,fecha) between '". $inicio_nomina ."' and '". $termino_nomina ."' and cliente_id='".$id."' and sucursal_id='0'"])
        ->toArray();

        foreach($joyeria as $joy):
            $pago_joyeria=$joy->pago;
        endforeach;

        return $pago_joyeria;
    }

    private function ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id){
        $venta_semanal=$this->Transacciones->find()
        ->select(['vta'=>'sum(pago)'])
        ->where(["Convert(date,fecha) between '". $inicio_nomina ."' and '". $termino_nomina ."' and sucursal_id= '".$sistema_id."'"])
        ->toArray();

        foreach($venta_semanal as $venta):
            $vta_semanal=$venta->vta;
        endforeach; 

        return $vta_semanal;
    }

    private function idventa(){
        $venta_id=$this->VentasSucursales->find()
        ->order('id desc')
        ->first()
        ->toArray();

        return $venta_id["id"];
    }

    private function calcular($sucursal,$empleados){ 

        $sucursal_operaciones=$this->Sucursales->find()
        ->where(['id'=>$sucursal]);

        foreach($sucursal_operaciones as $so):
            $comision=$so->comision;
            $bono=$so->bono;
            $bono_empleado=$so->cantidad_bono;
            $comision_empleados=$so->comision_empleados;
            $porcentaje_comision_empleados=$so->porcentaje_comision_empleados;
            $minimo_venta=$so->minimo_venta;
            $cantidad_minima_venta=$so->cantidad_minima_venta;
            $sistema_id=$so->sistema_id;
        endforeach;

        foreach($empleados as $id=>$empleado): 

            $inicio_nomina=date("Y-m-d",strtotime($empleado["fecha_inicio"]));
            $termino_nomina=date("Y-m-d",strtotime($empleado["fecha_fin"]));

            $ventasemanal=$empleado["venta_sucursal"];

            $nomina=$this->NominaEmpleadas->get($id);

            $info_empleado=$this->Empleados->find()
            ->where(["id"=>$empleado["id"]])
            ->toArray();

            foreach($info_empleado as $info): 

                $hrstotales=$this->gethorasoperacion($empleado["horas"]); 

                $sueldo=round($info["sueldo"]/48 *($hrstotales));  /////AGREGAR LA SUMA DE LOS HORARIOS DE CADA EMPLEADO

                if($comision==true)
                {
                    if($minimo_venta==true)
                    { 
                        if($ventasemanal<$cantidad_minima_venta)
                        {
                            $ventasemanal=$cantidad_minima_venta;
                        }
                    }
                    $comision=round(($ventasemanal*$info["porcentaje_comision"])/48*($hrstotales));
                }

                if($bono==true)
                {
                    $bono=$bono_empleado;
                }

                if($comision_empleados==true)
                {
                    $ventasemanal=$this->ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id);
                    $comision_empleados_venta=round($ventasemanal*$porcentaje_comision_empleados);

                    $suma_sueldos=0;
                    foreach($empleados as $id=>$emp):
                        $hrstotales=$emp["horas"];

                        $suma_sueldos+=round($info->sueldo/48*($hrstotales));
                    endforeach;

                    $comision=round(($sueldo/$suma_sueldos)*$comision_empleados_venta);
                }

                $sueldo_final=$sueldo+$comision+$bono-$nomina->joyeria-$nomina->infonavit-$empleado["deduccion"]+$empleado["extra"];

                $nomina->sueldo=$sueldo;
                $nomina->horas=$hrstotales;
                $nomina->deduccion=$empleado["deduccion"];
                $nomina->extra=$empleado["extra"];
                $nomina->comision=$comision;
                $nomina->sueldo_final=$sueldo_final;

                $this->NominaEmpleadas->save($nomina);
            endforeach;
        endforeach;
    }

    function getHorasOperacion($horas){

    $separar[1]=explode(':',$horas);
    $hrstotales=$separar[1][0]+($separar[1][1]/60);

    return $hrstotales;
    }
}