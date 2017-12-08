<?php //debug($pagos_nomina); die; ?>
<?= $this->element($menu) ?>

<h3>Pago Nominas Sucursales</h3>

<br><br>
<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>

<div class="form-group form-inline col-md-12">
    
    <div class="col-lg-2">
        <label>
            <input type="radio" name="filtro" value="nomina_actual" <?php if ($filtro == "nomina_actual") echo "checked" ?> /> Nomina Actual
        </label>
    </div>
    <br><br>
    <div class="col-lg-3">
        <label>
            <input type="radio" name="filtro" value="rango" <?php if ($filtro == "rango") echo "checked" ?> /> Rango Fecha Nomina
        </label>
    </div>
    <div class="col-md-4">
        <?= $this->element('select_fecha', [
            'prefijo' => 'fecha1',
            'fecha' => $fechas['f1']
        ])
         ?>
    </div>
    <div class="col-md-5">
        <?= $this->element('select_fecha', [
            'prefijo' => 'fecha2',
            'fecha' => $fechas['f2']
        ])
         ?>
    </div>
</div>
<br><br>
    <div class="form-group form-inline control-label">
        <div class=" col-md-1 ">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>

    <?= $this->Form->hidden('enviado', ['value' => true]) ?>
    <?= $this->Form->hidden('menu', ['value' => $menu]) ?>

<?= $this->Form->end() ?>
<br>

<?php if($pagos_nomina!=null){ ?>

    <h4><b>Fecha Nomina : </b><?= date("d-M-Y",$fecha_inicio).' / '.date("d-M-Y",$fecha_fin) ?></h4>
    
    <ol class="breadcrumb center hidden-print">
        <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
    </ol>
    <?php if($cortes_nominas!=null){ ?>
        <div style="float:left;" class="hidden-print">
            <h3><b>Nominas Sucursales</b></h3>
            <table class="table table-striped">
                <tr>
                    <td><b>#</b></td>
                    <td><b>Sucursal</b></td>
                    <td><b>Fecha Inicio</b></td>
                    <td><b>Fecha Termino</b></td>
                    <td><b>Efectivo</b></td>
                    <td><b>Tarjeta</b></td>
                    <td><b>Pago General</b></td>
                </tr>
                <?php $contador=1; 
                foreach($cortes_nominas as $sucursal_id=>$info)
                { 
                    foreach($info as $corte){?>
                        <tr>
                            <td><?= $contador; ?></td>
                            <td class="hidden-print"><?= $this->Html->link($corte->sucursal_nombre, ['controller'=>'Reportes','action' => 'detalle_nomina','id' => $corte->sucursal_id,'fecha_inicio'=>$corte->fecha_inicio->format("Y-m-d"),'fecha_fin'=>$corte->fecha_termino->format("Y-m-d")],['target'=>'_blank']) ?></td>
                            <td class="visible-print-block"><?= $corte->sucursal_nombre; ?></td>
                            <td><?= $corte->fecha_inicio->format("d-M-Y"); ?></td>
                            <td><?= $corte->fecha_termino->format("d-M-Y"); ?></td>
                            <td><?= $this->Number->currency($corte->pago_efectivo) ?></td>
                            <td><?= $this->Number->currency($corte->pago_tarjeta) ?></td>
                            <td><b><?= $this->Number->currency($corte->pago_total) ?></b></td>
                        </tr>
                <?php $contador++;} } ?>
            </table>
        </div>
    <?php } ?>
    <div style="float:left; <?php if($cortes_nominas==null){ ?> margin-left:120px; <?php }else { ?> margin-left:50px; <?php } ?> ">
        <h3><b>Suma Nominas Sucursales</b></h3>
        <table  class="table table-striped">
            <tr class="active">
                <th>Sucursal</th>
                <th>Pago Efectivo</th>
                <th>Pago Tarjeta</th>
                <th>Pago General</th>
            </tr>
            <tr>
                <?php

                $efectivo=0;
                $tarjeta=0;
                $mixto=0; 

                foreach ($pagos_nomina as $id_sucursal=>$info){?>
                    
                <?php  foreach($info as $sucursal_nombre=>$pagos){ ?>
                    <td><?= $sucursal_nombre ?></td> <?php
                            foreach($pagos as $tipo=>$datos){
                                if($datos!=[]) 
                                {
                                    foreach($datos as $info){ 
                                        if($tipo=='efectivo'){ ?>
                                            <td><b><?= $this->Number->currency($info->cantidad_pago) ?></b></td> <?php
                                        }
                                        else
                                        { ?>
                                            <td><?= $this->Number->currency($info->cantidad_pago) ?></td>
                                    <?php    }

                                        if($tipo=='efectivo'){ $efectivo+=$info->cantidad_pago; }
                                        if($tipo=='tarjeta'){ $tarjeta+=$info->cantidad_pago; }
                                        if($tipo=='mixto'){ $mixto+=$info->cantidad_pago; }

                                    }
                                }
                                else
                                { ?>
                                    <td>$ 0</td> <?php
                                }
                            }
                        } ?>
            </tr> <?php
                } ?>

            <tr class="active">
                <th>Total: </th>
                <th><b> <?= $this->Number->currency($efectivo) ?></b></th>
                <th><b> <?= $this->Number->currency($tarjeta) ?></b></th>
                <th><b> <?= $this->Number->currency($mixto) ?></b></th>
            </tr>     
        </table>
    </div>
<?php } ?>