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

    	$suc='';
        $sucursales=$this->Sucursales->find()
        ->where(['generar_nomina'=>true])
        ->order('nombre');

        $sucursal=$this->request->getQuery('sucursal');
        
        if($sucursal!='')
        {
            $sucursal_info=$this->Sucursales->get($sucursal);
        }

        $venta_semanal=$this->request->getQuery('venta_sucursal');

        $enviado = $this->request->getQuery('enviado') ?? false;

        if ($enviado!==false) {

            $sucursal = $usuario->admin ? ($this->request->getQuery('sucursal') ?? '0') : $usuario->sucursal->id;

            $sucursal_capturada=$this->nomina($sucursal,$inicio_nomina);

            $venta_semanal=$this->ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sucursal_info->sistema_id);

            if($sucursal_capturada->isEmpty())
            {
                if($sucursal!=12)
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
                        $venta_semanal=$this->ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sucursal_info->sistema_id);
                        $save->venta=$venta_semanal;
                        $this->VentasSucursales->save($save);

                        $venta_id=$this->IdVenta();
            
                        foreach($registros as $id=>$reg)
                        {
                            $comision=0;
                            $pago_joyeria=0;
                            $extra=0;

                            $nomina = $this->NominaEmpleadas->newEntity();

                            $horas_trabajadas=$reg["hrs"]["hrs_finales"];

                            $horas_trabajadas_tope=($horas_trabajadas>48)? 48 : $horas_trabajadas;

                            $sueldo=$this->sueldo($horas_trabajadas_tope,$reg["empleado"]->sueldo,$reg["empleado"]->id);

                            $comision=$this->Comision($sucursal_info,$venta_semanal,$horas_trabajadas_tope,$reg["empleado"]->porcentaje_comision);
                            $bono=$this->Bono($horas_trabajadas_tope,$reg["empleado"]);
                            $pago_joyeria=$this->PagoJoyeria($reg["empleado"]->joyeria,$reg["empleado"]->empleado_id);
                            $prestamo=$this->Prestamo($reg["empleado"]->prestamo,$reg["empleado"]->empleado_id);
                            $horas_extras=$this->HorasExtras($horas_trabajadas,$reg["empleado"]->sueldo);


                           if($sucursal_info->comision_empleados==true)
                            { 
                                $comision_empleados_venta=round($venta_semanal*$sucursal_info->porcentaje_comision_empleados);

                                $suma_sueldos=0;

                                foreach($registros as $registro)
                                {
                                    $horas=48-($registro["hrs"]["hrs_semana"]-$registro["hrs"]["horas_totales"]);

                                    $suma_sueldos+=round($registro["empleado"]["sueldo"]/48*($horas));
                                }  

                                $comision=round(($sueldo/$suma_sueldos)*$comision_empleados_venta);
                            }
                            
                            $sueldo_final=round($sueldo+$comision+$bono-$reg["empleado"]->infonavit-$pago_joyeria+$horas_extras-$prestamo);

                            $nomina->fecha=$fecha;
                            $nomina->fecha_inicio=$inicio_nomina;
                            $nomina->fecha_fin=$termino_nomina;
                            $nomina->sueldo=$sueldo;
                            $nomina->comision=$comision;
                            $nomina->bono=$bono;
                            $nomina->pago_extras=$horas_extras;
                            $nomina->empleados_id=$reg["empleado"]->id;
                            $nomina->sucursal_id=$sucursal;
                            $nomina->horas=$horas_trabajadas;
                            $nomina->infonavit=$reg["empleado"]->infonavit;
                            $nomina->joyeria=$pago_joyeria;
                            $nomina->prestamo=$prestamo;
                            $nomina->sueldo_final=$sueldo_final;
                            $nomina->venta_id=$venta_id;
                            $this->NominaEmpleadas->save($nomina); 
                        }
                    }
                }
                else
                {
                    $empleados=$this->Empleados->find()
                    ->where(['sucursal_id'=>$sucursal])
                    ->toArray();

                    foreach($empleados as $emp)
                    {
                        $nomina = $this->NominaEmpleadas->newEntity();
                        $nomina->fecha=$fecha;
                        $nomina->empleados_id=$emp->id;
                        $nomina->fecha_inicio=$inicio_nomina;
                        $nomina->fecha_fin=$termino_nomina;
                        $nomina->sueldo=$emp->sueldo;
                        $nomina->sucursal_id=$sucursal;
                        $this->NominaEmpleadas->save($nomina);
                    }

                }
            }
        }

        $sucursal_capturada=$this->nomina($sucursal,$inicio_nomina);

        $this->set(compact('sucursales','suc','sucursal','registros','venta_semanal','sucursal_capturada','inicio_nomina','termino_nomina','sucursal_info'));
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

    public function eliminar(){

        $id=$this->request->getParam('id');
        $venta = $this->request->getQuery('venta');

        $registro=$this->NominaEmpleadas->get($id);

        $this->NominaEmpleadas->delete($registro);

        $this->redirect(['action' => 'nominas', 'sucursal' => $registro->sucursal_id,'venta_sucursal'=>$venta]);
    }

    private function calcular($sucursal,$empleados){

        $sucursal_info=$this->Sucursales->get($sucursal);

        foreach($empleados as $id=>$empleado)
        {
            $venta_semanal=$empleado["venta_sucursal"];

            $horas_trabajadas=$this->HorasOperacion($empleado["horas"]);

            $horas_trabajadas_tope=($horas_trabajadas>48)? 48 : $horas_trabajadas;

            $nomina=$this->NominaEmpleadas->get($id);

            $info_empleado=$this->Empleados->get($empleado["id"]);
            $sueldo=round($info_empleado->sueldo/48*($horas_trabajadas_tope));

            $comision=$this->Comision($sucursal_info,$venta_semanal,$horas_trabajadas_tope,$info_empleado->porcentaje_comision);
            $bono=$this->Bono($horas_trabajadas_tope,$info_empleado);
            $pago_joyeria=$this->PagoJoyeria($info_empleado->joyeria,$info_empleado->empleado_id);
            $prestamo=$this->Prestamo($info_empleado->prestamo,$info_empleado->empleado_id);
            $horas_extras=$this->HorasExtras($horas_trabajadas,$info_empleado->sueldo);

            if($sucursal_info->comision_empleados==true)
            { 
                $comision_empleados_venta=round($venta_semanal*$sucursal_info->porcentaje_comision_empleados);

                $suma_sueldos=0;

                foreach($empleados as $hrs)
                {
                    $horas=($hrs["horas"]>48)? 48 : $this->HorasOperacion($hrs["horas"]);
                    $suma_sueldos+=round($hrs["sueldo"]/48*($horas)); 
                }  

                $comision=round(($sueldo/$suma_sueldos)*$comision_empleados_venta);
            }

            $sueldo_final=round($sueldo+$comision+$bono-$empleado["infonavit"]-$pago_joyeria+$horas_extras-$empleado["deduccion"]-$empleado["isr"]-$prestamo+$empleado["extra"]);

            
            $nomina->sueldo=$sueldo;
            $nomina->comision=$comision;
            $nomina->bono=$bono;
            $nomina->pago_extras=$horas_extras;
            $nomina->horas=$horas_trabajadas;
            $nomina->infonavit=$empleado["infonavit"];
            $nomina->joyeria=$pago_joyeria;
            $nomina->sueldo_final=$sueldo_final;
            $nomina->prestamo=$prestamo;
            $nomina->extra=$empleado["extra"];
            $nomina->isr=$empleado["isr"];
            $nomina->deduccion=$empleado["deduccion"];

            $this->NominaEmpleadas->save($nomina); 
        } 
    }

    private function Comision($sucursal_info,$venta_semanal,$horas_trabajadas,$porcentaje_comision){

        $comision=0;
        
        if($sucursal_info->comision==true)
        { 
            if($sucursal_info->minimo_venta==true)
            {
                if($venta_semanal<$sucursal_info->cantidad_minima_venta)
                { 
                    $venta_semanal=$sucursal_info->cantidad_minima_venta;
                } 
            }

            if($horas_trabajadas>48)
            {
                $horas_trabajadas=48;
            }

            $comision=round(($venta_semanal*$porcentaje_comision)/48*($horas_trabajadas));
        }

        return $comision;
    }

    private function Bono($horas_trabajadas,$info_empleado){

        $bono=0;

        $bono=$info_empleado->bono/48*($horas_trabajadas);
        
        return $bono; 
    }

    private function HorasExtras($horas_trabajadas,$sueldo){

        $horas_extras=0;

        if($horas_trabajadas>48)
        {
            $cantidad_horaextra=($sueldo/48)*2;
            $horas_extras=round(($horas_trabajadas-48)*$cantidad_horaextra);
        }

        return $horas_extras;
    }

    private function Nomina($sucursal,$fecha_inicio) {
        $sucursal_capturada=$this->NominaEmpleadas->find() 
            ->contain('Empleados')
            ->where(["nominaempleadas.sucursal_id"=>$sucursal,"date(nominaempleadas.fecha_inicio)"=>$fecha_inicio])
            ->order("empleados.nombre");
        return $sucursal_capturada;
    }

    public function PagoJoyeria($joyeria,$id) { 

        $pago_joyeria=0;

        if($joyeria)
        {
            $inicio_semana_actual=date("Y-m-d",strtotime('monday this week'));
            $termino_semana_actual=date("Y-m-d",strtotime('sunday this week'));

            $joyerias=$this->Transacciones->find()
            ->where(["convert(date,fecha) between '". $inicio_semana_actual ."' and '". $termino_semana_actual ."' and cliente_id='".$id."' and sucursal_id='0' and sistema_id <>'14'"])
            ->toArray();

            if($joyerias!=[])
            {
                foreach($joyerias as $j)
                {
                    $pago_joyeria+=$j->pago;
                }
            }
        }

        return $pago_joyeria;
    }

    public function Prestamo($prestamo,$id) {

        $pago_prestamo=0;

        if($prestamo)
        {
            $inicio_semana_actual=date("Y-m-d",strtotime('monday this week'));
            $termino_semana_actual=date("Y-m-d",strtotime('sunday this week'));

            $prestamos=$this->Transacciones->find()
            ->where(["convert(date,fecha) between '". $inicio_semana_actual ."' and '". $termino_semana_actual ."' and cliente_id='".$id."' and sucursal_id='0' and sistema_id='14'"])
            ->toArray();

            if($prestamos!=[])
            {
                foreach($prestamos as $p)
                {
                    $pago_prestamo+=$p->pago;
                }
            }
        }

        return $pago_prestamo;
    }

    private function ventasemanal($sucursal,$inicio_nomina,$termino_nomina,$sistema_id){

        $venta_semanal=$this->Transacciones->find()
        ->select(['vta'=>'sum(pago)'])
        ->where(["Convert(date,fecha) between '". $inicio_nomina ."' and '". $termino_nomina ."' and sucursal_id= '".$sistema_id."'"])
        ->first(); 

        $venta_semanal=round($venta_semanal->vta);

        return $venta_semanal;
    }

    private function IdVenta(){

        $venta_id=$this->VentasSucursales->find()
        ->order('id desc')
        ->first();

        return $venta_id->id;
    }

    function sueldo($horas_trabajadas,$sueldo_base,$empleado_id){

        $sueldo=0;
        
        if($horas_trabajadas>48)
        {
            $horas_trabajadas=48;
        }

        $sueldo=round($sueldo_base/48*($horas_trabajadas));

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
        $horas=$separar[1][0]+($separar[1][1]/60);

        return $horas;
    }

    function infochecada($inicio_nomina,$termino_nomina,$sucursal){

        $conn = ConnectionManager::get('checador');

        $query = $conn->execute('SELECT id,empleados_id,SUM(horas) AS horas_totales,sum(hrs_dia) as hrs_semana,sum(hrs_finales) as hrs_finales,sum(hrs_nomina) as hrs_nomina FROM checadas  where fecha between "'.$inicio_nomina.'" and "'.$termino_nomina.'" and sucursal= "'.$sucursal.'"  group by(empleados_id)');
        $horast = $query ->fetchAll('assoc');
        
        return $horast;
    }
}