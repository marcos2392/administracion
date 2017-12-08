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
        $this->loadModel('CortesCobranzas');
        $this->loadModel('Cobranzas');
        $this->loadModel('CobranzasCobradores');
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
                $condicion = ["date(fecha)" => $fecha];

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
        $cortes=[];
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

            $prueba=[];

            foreach($sucursales as $suc)
            {
                $pagos_efectivo=$this->pagosEfectivo($condicion,$suc->id);
                $pagos_tarjeta=$this->pagosTarjeta($condicion,$suc->id);
                $pagos_mixto=$this->pagosMixto($condicion,$suc->id);
                
                $pagos_nomina[$suc->id][$suc->nombre]["efectivo"]=$pagos_efectivo;
                $pagos_nomina[$suc->id][$suc->nombre]["tarjeta"]=$pagos_tarjeta;
                $pagos_nomina[$suc->id][$suc->nombre]["mixto"]=$pagos_mixto;
            

                $cortes=$this->NominaEmpleadas->find()
                ->select([
                            'fecha'=>'NominaEmpleadas.fecha','fecha_inicio'=>'NominaEmpleadas.fecha_inicio','fecha_termino'=>'NominaEmpleadas.fecha_fin','pago_total' => 'sum(NominaEmpleadas.sueldo_final)','sucursal_nombre'=>'Sucursales.nombre','sucursal_id'=>'Sucursales.id'])
                ->join([
                    'Sucursales' => [
                        'table' => 'sucursales',
                        'type' => 'inner',
                        'conditions' => ['Sucursales.id = NominaEmpleadas.sucursal_id']]])
                ->where([$condicion,'NominaEmpleadas.sucursal_id'=>$suc->id])
                ->group('NominaEmpleadas.fecha_inicio')
                ->order('NominaEmpleadas.sucursal_id')
                ->toArray();

                $prueba[$suc->id]=$cortes;
            }

            foreach ($prueba as $sucursal_id=>$info) 
            {
                foreach($info as $corte)
                {
                    $condicion=["date(NominaEmpleadas.fecha_inicio)= '".$corte->fecha_inicio->format("Y-m-d")."'"];

                    $pagos_efectivo=$this->pagosEfectivo($condicion,$corte->sucursal_id);
                    $pagos_tarjeta=$this->pagosTarjeta($condicion,$corte->sucursal_id);

                    foreach($pagos_efectivo as $pago)
                    {
                        $corte->pago_efectivo=$pago->cantidad_pago;
                    }

                    foreach($pagos_tarjeta as $pago)
                    {
                        $corte->pago_tarjeta=$pago->cantidad_pago;
                    }
                }
            }
        }
         
        $this->set(compact('pagos_nomina','fechas','filtro','menu','fecha_inicio','fecha_fin','info_sucursal','prueba'));
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

        $cobradores=$this->Cobradores->find()->order('nombre');
        $menu = $this->request->getQuery('menu')?? 'menu_reportes';
        $cortes=[];
        $fechas = $this->setFechasReporte();
        $enviado = $this->request->getQuery('enviado') ?? false;
        $cobrador_id=$this->request->getQuery("cobrador")?? 0;

        if ($enviado!==false)
        {
            $info_cobrador=$this->Cobradores->get($cobrador_id);
            
            $fecha_inicio = date('Y-m-d', $fechas['f1']);
            $fecha_termino = date('Y-m-d', $fechas['f2']);

            $cortes=$this->Cortes->find()
            ->contain('Cobradores')
            ->where(["date(cortes.fecha) between '".$fecha_inicio."' and '".$fecha_termino."'",'cobrador_id'=>$cobrador_id])
            ->order('Cobradores.nombre')
            ->toArray();
        }
        
        $this->set(compact('cortes','menu','cobradores','cobrador_id','fechas','info_cobrador')); 
    }

    public function cortesDetalle(){

        $corte_id=$this->request->getParam('id');
        $detalles=[];

        $corte=$this->Cortes->get($corte_id);

        $cortes_cobranzas=$this->CortesCobranzas->find()
        ->contain('CobranzasCobradores','Cobranzas')
        ->where(['corte_id'=>$corte_id])
        //->order('id')
        ->toArray(); 

        $cobrador=$this->Cobradores->get($corte->cobrador_id);

        $corte->cobrador_nombre=$cobrador->nombre;

        foreach($cortes_cobranzas as $corte_cobranza)
        {
            $cobranzas=$this->Cobranzas->get($corte_cobranza["cobranza_cobrador"]["cobranza_id"]);
            $corte_cobranza->cobranza_descripcion=$cobranzas->descripcion;
            $corte_cobranza->cobranza_nombre=$cobranzas->nombre;
        }

        $detalles["cobranzas"]=$cortes_cobranzas;

        $this->set(compact('detalles','corte')); 
        
    }

    private function pagosEfectivo($condicion,$sucursal){

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
                ->where([$condicion,'Empleados.tarjeta'=>0,'NominaEmpleadas.sucursal_id'=>$sucursal])
                ->group('NominaEmpleadas.sucursal_id')
                ->toArray();

        return $pagos_efectivo;
    }

    private function pagosTarjeta($condicion,$sucursal){

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
                ->where([$condicion,'Empleados.tarjeta'=>1,'NominaEmpleadas.sucursal_id'=>$sucursal])
                ->group('NominaEmpleadas.sucursal_id')
                ->toArray();

        return $pagos_tarjeta;
    }

    private function pagosMixto($condicion,$sucursal){

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
            ->where([$condicion,'NominaEmpleadas.sucursal_id'=>$sucursal])
            ->group('NominaEmpleadas.sucursal_id')
            ->toArray();

        return $pagos_mixto;
    }
}