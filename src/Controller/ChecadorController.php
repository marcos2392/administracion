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
        $this->loadModel('HorasChecadas');
        $this->loadModel('HorariosNomina');
    }

    public function reporte() {

        $usuario = $this->getUsuario();

        $menu = $this->request->getQuery('menu')?? 'menu_checador';

        $sucursales = $this->Sucursales->find()
            ->where(['id != 0'])
            ->order(['nombre']);

        $sucursal = $usuario->admin || $usuario->checador ? ($this->request->getQuery('sucursal') ?? '0') : $usuario->sucursal_id;

        if($sucursal!=0)
        {
            $sucursal_nombre =  $this->Sucursales->get($sucursal)->nombre;
        }

        $filtro = $this->request->getQuery('filtro') ?? 'semanal';
        $fechas = $this->setFechasReporte();

        if ($filtro == "semanal") {
            $inicio = date("Y-m-d", strtotime('monday this week -7 days'));
            $fin = date("Y-m-d", strtotime('sunday this week - 7 days'));

            $condicion = ["sucursal_id= '". $sucursal ."' and fecha between '" . $inicio . "' and '" . $fin . "'"];
        }

        if ($filtro == "actual") {
            $filtro=$filtro;
            $inicio = date("Y-m-d", strtotime('monday this week'));
            $fin = date("Y-m-d", strtotime('sunday this week'));

            $condicion = ["sucursal_id= '". $sucursal ."' and fecha between '" . $inicio . "' and '" . $fin . "'"];
        } 

        if ($filtro == "rango") 
        {
            $inicio = date('Y-m-d', $fechas['f1']); 
            $fin = date('Y-m-d', $fechas['f2']); 
            $condicion = ["sucursal_id= '".$sucursal."' and fecha between '" . $inicio . "' and '" . $fin . "'"];
        }

        if ($this->request->is('get')) {

            if($sucursal!=0)
            {
               $registros=$this->Checadas->find()
                ->where($condicion)
                ->order('empleados_id, fecha,checadas.entrada');

                $registro=$this->checadas($registros,$inicio,$fin); 

                $horas_editables=$this->HorasChecadas->find()
                ->where(['sucursal_id'=>$sucursal,'fecha_inicio'=>$inicio,'fecha_termino'=>$fin])
                ->toArray();
            }
            
        }

        $this->set(compact('inicio','fin','registro','filtro','sucursales','sucursal','sucursal_nombre','empleados','menu','horas_editables'));
    }

    public function editar() {

        $filtro=$this->request->getQuery('filtro');
        $sucursal=$this->request->getQuery('sucursal');
        $desde_fecha=$this->request->getQuery('inicio');
        $hasta_fecha=$this->request->getQuery('fin');
        

        $registros=$this->Checadas->find()
        ->where(['fecha between "'.$desde_fecha.'" and "'.$hasta_fecha.'" and sucursal_id="'.$sucursal.'"'])
        ->order('empleados_id, fecha,checadas.entrada');

        $registro=$this->checadas($registros,$desde_fecha,$hasta_fecha);

        $this->set(compact('registro','sucursal','desde_fecha','hasta_fecha','filtro'));
    }

    public function actualizar() {

        $filtro = $this->request->getQuery('filtro');
        $fecha_inicio=$this->request->getQuery('fecha_inicio');
        $fecha_termino=$this->request->getQuery('fecha_termino');
        $sucursal_id = $this->request->getQuery('sucursal');
        $empleados = $this->request->getData('empleados');
        $horas_finales_total=$this->request->getData('horas_finales_total');
        $fecha=date("Y-m-d");

        $sucursal_info=$this->Sucursales->get($sucursal_id);

        foreach($empleados as $id=>$emp)
        {
            $hrs_checadas_semanal=$this->checarRegistroHoras($id,$fecha_inicio,$fecha_termino,$sucursal_id);

            foreach($emp as $dia=>$e)
            { 
                foreach($e as $fecha_checada=>$horas)
                {
                    foreach($horas_finales_total as $id_emp=>$hft)
                    {
                        foreach($hft as $hrs_editadas)
                        {
                            if($id_emp==$id)
                            {
                                $horas_checadas=$this->HorasChecadas->find()
                                ->where(['empleado_id'=>$id,'fecha_inicio'=>$fecha_inicio])
                                ->first();

                                $horas_checadas->hrs_editadas=HoraDecimal($hrs_editadas);

                                $this->HorasChecadas->save($horas_checadas);
                            }
                        }
                    }
                    
                    $registro=$this->Checadas->find()
                    ->where(['fecha="'.$fecha_checada.'" and sucursal_id="'.$sucursal_id.'" and empleados_id="'.$id.'"'])
                    ->first();

                    $horas_checadas=$this->HorasChecadas->find()
                    ->where(['empleado_id'=>$id,'fecha_inicio'=>$fecha_inicio])
                    ->first();

                    if(!empty($registro))
                    {
                        $retardo=false;

                        if($horas["entrada"]!='' and $horas["salida"]=='')
                        {
                            if($registro->salida!=null)
                            {
                                if($registro->hrs_finales>0)
                                {
                                    $hrs_nvas=$horas_checadas->hrs_checadas-$registro->hrs_finales;
                                    $this->checadasSemanal($hrs_nvas,$horas_checadas);
                                }          
                            }

                            if($sucursal_info->horario_libre==false)
                            {
                                $entrada_horario=$sucursal_info->hora_entrada->format("H:i");
                                $salida_horario=$sucursal_info->hora_salida->format("H:i");

                                $retardo=$this->Retardo($retardo,$entrada_horario,$horas["entrada"]);

                                $entrada_nomina=$this->HoraRetardo($entrada_horario,$horas["entrada"],$registro->entrada_nomina->format("H:i"));

                                $registro->entrada=$horas["entrada"];
                                $registro->entrada_nomina=$entrada_nomina;
                                $registro->retardo=$retardo;
                            }
                            else
                            {
                                $registro->entrada=$horas["entrada"];
                            }

                            $registro->salida=null;
                            $registro->hrs_finales=0;
                            $registro->horas=null;         
                        }

                        if($horas["entrada"]=='' and $horas["salida"]=='')
                        {
                            $hrs_nuevas=$horas_checadas->hrs_checadas-$registro->hrs_finales;
                            $this->checadasSemanal($hrs_nuevas,$horas_checadas);

                            $this->Checadas->delete($registro);
                        }

                        if($horas["entrada"]!='' and $horas["salida"]!='')
                        {
                            $hrs_anteriores=$registro->hrs_finales;

                            $salida=FormatoHora($horas["salida"]);
                            $entrada=FormatoHora($horas["entrada"]);

                            if($sucursal_info->horario_libre==false)
                            {
                                $entrada_horario=$sucursal_info->hora_entrada->format("H:i");
                                $salida_horario=$sucursal_info->hora_salida->format("H:i");

                                $horarios_nomina=$this->HorariosNomina->find()
                                ->where(['entrada_real'=>$entrada_horario,'salida_real'=>$salida_horario])
                                ->first();

                                if($horarios_nomina!=null)
                                {  
                                    $entrada_nomina=$horarios_nomina->entrada_nomina->format("H:i");
                                    $salida_nomina=$horarios_nomina->salida_nomina->format("H:i");
                                }
                                else
                                {
                                    $entrada_nomina=$entrada_horario;
                                    $salida_nomina=$salida_horario;
                                }

                                $hrs_nomina=$this->Calcular($salida_nomina,$entrada_nomina);
                                $retardo=$this->Retardo($retardo,$entrada_horario,$entrada);
                                $entrada_nomina=$this->HoraRetardo($entrada_horario,$entrada,$entrada_nomina);

                                $hrs_dia= CalcularHoras($salida_horario,$entrada_horario);
                                $hrs_trabajadas= Calcular($salida,$entrada,$registro);

                                $hrs_finales=$hrs_nomina-($hrs_dia-$hrs_trabajadas);

                                $registro->hrs_nomina=$hrs_nomina;
                                $registro->entrada_horario=$entrada_horario;
                                $registro->salida_horario=$salida_horario;
                                $registro->entrada_nomina=$entrada_nomina;
                                $registro->salida_nomina=$salida_nomina;
                                $registro->retardo=$retardo;
                                $registro->hrs_finales=$hrs_finales;

                                $registro->hrs_dia=$hrs_dia;
                            }
                            else
                            {
                                $hrs_trabajadas= CalcularHoras($salida,$entrada);
                                $hrs_finales=$hrs_trabajadas;
                                $registro->hrs_finales=$hrs_finales;
                            }
        
                            $registro->entrada=$entrada;
                            $registro->salida=$salida;
                            $registro->horas=$hrs_trabajadas;
                            $horas_nvas=$horas_checadas->hrs_checadas-$hrs_anteriores+$hrs_finales;

                            $this->checadasSemanal($horas_nvas,$horas_checadas);
                        }

                        $this->Checadas->save($registro);
                        
                    }
                    else
                    {
                        if($horas["entrada"]!='')
                        {
                            $salida=FormatoHora($horas["salida"]);
                            $entrada=FormatoHora($horas["entrada"]); 

                            $registro = $this->Checadas->newEntity();

                            $registro->empleados_id=$id;
                            $registro->sucursal_id=$sucursal_id;
                            $registro->sucursal_checada_id=$sucursal_id;
                            $registro->dia=$dia;
                            $registro->fecha=$fecha_checada;
                            $registro->entrada=$entrada;
                            
                            if($sucursal_info->horario_libre==false)
                            {
                                $retardo=false;

                                $entrada_horario=$sucursal_info->hora_entrada->format("H:i");
                                $salida_horario=$sucursal_info->hora_salida->format("H:i");

                                $horarios_nomina=$this->HorariosNomina->find()
                                ->where(['entrada_real'=>$entrada_horario,'salida_real'=>$salida_horario])
                                ->first();

                                if($horarios_nomina!=null)
                                {  
                                    $entrada_nomina=$horarios_nomina->entrada_nomina->format("H:i");
                                    $salida_nomina=$horarios_nomina->salida_nomina->format("H:i");
                                }
                                else
                                {
                                    $entrada_nomina=$entrada_horario;
                                    $salida_nomina=$salida_horario;
                                }

                                $hrs_nomina=$this->Calcular($salida_nomina,$entrada_nomina);

                                $retardo=$this->Retardo($retardo,$entrada_horario,$entrada);

                                $entrada_nomina=$this->HoraRetardo($entrada_horario,$entrada,$entrada_nomina);

                                $registro->entrada_horario=$entrada_horario;
                                $registro->salida_horario=$salida_horario;
                                $registro->entrada_nomina=$entrada_nomina;
                                $registro->salida_nomina=$salida_nomina;
                                $registro->hrs_nomina=$hrs_nomina;
                                $registro->retardo=$retardo;                        
                            }

                            if($horas["salida"]!='')
                            {
                                $hrs_trabajadas=$this->Calcular($salida,$entrada);
                                $hrs_finales=$hrs_trabajadas;

                                if($sucursal_info->horario_libre==false)
                                {
                                    $hrs_dia=$this->Calcular($salida_horario,$entrada_horario);
                                    $registro->hrs_dia=$hrs_dia;

                                    $hrs_finales=$hrs_nomina-($hrs_dia-$hrs_trabajadas);
                                }
                                
                                $registro->salida=$salida;
                                $registro->horas=$hrs_trabajadas;
                                $registro->hrs_finales=$hrs_finales;

                                $hrs_nvas=$horas_checadas->hrs_checadas+$hrs_finales;

                                $this->checadasSemanal($hrs_nvas,$horas_checadas);
                            }
                            
                            $this->Checadas->save($registro);
                        }
                    } 
                }
            }
        }

        $this->redirect(['action' => 'reporte','filtro'=>$filtro,'sucursal' => $sucursal_id]);
    }

    private function checarRegistroHoras($id,$fecha_inicio,$fecha_termino,$sucursal_id){

        $suma_horas=0;
        $conn = ConnectionManager::get('checador');

        $query = $conn->execute('SELECT SUM(hrs_finales) AS hrs_finales FROM checadas  where fecha between "'.$fecha_inicio.'" and "'.$fecha_termino.'" and sucursal_id= "'.$sucursal_id.'"  and empleados_id="'.$id.'" ');
        $horast = $query ->fetchAll('assoc');

        $horas_checadas=$this->HorasChecadas->find()
        ->where(['empleado_id'=>$id,'fecha_inicio'=>$fecha_inicio,'fecha_termino'=>$fecha_termino,'sucursal_id'=>$sucursal_id])
        ->first();

        foreach($horast as $ht)
        {
            if($ht["hrs_finales"]!=null)
            {
               $suma_horas=$ht["hrs_finales"]; 
            }
        }

        if($horas_checadas==null)
        {
            $horas_checadas=$this->HorasChecadas->newEntity();
            $horas_checadas->empleado_id=$id;
            $horas_checadas->sucursal_id=$sucursal_id;
            $horas_checadas->fecha_inicio=$fecha_inicio;
            $horas_checadas->fecha_termino=$fecha_termino;
            $horas_checadas->hrs_checadas=$suma_horas;
        }
        else
        {
            $horas_checadas->hrs_checadas=$suma_horas;
        }
        
        $this->HorasChecadas->save($horas_checadas);
    }

    private function checadasSemanal($hrs,$checadas_semanales){

        $checadas_semanales->hrs_checadas=$hrs;
            
        $this->HorasChecadas->save($checadas_semanales);
    }

    private function HoraRetardo($entrada_horario,$entrada,$entrada_nomina){

        $entrada_segundos=strtotime($entrada);

        if($entrada_segundos>strtotime($entrada_horario))
        {   
            $entrada=$entrada;

            $hora_retardo=CalcularHoras($entrada,$entrada_horario,$entrada_nomina);

            if($hora_retardo>.17)
            {
                $entrada_nomina=$entrada; 
            }
        }

        return $entrada_nomina;
    }

    private function Retardo($retardo,$entrada_horario,$entrada){

        $tolerancia=5*60;
        $hora_tolerancia=date("H:i",strtotime($entrada_horario)+$tolerancia);
        $hora_tolerancia = strtotime($hora_tolerancia);

        if(strtotime($entrada) > $hora_tolerancia): $retardo=true; endif;

        return $retardo;
    }

    private function checadas($registros,$desde,$hasta){

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
                $hrs_checadas_semanales=$this->HorasChecadas->find()
                ->where(["empleado_id"=>$empleado->id,"fecha_inicio"=>$desde,"fecha_termino"=>$hasta])
                ->first();

                $registro[$reg->empleados_id]["checadas"][]=$reg;
                $registro[$reg->empleados_id]["empleado"]=$empleado->ncompleto;
                $registro[$reg->empleados_id]["hrs_semanales"]=($hrs_checadas_semanales!=null)? $hrs_checadas_semanales->hrs_editadas : 0; 
            }

            if(empty($registro)): $this->Flash->default('No se encontraron registros.'); endif;
        }

        return $registro;
    }

    function Calcular($hora1,$hora2){

        $salida=explode(':',$this->gethora($hora1)); 
        $entrada=explode(':',$this->gethora($hora2));

        $total_minutos_transcurridos[1] = ($salida[0]*60)+$salida[1]; 
        $total_minutos_transcurridos[2] = ($entrada[0]*60)+$entrada[1];
        $total_minutos_transcurridos = $total_minutos_transcurridos[1]-$total_minutos_transcurridos[2];

        $total_minutos_transcurridos=$total_minutos_transcurridos/60;
        $hrs=floor($total_minutos_transcurridos);
        $minutos=($total_minutos_transcurridos*60)%60;   

        

        return ($hrs+$minutos/60); 
    }


    private function gethora($hora) { 

        if($hora!="00:00")
        {
            $separar[1]=explode(':',$hora); 

            $hora=$separar[1][0];
            $minutos=$separar[1][1];
            
            if ($hora == 1) {
                $hora=13;
            } elseif ($hora == 2) {
                $hora=14;
            } elseif ($hora == 3) {
                $hora=15;
            } elseif ($hora == 4) {
                $hora=16;
            }elseif ($hora == 5) {
                $hora=17;
            }elseif ($hora == 6) {
                $hora=18;
            }elseif ($hora == 7) {
                $hora=19;
            }elseif ($hora == 8) {
                $hora=20;
            }

            return $hora.':'.$minutos;
        }
        else
        {
            return null;
        }
    }
}