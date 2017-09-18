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

        $menu = $this->request->getQuery('menu')?? 'menu_checador';

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
        $this->set(compact('inicio','fin','registro','filtro','sucursales','sucursal','sucursal_nombre','empleados','menu'));
    }

    public function editar() {

        $sucursal=$this->request->getQuery('sucursal');
        $desde_fecha=$this->request->getQuery('inicio');
        $hasta_fecha=$this->request->getQuery('fin');

        $registros=$this->Checadas->find()
        ->where(['fecha between "'.$desde_fecha.'" and "'.$hasta_fecha.'" and sucursal="'.$sucursal.'"'])
        ->order('empleados_id, fecha,checadas.entrada');

        $registro=$this->checadas($registros);

        $this->set(compact('registro','sucursal'));
    }

    public function actualizar() {

        $sucursal = $this->request->getQuery('sucursal'); //debug($sucursal); die;
        $empleados = $this->request->getData(); //debug($empleados); die;
        $fecha=date("Y-m-d");

        foreach($empleados as $emp)
        {
            foreach($emp as $id=>$e)
            {
                foreach($e as $dia=>$checadas)
                { 
                    foreach($checadas as $fecha_checada=>$horas)
                    {
                        $registro=$this->Checadas->find()
                        ->where(['fecha="'.$fecha_checada.'" and sucursal="'.$sucursal.'" and empleados_id="'.$id.'"'])
                        ->first();

                        if(!empty($registro))
                        {
                            $registro=$this->Checadas->get($registro["id"]);

                            if($horas["entrada"]!='D')
                            {
                                $salida=FormatoHora($horas["salida"]);
                                $entrada=FormatoHora($horas["entrada"]);

                                if($registro->descanso==true)
                                {
                                    $entrada_horario=$entrada;
                                    $salida_horario=$salida;

                                    $registro->entrada_horario=$entrada;
                                    $registro->salida_horario=$salida;
                                    $registro->descanso=false;

                                    $hrs_trabajadas= Calcular($salida,$entrada,$entrada_horario,$salida_horario,$registro->tipo_extra);

                                    $registro->hrs_dia=$hrs_trabajadas;
                                }
                                else
                                {
                                    $entrada_horario=$registro->entrada_horario->format("H:i");
                                    $salida_horario=$registro->salida_horario->format("H:i"); //debug($entrada_horario); die;
                                }

                                $hrs_trabajadas= Calcular($salida,$entrada,$entrada_horario,$salida_horario,$registro->tipo_extra);

                                $registro->entrada=$entrada;
                                $registro->salida=$salida;
                                $registro->horas=$hrs_trabajadas;

                                $this->Checadas->save($registro);
                            }
                        }
                        else
                        { 
                            if($horas["entrada"]!='' or $horas["salida"]!='')
                            { 
                                $registro = $this->Checadas->newEntity();

                                $registro->empleados_id=$id;
                                $registro->sucursal=$sucursal;
                                $registro->dia=$dia;
                                $registro->fecha=$fecha_checada;

                                if($horas["entrada"]=='0')
                                { 
                                    $registro->hrs_dia=$horas["salida"];
                                    $registro->falta=true;
                                }
                                else
                                {
                                    $salida=FormatoHora($horas["salida"]);
                                    $entrada=FormatoHora($horas["entrada"]); 

                                    $hrs_trabajadas=$this->Calcular($salida,$entrada);

                                    $registro->entrada=$entrada;
                                    $registro->salida=$salida;
                                    $registro->entrada_horario=$entrada;
                                    $registro->salida_horario=$salida;
                                    $registro->horas=$hrs_trabajadas;
                                    $registro->hrs_dia=$hrs_trabajadas;
                                }
                                
                                $this->Checadas->save($registro);
                            }
                        }
                    }
                }
            }
        }

        $this->redirect(['action' => 'reporte','filtro'=>"semanal",'sucursal' => $sucursal]);
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