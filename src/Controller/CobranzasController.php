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
class CobranzasController extends AppController
{
    public function beforeFilter(Event $event) {

        $this->loadModel('Cobradores');
        $this->loadModel('Cobranzas');
        $this->loadModel('Cortes');
        $this->loadModel('CobranzasCobradores');
        $this->loadModel('DetallesCuentaCobranza');
        $this->loadModel('CuentasPrestamo');
        $this->loadModel('PagosCuentaPrestamo');
        $this->loadModel('CortesCobranzas');
        $this->loadModel('MovimientosCaja');
    }

    public function cobranzas(){

    	$fecha=date('Y-m-d H:i');
        $usuario = $this->getUsuario();
        $fechas = $this->setFechasReporte(); 
        $enviado = $this->request->getQuery('enviado') ?? false;
        
        $cobrador=$this->request->getQuery("cobrador")?? 0;

        $cobradores=$this->Cobradores->find();

        if ($enviado!==false)
        {
            $fecha_inicio = date('Y-m-d', $fechas['f1']);
            $fecha_termino = date('Y-m-d', $fechas['f2']);

           $this->redirect(['action' => 'corte','cobrador'=>$cobrador,'fecha_inicio'=>$fecha_inicio,'fecha_termino'=>$fecha_termino]);     
        }
        else
        {
            $this->set(compact('cobradores','cobrador','cobranzas','fechas'));
        }
    }

    public function corte(){

        $usuario = $this->getUsuario();
        $cobrador=$this->request->getQuery('cobrador');
        $fecha_inicio=$this->request->getQuery('fecha_inicio');
        $fecha_termino=$this->request->getQuery('fecha_termino');
        $fecha=date("Y-m-d H:i");

        if ($this->request->is('post'))
        {
            $cobrador=$this->request->getData('cobrador');
            $cobranzas=$this->request->getData("cobranza");
            $ingreso=$this->request->getData('ingreso');
            $folios=$this->request->getData('folios')?? '';
            $extra=$this->request->getData('extra');
            $suma_cobranzas=$this->request->getData('suma_cobranzas');
            $cobranza_entregado=$this->request->getData('cobranza_entregada');

            $info_cobrador=$this->Cobradores->get($cobrador);

            $pagos_en_sucursal=$suma_cobranzas-$cobranza_entregado;

            $corte=$this->Cortes->newEntity();

            $corte->fecha=$fecha;
            $corte->folios=$folios;
            $corte->cobrador_id=$cobrador;
            $corte->extra=$extra;
            $corte->total=$suma_cobranzas;
            $corte->total_sucursales=$pagos_en_sucursal;
            $corte->total_cobrador=$cobranza_entregado;
            $corte->fecha_inicio=$fecha_inicio;
            $corte->fecha_termino=$fecha_termino;
            $corte->ingreso_caja=$ingreso;

            $this->Cortes->save($corte);

            $corte_id=$this->guardar($cobranzas,$cobrador);

            $ultimo_movimiento_caja=$this->MovimientosCaja->find()
            ->where(['sucursal_id'=>$usuario->sucursal_id])
            ->order('fecha desc')
            ->first();

            $cantidad_existente=($ultimo_movimiento_caja!=null)? $ultimo_movimiento_caja->cantidad_existente : 0;

            $ingreso_caja=$this->MovimientosCaja->newEntity();
            $ingreso_caja->fecha=$fecha;
            $ingreso_caja->usuario_id=$usuario->id;
            $ingreso_caja->descripcion="Cobranza ".$info_cobrador->nombre ;
            $ingreso_caja->tipo_movimiento=($ingreso>0)?"Ingreso" : "Gasto";
            $ingreso_caja->cantidad=($ingreso>0)?$ingreso : $ingreso*(-1);
            $ingreso_caja->cantidad_existente=$cantidad_existente+$ingreso;
            $ingreso_caja->cantidad_existente_anterior=$cantidad_existente;
            $ingreso_caja->sucursal_id=$usuario->sucursal_id;

            $this->MovimientosCaja->save($ingreso_caja);

            $this->redirect(['action' => 'cobranzas']);

        }
        else
        {
            $info_cobrador=$this->Cobradores->get($cobrador);

            $cobranzas=$this->CobranzasCobradores->find()
            ->contain('Cobranzas')
            ->where(['cobrador_id'=>$cobrador])
            ->order('Cobranzas.nombre')
            ->toArray(); 

            $totales=[];

            foreach($cobranzas as $cobranza)
            { 
                $total=0;
                $nombre=$cobranza["cobranza"]["nombre"];

                $totales["cobranza_cobrador"]=0;
                $totales["prestamos_cobrador"]=0;
                $totales["prestamos_seis_meses"]=0;
                $totales["prestamos_doce_meses"]=0;

                switch ($nombre) {

                    case "cobranza_sucursal":
                        
                        $cobranza_sucursal=$this->DetallesCuentaCobranza->find()
                        ->where(['cobrador_id'=>$info_cobrador->id_cobrador_sistema,'pago'=>true,"convert(date,fecha) between '".$fecha_inicio."' and '".$fecha_termino."' ","usuario_id <> 3"])
                        ->toArray();

                        foreach($cobranza_sucursal as $cobranza)
                        {
                            $total+=$cobranza->saldo_antes-$cobranza->saldo_despues;
                        }

                        $totales["cobranza_sucursal"]=$total;
                        break;

                    case "prestamos_sucursal":
                        
                        $prestamo_sucursal = $this->CuentasPrestamo->find()
                        ->select([
                            'pago' => 'PagosCuentaPrestamo.cantidad_pago'
                        ])->join([
                            'PagosCuentaPrestamo' => [
                                'table' => 'pagos_cuenta_prestamo',
                                'type' => 'inner',
                                'conditions' => ['PagosCuentaPrestamo.cuenta_prestamo_id = CuentasPrestamo.id']
                            ]
                        ])->where([
                            "CONVERT(date,PagosCuentaPrestamo.fecha_pago) between '".$fecha_inicio."' and '".$fecha_termino."' " ,"CuentasPrestamo.cobrador_id = '".$info_cobrador->id_cobrador_sistema."' ","PagosCuentaPrestamo.cantidad_pago<>0","PagosCuentaPrestamo.usuario_id <> 3"
                        ]);
                        
                        foreach($prestamo_sucursal as $prestamo)
                        { 
                            $total+=$prestamo->pago;
                        }

                        $totales["prestamos_sucursal"]=$total;
                        break;
                }
            }

            $this->set(compact('info_cobrador','cobranzas','cobrador','totales','fecha_inicio','fecha_termino'));
        }
    }

    private function guardar($cobranzas,$cobrador){

        $corte=$this->Cortes->find()
        ->where(['cobrador_id'=>$cobrador])
        ->order('fecha desc')
        ->first();

        foreach($cobranzas as $nombre=>$info)
        {
            foreach($info as $id=>$cantidad)
            {
                $cobranza=$this->CobranzasCobradores->get($id);

                $cortes_cobranzas=$this->CortesCobranzas->newEntity();
                $cortes_cobranzas->corte_id=$corte->id;
                $cortes_cobranzas->cobranza_cobrador_id=$id;
                $cortes_cobranzas->cantidad=$cantidad;
                $cortes_cobranzas->comision=round($cantidad*$cobranza->porcentaje_comision);
                $cortes_cobranzas->porcentaje_comision=$cobranza->porcentaje_comision;

                $this->CortesCobranzas->save($cortes_cobranzas);   
            }
        }

        return $corte->id;
    }
}