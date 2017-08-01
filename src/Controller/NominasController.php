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
         $venta_sucursal=$this->request->getQuery('venta_sucursal');

         $filtro = $this->request->getQuery('filtro') ?? 'semanal';
         $fechas = $this->setFechasReporte();

         $enviado = $this->request->getQuery('enviado') ?? false;

        $sucursal_operaciones=$this->Sucursales->find()
        ->where(['id'=>$sucursal]);

        foreach($sucursal_operaciones as $so)
        {
            $sucursal_nombre=$so->nombre;
        }

         if ($enviado!==false) {
            if ($filtro == "rango") {
                $inicio_nomina=date('Y-m-d', $fechas['f1']);
                $termino_nomina=date('Y-m-d', strtotime($inicio_nomina. ' + 6 days' ));
            } 

            $sucursal = $usuario->admin ? ($this->request->getQuery('sucursal') ?? '0') : $usuario->sucursal->id; 

            $sucursal_capturada=$this->nomina($sucursal,$inicio_nomina); 

            foreach($sucursal_operaciones as $so)
            {
                $comision_sucursal=$so->comision;
                $bono_empleado=$so->bono;
                $bono_empleado=$so->cantidad_bono;
                $comision_empleados=$so->comision_empleados;
                $porcentaje_comision_empleados=$so->porcentaje_comision_empleados;
                $minimo_venta=$so->minimo_venta;
                $cantidad_minima_venta=$so->cantidad_minima_venta;
                $sistema_id=$so->sistema_id;
                $horas_sucursal=$so->horas;
            }

            $venta_sucursal=$this->ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id);

            if($sucursal_capturada->isEmpty())
            {
                $info_checadas=$this->infochecada($inicio_nomina,$termino_nomina,$sucursal);
                if($info_checadas!="")
                {
                    $registros=[];
                    foreach($info_checadas as $ht)
                    {
                        $nombre=$this->Empleados->get($ht["empleados_id"]);
                        $registros[$ht["empleados_id"]]["hrs"]=$ht;
                        $registros[$ht["empleados_id"]]["empleado"]=$nombre;
                    }

                    $save = $this->VentasSucursales->newEntity();
                    $save->venta=$this->ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id);
                    $this->VentasSucursales->save($save);

                    $venta_id=$this->idventa();
                    $venta_sucursal=$this->ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id);
        
                    foreach($registros as $id=>$reg)
                    {
                        $comision=0;
                        $pago_joyeria=0;
                        $extra=0;

                        $hrs_semana=$reg["hrs"]["hrs_semana"];
                        $save = $this->NominaEmpleadas->newEntity();

                        $horastotales=$reg["hrs"]["horas_totales"];

                        $horas_trabajadas=$this->hrstrabajadas($hrs_semana,$horastotales,$reg["empleado"]["pago_diario"]);

                        $sueldo=$this->sueldo($horas_trabajadas,$hrs_semana,$reg["empleado"]["pago_diario"],$reg["empleado"]["pago_diario_cantidad"],$reg["empleado"]->sueldo,$inicio_nomina,$termino_nomina,$reg["empleado"]->id);

                        if($comision_sucursal==true)
                        {
                            if($minimo_venta==true)
                            { 
                                if($venta_sucursal<$cantidad_minima_venta)
                                {
                                    $venta_sucursal=$cantidad_minima_venta; 
                                } 
                            }
                            $comision=round(($venta_sucursal*$reg["empleado"]->porcentaje_comision)/48*($horas_trabajadas));
                        }

                        if($bono_empleado==true)
                        {
                            $bono=round($bono_empleado/$hrs_semana*($horas_trabajadas)); 
                        }
                        else
                        {
                            $bono=0;
                        }

                        if($comision_empleados==true)
                        { 
                            $comision=$this->comision($venta_sucursal,$porcentaje_comision_empleados,$registros,$sueldo,$horas_trabajadas);
                        }

                        if($reg["empleado"]->joyeria==true)
                        {
                            $pago_joyeria=$this->PagoJoyeria($reg["empleado"]->empleado_id);
                        }

                        if(!$reg["empleado"]["pago_diario"])
                        {
                            if($horas_trabajadas>48)
                            {
                                $cantidad_horaextra=($reg["empleado"]->sueldo/48)*2;
                                $extra=round(($horas_trabajadas-48)*$cantidad_horaextra);
                            }
                        }
                        
                        $sueldo_final=round($sueldo+$comision+$bono-$reg["empleado"]->infonavit-$pago_joyeria+$extra);

                        $save->fecha=$fecha;
                        $save->fecha_inicio=$inicio_nomina;
                        $save->fecha_fin=$termino_nomina;
                        $save->sueldo=$sueldo;
                        $save->comision=$comision;
                        $save->bono=$bono;
                        $save->pago_extras=$extra;
                        $save->empleados_id=$reg["empleado"]->id;
                        $save->sucursal_id=$sucursal;
                        $save->horas=$horas_trabajadas;
                        $save->infonavit=$reg["empleado"]->infonavit;
                        $save->joyeria=$pago_joyeria;
                        $save->sueldo_final=$sueldo_final;
                        $save->venta_id=$venta_id;
                        $this->NominaEmpleadas->save($save); 
                    } 
                } 
            }
        }
        
        $sucursal_capturada=$this->nomina($sucursal,$inicio_nomina); 
        $this->set(compact('sucursales','suc','sucursal','registros','venta_sucursal','sucursal_capturada','inicio_nomina','termino_nomina','filtro','sucursal_nombre'));
    }

    private function calcular($sucursal,$empleados){ 

        $sucursal_operaciones=$this->Sucursales->find()
        ->where(['id'=>$sucursal]);

        foreach($sucursal_operaciones as $so)
        {
            $sucursal=$so->id;
            $comision_sucursal=$so->comision;
            $bono_empleado=$so->bono;
            $bono_empleado=$so->cantidad_bono;
            $comision_empleados=$so->comision_empleados;
            $porcentaje_comision_empleados=$so->porcentaje_comision_empleados;
            $minimo_venta=$so->minimo_venta;
            $cantidad_minima_venta=$so->cantidad_minima_venta;
            $sistema_id=$so->sistema_id;
        }

        foreach($empleados as $id=>$empleado)
        {
            $inicio_nomina=date("Y-m-d",strtotime($empleado["fecha_inicio"]));
            $termino_nomina=date("Y-m-d",strtotime($empleado["fecha_fin"]));

            $ventasemanal=$empleado["venta_sucursal"];

            $nomina=$this->NominaEmpleadas->get($id);

            $info_empleado=$this->Empleados->find()
            ->where(["id"=>$empleado["id"]])
            ->toArray();

            foreach($info_empleado as $info)
            {
                $pago_joyeria=0;
                $comision=0;
                $bono=0;
                $pago_extras=0;

                $info_checadas=$this->infochecada($inicio_nomina,$termino_nomina,$sucursal); 

                foreach ($info_checadas as $info_ch) 
                { 
                    $nombre=$this->Empleados->get($info_ch["empleados_id"]);
                    $registros[$info_ch["empleados_id"]]["hrs"]=$info_ch;
                    $registros[$info_ch["empleados_id"]]["empleado"]=$nombre;
                }

                foreach($registros as $reg)
                {
                    $hrs_semana=$reg["hrs"]["hrs_semana"];
                    $pago_diario=$reg["empleado"]["pago_diario"];
                    $pago_diario_cantidad=$reg["empleado"]["pago_diario_cantidad"];
                    $sueldo=$reg["empleado"]["sueldo"];
                    $empleado_id=$reg["empleado"]["id"];
                }

                $horas_trabajadas=$this->HorasOperacion($empleado["horas"]);

                $sueldo=$this->sueldo($horas_trabajadas,$hrs_semana,$pago_diario,$pago_diario_cantidad,$sueldo,$inicio_nomina,$termino_nomina,$empleado_id); 

                if($comision_sucursal==true)
                {
                    if($minimo_venta==true)
                    { 
                        if($ventasemanal<$cantidad_minima_venta)
                        {
                            $ventasemanal=$cantidad_minima_venta;
                        }
                    } 

                    $comision=round(($ventasemanal*$info["porcentaje_comision"])/48*($horas_trabajadas));
                }

                if($bono_empleado==true)
                {
                    $bono=round($bono_empleado/48*($horas_trabajadas));
                } 

                if($comision_empleados==true)
                {
                    $comision=$this->comision($ventasemanal,$porcentaje_comision_empleados,$registros,$sueldo);
                }

                if($info["joyeria"]==true) 
                {
                    if($empleado["joyeria"]==0)
                    {
                        $pago_joyeria=$this->PagoJoyeria($info["empleado_id"]);
                    }
                    else
                    {
                        $pago_joyeria=$empleado["joyeria"];
                    }
                }

                if(!$pago_diario)
                {
                    if($horas_trabajadas>48)
                    {
                        $cantidad_horaextra=($reg["empleado"]->sueldo/48)*2;
                        $pago_extras+=round(($horas_trabajadas-48)*$cantidad_horaextra);
                    }
                }

                $sueldo_final=round((float)$sueldo+(float)$comision+(float)$bono-(float)$pago_joyeria-(float)$info["infonavit"]-(float)$empleado["deduccion"]-$empleado["isr"]-$empleado["prestamo"]+(float)$empleado["extra"]+$pago_extras);

                $nomina->sueldo=$sueldo;
                $nomina->horas=$horas_trabajadas;
                $nomina->deduccion=$empleado["deduccion"];
                $nomina->isr=$empleado["isr"];
                $nomina->prestamo=$empleado["prestamo"];
                $nomina->extra=$empleado["extra"];
                $nomina->pago_extras=$pago_extras;
                $nomina->comision=$comision;
                $nomina->joyeria=$pago_joyeria;
                $nomina->bono=$bono;
                $nomina->infonavit=$info["infonavit"];
                $nomina->sueldo_final=$sueldo_final;

                $this->NominaEmpleadas->save($nomina);
            }
        }
    }

    public function editar() {

        $venta=0;
        $sucursal = $this->request->getQuery('sucursal');
        $inicio_nomina = $this->request->getQuery('inicio');
        $sucursal_capturada=$this->nomina($sucursal,$inicio_nomina);
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
        $venta_sucursal = $this->request->getQuery('venta_sucursal');
        $this->calcular($sucursal,$empleados);

        $this->redirect(['action' => 'nominas', 'sucursal' => $sucursal,'venta_sucursal'=>$venta_sucursal]);
    }

    private function Nomina($sucursal,$fecha_inicio) {
        $sucursal_capturada=$this->NominaEmpleadas->find() 
            ->contain('Empleados')
            ->where(["nominaempleadas.sucursal_id"=>$sucursal,"date(nominaempleadas.fecha_inicio)"=>$fecha_inicio])
            ->order("empleados.nombre");
        return $sucursal_capturada;
    }

    public function PagoJoyeria($id) { 

        $inicio_semana_actual=date("Y-m-d",strtotime('monday this week'));
        $termino_semana_actual=date("Y-m-d",strtotime('sunday this week'));
        $pago_joyeria=0;

        $joyeria=$this->Transacciones->find()
        ->where(["convert(date,fecha) between '". $inicio_semana_actual ."' and '". $termino_semana_actual ."' and cliente_id='".$id."' and sucursal_id='0'"])
        ->toArray();

        foreach($joyeria as $joy)
        {
            $pago_joyeria=$joy->pago;
        }

        return $pago_joyeria;
    }

    private function ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id){
        $venta_semanal=$this->Transacciones->find()
        ->select(['vta'=>'sum(pago)'])
        ->where(["Convert(date,fecha) between '". $inicio_nomina ."' and '". $termino_nomina ."' and sucursal_id= '".$sistema_id."'"])
        ->toArray();

        foreach($venta_semanal as $venta)
        {
            $vta_semanal=$venta->vta;
        }

        return $vta_semanal;
    }

    private function idventa(){
        $venta_id=$this->VentasSucursales->find()
        ->order('id desc')
        ->first()
        ->toArray();

        return $venta_id["id"];
    }

    function sueldo($horas_trabajadas,$hrs_semana,$pago_diario,$pago_diario_cantidad,$sueldo_base,$inicio_nomina,$termino_nomina,$empleado_id){

        $sueldo=0;
        if($pago_diario)
        {
            $checadas=$this->Checadas->find()
            ->where(["fecha between '".$inicio_nomina."' and '".$termino_nomina."' and empleados_id='".$empleado_id."'"])
            ->toArray();
            
            foreach($checadas as $checada)
            {
                $sueldo+=round(($pago_diario_cantidad*$checada->horas)/$checada->hrs_dia);
            }
        }
        else
        {
            if($horas_trabajadas>48)
            {
                $horas_trabajadas=48;
            }

            $sueldo=round($sueldo_base/48*($horas_trabajadas));
        }

        return $sueldo;
    }

    function hrstrabajadas($hrs_semanales,$hrs_trabajadas,$pago_diario){

        if($pago_diario)
        {
            $hrs=$hrs_trabajadas;
        }
        else
        {
            $hrs=$hrs_semanales-$hrs_trabajadas;
            $hrs=48-$hrs;
        }

        return $hrs;
    }

    function HorasOperacion($horas){ 

        $separar[1]=explode(':',$horas);
        $hrstotales=$separar[1][0]+($separar[1][1]/60);

        return $hrstotales;
    }

    function infochecada($inicio_nomina,$termino_nomina,$sucursal){

        $conn = ConnectionManager::get('checador');
                $query = $conn->execute('SELECT id,empleados_id,SUM(horas) AS horas_totales,sum(hrs_dia) as hrs_semana FROM checadas  where fecha between "'.$inicio_nomina.'" and "'.$termino_nomina.'" and sucursal= "'.$sucursal.'"  group by(empleados_id)');
                $horast = $query ->fetchAll('assoc');

        return $horast;
    }

    function comision($ventasemanal,$porcentaje_comision_empleados,$registros,$sueldo,$horas_trabajadas){
        $comision_empleados_venta=round($ventasemanal*$porcentaje_comision_empleados);

        $suma_sueldos=0;
        foreach($registros as $id=>$registro)
        {
            $hrstotales_empleado=$this->horasoperacion($registro["hrs"]["horas_totales"]); 
            $suma_sueldos+=round($registro["empleado"]["sueldo"]/48*($horas_trabajadas));
        }  

        $comision=round(($sueldo/$suma_sueldos)*$comision_empleados_venta);

        return $comision;
    }
}