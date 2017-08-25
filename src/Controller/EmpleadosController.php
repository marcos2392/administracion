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
class EmpleadosController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->loadModel('Empleados');
        $this->loadModel('Sucursales');
        $this->loadModel('Clientes');
        
    }

    public function empleados() {

    	$usuario = $this->getUsuario();

        $condicion = ["empleados.status=true"];

    	$empleados=$this->Empleados->find()
    	->contain(['sucursales'])
    	->where($condicion)
        ->order('sucursales.nombre,empleados.nombre');

        $this->set(compact('empleados'));
    }

    public function nuevo() {
        $usuario = $this->getUsuario();

        $clientes=$this->Clientes->find()
        ->where(['activo'=>true,'empleado'=>true]);

        $sucursal='';
        $empleado = $this->Empleados->newEntity();
        $sucursales =$this->Sucursales->find()
        ->order(['nombre']);

        $this->set(compact('empleado','sucursales','sucursal','clientes'));
    }

    public function crear() {

    	$usuario = $this->getUsuario();

        if($usuario->admin)
        {
            $sucursal = $this->request->getData('sucursal');
        }
        else
        {
            $sucursal = $usuario->sucursal_id;
        }

		$nombre = $this->request->getData('nombre');
		$apellidos = $this->request->getData('apellidos');
        $empleado_id = $this->request->getData('empleado');
        $descanso = $this->request->getData('descanso')?? 0;
        $diaextra = $this->request->getData('diaextra')?? 0;
        $tipoextra = $this->request->getData('tipoextra')?? 0;
        $horario_mixto = $this->request->getData('horario_mixto')?? 0;
        $sueldo = $this->request->getData('sueldo')?? 0;
        $porcentaje_comision = $this->request->getData('porcentaje')?? 0;
        $infonavit = $this->request->getData('infonavit')?? 0;
        $tarjeta = $this->request->getData('tarjeta')?? 0;

        $nombre=htmlentities($nombre, ENT_QUOTES,'UTF-8');
        $nombre = ucwords(strtolower($nombre));

        $apellidos=htmlentities($apellidos, ENT_QUOTES,'UTF-8');
        $apellidos = ucwords(strtolower($apellidos));

        $empleado_existente = $this->Empleados->find()
        ->where(['nombre' => $nombre,'apellidos'=>$apellidos])
        ->first();
        if ($empleado_existente) 
        {
            $this->Flash->error('Ya existe un Empleado con ese nombre: ' . $nombre.' '. $apellidos);
            $this->redirect(['action' => 'nuevo']);
            return;
        }

        $empleado = $this->Empleados->newEntity();
        $empleado->nombre = $nombre;
        $empleado->apellidos=$apellidos;
        $empleado->status=true;
        $empleado->sucursal_id=$sucursal;
        $empleado->descanso=$descanso;
        $empleado->dia_extra=$diaextra;
        $empleado->tipo_extra=$tipoextra;
        $empleado->empleado_id=$empleado_id;
        $empleado->horario_mixto=$horario_mixto;
        $empleado->sueldo=$sueldo;
        $empleado->porcentaje_comision=$porcentaje_comision;
        $empleado->infonavit=$infonavit;
        $empleado->tarjeta=$tarjeta;

        if($nombre=="" || $apellidos=="" || $descanso=="" || $sucursal=="")
        {
            $this->Flash->default("Necesita llenar todos los campos");
            $this->redirect(['action' => 'nuevo']); 
        }
        else
        {
            $this->Empleados->save($empleado);

            $this->Flash->default("Se creó el Empleado: ".$nombre.' '.$apellidos." , Exitosamente.");
            $this->redirect(['action' => 'empleados']); 
        }
    }

    public function editar() {

        $sucursales =$this->Sucursales->find()
        ->order(['nombre']);
        $empleado = $this->Empleados->get($this->request->getQuery('id'));
        $sucursal=$empleado->sucursal_id;
        
        $this->set(compact('empleado','sucursales','sucursal'));
    }

    public function actualizar() {

        $empleado = $this->getEmpleado();

        $nombres = $this->request->getData('nombre') ?? '';
        $apellidos = $this->request->getData('apellidos') ?? '';
        $sucursal = $this->request->getData('sucursal') ?? '';
        $descanso = $this->request->getData('descanso')?? 0;
        $diaextra = $this->request->getData('diaextra')?? 0;
        $tipoextra = $this->request->getData('tipoextra')?? 0;
        $sueldo = $this->request->getData('sueldo')?? 0;
        $porcentaje_comision = $this->request->getData('porcentaje')?? 0;
        $infonavit = $this->request->getData('infonavit')?? 0;
        $tarjeta = $this->request->getData('tarjeta')?? 0;
        $lunes_entrada = $this->request->getData('lunes_entrada');
        $lunes_salida = $this->request->getData('lunes_salida');
        $martes_entrada = $this->request->getData('martes_entrada');
        $martes_salida = $this->request->getData('martes_salida');
        $miercoles_entrada = $this->request->getData('miercoles_entrada');
        $miercoles_salida = $this->request->getData('miercoles_salida');
        $jueves_entrada = $this->request->getData('jueves_entrada');
        $jueves_salida = $this->request->getData('jueves_salida');
        $viernes_entrada = $this->request->getData('viernes_entrada');
        $viernes_salida = $this->request->getData('viernes_salida');
        $sabado_entrada = $this->request->getData('sabado_entrada');
        $sabado_salida = $this->request->getData('sabado_salida');
        $domingo_entrada = $this->request->getData('domingo_entrada');
        $domingo_salida = $this->request->getData('domingo_salida');

        $nombres = ucwords(strtolower($nombres));
        $apellidos=htmlentities($apellidos, ENT_QUOTES,'UTF-8'); 
        $apellidos = ucwords(strtolower($apellidos));

        $lunes_entrada=$this->gethora($lunes_entrada);
        $lunes_salida=$this->gethora($lunes_salida);
        $martes_entrada=$this->gethora($martes_entrada);
        $martes_salida=$this->gethora($martes_salida);
        $miercoles_entrada=$this->gethora($miercoles_entrada);
        $miercoles_salida=$this->gethora($miercoles_salida);
        $jueves_entrada=$this->gethora($jueves_entrada);
        $jueves_salida=$this->gethora($jueves_salida);
        $viernes_entrada=$this->gethora($viernes_entrada);
        $viernes_salida=$this->gethora($viernes_salida);
        $sabado_entrada=$this->gethora($sabado_entrada);
        $sabado_salida=$this->gethora($sabado_salida);
        $domingo_entrada=$this->gethora($domingo_entrada);
        $domingo_salida=$this->gethora($domingo_salida);

        $empleado->lunes_entrada=$lunes_entrada;
        $empleado->lunes_salida=$lunes_salida;
        $empleado->martes_entrada=$martes_entrada;
        $empleado->martes_salida=$martes_salida;
        $empleado->miercoles_entrada=$miercoles_entrada;
        $empleado->miercoles_salida=$miercoles_salida;
        $empleado->jueves_entrada=$jueves_entrada;
        $empleado->jueves_salida=$jueves_salida;
        $empleado->viernes_entrada=$viernes_entrada;
        $empleado->viernes_salida=$viernes_salida;
        $empleado->sabado_entrada=$sabado_entrada;
        $empleado->sabado_salida=$sabado_salida;
        $empleado->domingo_entrada=$domingo_entrada;
        $empleado->domingo_salida=$domingo_salida;
        

        $empleado->nombre=$nombres;
        $empleado->apellidos=$apellidos;
        $empleado->descanso=$descanso;
        $empleado->dia_extra=$diaextra;
        $empleado->tipo_extra=$tipoextra;
        $empleado->sueldo=$sueldo;
        $empleado->porcentaje_comision=$porcentaje_comision;
        $empleado->infonavit=$infonavit;
        $empleado->tarjeta=$tarjeta;
        $empleado->sucursal_id=$sucursal;
        

        if ($this->request->is('post'))
        {
            if($this->Empleados->save($empleado))
             {
                $this->Flash->default("Se actualizo al empleado: ".$nombres.' '.$apellidos." ,exitosamente.");
                $this->redirect(['action' => 'empleados']);
             }
             else
             {
               $this->Flash->error("Hubo un Error al Actualizar el Empleado.");
               $this->redirect(['action' => 'editar']);
             }
        }
    }

    public function eliminar() {

        if ($this->Empleados->get($this->request->getQuery('id'))) 
        {
            $empleado = $this->Empleados->get($this->request->getQuery('id'));
            $empleado->status=0;

            $this->Empleados->save($empleado);

            $this->Flash->default("Se elimino el Empleado exitosamente.");
            $this->redirect(['action' => 'empleados']);
        }
        else
        {
        	$this->Flash->default("no");
            $this->redirect(['action' => 'empleados']);
        }
    }

    private function getEmpleado() {
        $id_empleado = $this->request->getQuery('id');
        return $this->Empleados->get($id_empleado);
    }

    public function horarios()
    {
        $usuario = $this->getUsuario();

        $sucursal=$this->request->getQuery('sucursal');
        $enviado = $this->request->getQuery('enviado') ?? false;

        $condicion = ["empleados.status=true"];

        $empleados=$this->Empleados->find()
        ->contain(['sucursales'])
        ->where($condicion)
        ->order('sucursales.nombre,empleados.nombre');

        $sucursales=$this->Sucursales->find()
        ->order('nombre');

        if($enviado!==false) {
            debug($sucursal); die;
        }

        $this->set(compact('empleados','sucursales','sucursal'));
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