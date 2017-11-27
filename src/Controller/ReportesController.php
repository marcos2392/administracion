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
        $this->loadModel('Sucursales');
        $this->loadModel('Transacciones');
        $this->loadModel('MovimientosCaja');
        $this->loadModel('Reparaciones');
        $this->loadModel('Joyeros');
        $this->loadModel('Proveedores');
        $this->loadModel('MovimientosProveedores');
        $this->loadModel('SaldoProveedores');
        $this->loadModel('NominaEmpleadas');
        $this->loadModel('VentasSucursales');
        $this->loadModel('Empleados');
        $this->loadModel('Cortes');
        $this->loadModel('Cobradores');
    }

    public function reportes()
    {

    }

    public function caja(){

        $usuario=$this->getUsuario();

        $sucursal=$this->Sucursales->get($usuario->sucursal_id);

        $menu = $this->request->getQuery('menu')?? 'menu_caja';

        $cantidad_movimiento_anterior=0;

        $fechas = $this->setFechasReporte();
        $filtro = $this->request->getQuery('filtro') ?? 'dia';
        $enviado = $this->request->getQuery('enviado') ?? false;

        $sucursales=$this->Sucursales->find()
        ->where(['caja'=>true])
        ->order('nombre');

        $usuario_caja=$this->request->getQuery('usuarios')?? $sucursal->id;
        
        $movimientos=[];

        if ($enviado!==false)
        {
            if ($filtro == "dia") 
            {
                $fecha=date('Y-m-d');
                $condicion = ["movimientoscaja.date(fecha)" => $fecha];

                $fecha_reporte = date('Y-m-d');
            } 
            else 
            { 
                $fecha_inicio=date('d-M-Y', $fechas['f1']);
                $fecha_fin=date('d-M-Y', $fechas['f2']);
                $condicion = ["date(fecha) BETWEEN '" . date('Y-m-d', $fechas['f1']) . "' AND '" . date('Y-m-d', $fechas['f2']) . "'"];

                $fecha_reporte=date('Y-m-d H:i', $fechas['f1']);
            }

            $cantidad_anterior=$this->MovimientosCaja->find()
            ->where(['date(fecha) < "'.$fecha_reporte.'" and sucursal_id="'.$usuario_caja.'"'])
            ->order('fecha desc')
            ->first();

            if($cantidad_anterior!=null){ $cantidad_movimiento_anterior=$cantidad_anterior->cantidad_existente; }
            
            $condicion[]=["movimientoscaja.sucursal_id"=>$usuario_caja]; 
            $movimientos = $this->MovimientosCaja->find()
            ->contain('Usuarios')
            ->where($condicion)
            ->order('fecha')
            ->toArray();
        }

        $this->set(compact('filtro','movimientos','fecha_inicio','fecha_fin','sucursales','usuario_caja','cantidad_movimiento_anterior','menu'));
    }

    public function reparaciones(){

        $usuario=$this->getUsuario();

        $menu = $this->request->getQuery('menu')?? 'menu_reparaciones';

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

        $this->set(compact('filtro','recibos','joyeros','joyero','joyero_nombre','fecha_inicio','fecha_fin','fecha','menu'));

    }

    public function movimientosProveedores(){

        $usuario=$this->getUsuario();

        $menu = $this->request->getQuery('menu')?? 'menu_proveedores';

        $proveedores=$this->Proveedores->find()
        ->where(['activo'=>true])
        ->order('nombre')
        ->toArray();

        $fechas = $this->setFechasReporte();
        $filtro = $this->request->getQuery('filtro') ?? 'dia';
        $enviado = $this->request->getQuery('enviado') ?? false;
        $proveedor = $this->request->getQuery('proveedor')?? ''; 
        
        $movimientos=[];

        if ($enviado!==false)
        { 
            if ($filtro == "dia") {
                $fecha=date('Y-m-d');
                $condicion= ["date(MovimientosProveedores.fecha)" => $fecha];
            } 
            else 
            { 
                $fecha_inicio=date('d-M-Y', $fechas['f1']);
                $fecha_fin=date('d-M-Y', $fechas['f2']);
                $condicion = ["date(MovimientosProveedores.fecha) BETWEEN '" . date('Y-m-d', $fechas['f1']) . "' AND '" . date('Y-m-d', $fechas['f2']) . "'"]; 
            }
            
            $condicion[]=($proveedor!=0)?["proveedor_id"=>$proveedor]: []; 

            $movimientos = $this->MovimientosProveedores->find()
            ->contain(['Usuarios','Proveedores'])
            ->where($condicion)
            ->order(['Proveedores.nombre','MovimientosProveedores.fecha'])
            ->toArray();
        }

        $this->set(compact('filtro','movimientos','fecha_inicio','fecha_fin','proveedores','proveedor','menu'));

    }

    public function saldosProveedores(){

        $menu = $this->request->getQuery('menu')?? 'menu_proveedores';

        $saldos=$this->SaldoProveedores->find()
        ->contain('Proveedores')
        ->where(['Proveedores.activo'=>true])
        ->order('Proveedores.nombre')
        ->toArray();

        $this->set(compact('saldos','menu'));

    }

    public function pagoNominas(){

        $pagos_nomina=[];
        $info_sucursal=[];

        $fecha_inicio=strtotime('monday this week -7 days');
        $fecha_fin=strtotime('sunday this week -7 days');

        $fechas = $this->setFechasReporte();
        $filtro = $this->request->getQuery('filtro') ?? 'nomina_actual';
        $enviado = $this->request->getQuery('enviado') ?? false;

        $menu = $this->request->getQuery('menu')?? 'menu_nominas';

        $sucursales=$this->Sucursales->find()
        ->where(['generar_nomina'=>true])
        ->order('nombre')
        ->toArray();

        if ($enviado!==false)
        { 
            if ($filtro == "nomina_actual") {
                $fecha=date("Y-m-d",strtotime('monday this week -7 days'));
                $condicion = ["date(fecha_inicio)" => $fecha];
            } 
            else 
            { 
                $fecha_inicio=$fechas['f1'];
                $fecha_fin=$fechas['f2'];
                $condicion = ["date(fecha_inicio) BETWEEN '" . date('Y-m-d', $fechas['f1']) . "' AND '" . date('Y-m-d', $fechas['f2']) . "'"]; 
            }

            foreach($sucursales as $suc)
            {

                $pagos_efectivo=$this->NominaEmpleadas->find()
                ->select([
                        'cantidad_pago' => 'sum(NominaEmpleadas.sueldo_final)','sucursal_nombre'=>'Sucursales.nombre'])
                ->join([
                    'Sucursales' => [
                        'table' => 'sucursales',
                        'type' => 'inner',
                        'conditions' => ['Sucursales.id = NominaEmpleadas.sucursal_id']],'Empleados' => [
                        'table' => 'empleados',
                        'type' => 'inner',
                        'conditions' => ['Empleados.id = NominaEmpleadas.empleados_id']]])
                ->where([$condicion,'Empleados.tarjeta'=>0,'NominaEmpleadas.sucursal_id'=>$suc->id])
                ->group('NominaEmpleadas.sucursal_id')
                ->toArray();

                $pagos_tarjeta=$this->NominaEmpleadas->find()
                ->select([
                        'cantidad_pago' => 'sum(NominaEmpleadas.sueldo_final)','sucursal_nombre'=>'Sucursales.nombre'])
                ->join([
                    'Sucursales' => [
                        'table' => 'sucursales',
                        'type' => 'inner',
                        'conditions' => ['Sucursales.id = NominaEmpleadas.sucursal_id']],'Empleados' => [
                        'table' => 'empleados',
                        'type' => 'inner',
                        'conditions' => ['Empleados.id = NominaEmpleadas.empleados_id']]])
                ->where([$condicion,'Empleados.tarjeta'=>true,'NominaEmpleadas.sucursal_id'=>$suc->id])
                ->group('NominaEmpleadas.sucursal_id')
                ->toArray();

                $pagos_mixto=$this->NominaEmpleadas->find()
                ->select([
                        'cantidad_pago' => 'sum(NominaEmpleadas.sueldo_final)','sucursal_nombre'=>'Sucursales.nombre'])
                ->join([
                    'Sucursales' => [
                        'table' => 'sucursales',
                        'type' => 'inner',
                        'conditions' => ['Sucursales.id = NominaEmpleadas.sucursal_id']],'Empleados' => [
                        'table' => 'empleados',
                        'type' => 'inner',
                        'conditions' => ['Empleados.id = NominaEmpleadas.empleados_id']]])
                ->where([$condicion,'NominaEmpleadas.sucursal_id'=>$suc->id])
                ->group('NominaEmpleadas.sucursal_id')
                ->toArray();

                $pagos_nomina[$suc->id][$suc->nombre]["efectivo"]=$pagos_efectivo;
                $pagos_nomina[$suc->id][$suc->nombre]["tarjeta"]=$pagos_tarjeta;
                $pagos_nomina[$suc->id][$suc->nombre]["mixto"]=$pagos_mixto;

            }
        }
         
        $this->set(compact('pagos_nomina','fechas','filtro','menu','fecha_inicio','fecha_fin','info_sucursal'));

    }

    public function detalleNomina(){

        $venta_sucursal=0;
        $fecha_inicio = $this->request->getQuery('fecha_inicio');
        $fecha_fin = $this->request->getQuery('fecha_fin');
        $sucursal_id=$this->request->getParam('id');

        $sucursal_info=$this->Sucursales->get($sucursal_id);

        $nomina=$this->NominaEmpleadas->find()
        ->contain('Empleados')
        ->where(["nominaempleadas.sucursal_id"=>$sucursal_id,"date(nominaempleadas.fecha_inicio)"=>$fecha_inicio])
        ->order('Empleados.nombre')
        ->toArray();


        foreach($nomina as $nom)
        { 
            if($nom->venta_id!=null)
            {
                $venta_semanal=$this->VentasSucursales->get($nom->venta_id);
            
                $venta_sucursal=$venta_semanal->venta;
            }
        }

        $this->set(compact('sucursal_info','nomina','venta_sucursal','fecha_inicio','fecha_fin'));

    }

    public function cortes(){

        $menu = $this->request->getQuery('menu')?? 'menu_cortes';

        $cortes=$this->Cortes->find()
        ->contain('Cobradores')
        ->where(['Cobradores.activo'=>true])
        ->order('Cobradores.nombre')
        ->toArray();

        $this->set(compact('cortes','menu'));

    }
}