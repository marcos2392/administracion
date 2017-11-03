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
<br><br>

<?php if($pagos_nomina!=null){ ?>

    <div class="row" >
        <div class="col-sm-6 col-sm-offset-3">
            <h4><b>Fecha Nomina : </b><?= date("d-M-Y",$fecha_inicio).' / '.date("d-M-Y",$fecha_fin) ?></h4>
            <br>
            <ol class="breadcrumb center hidden-print">
                <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
            </ol>
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

                    foreach ($pagos_nomina as $id_sucursal=>$info):?>
                        
                    <?php  foreach($info as $sucursal_nombre=>$pagos): ?>
                        <td class="hidden-print"><?= $this->Html->link($sucursal_nombre, ['controller'=>'Reportes','action' => 'detalle_nomina','id' => $id_sucursal,"fecha_inicio"=>date("Y-m-d",$fecha_inicio),"fecha_fin"=>date("Y-m-d",$fecha_fin)],['target'=>'_blank']) ?></td>
                        <td class="visible-print-block"><?= $sucursal_nombre ?></td> <?php
                                foreach($pagos as $tipo=>$datos):
                                    if($datos!=[]) 
                                    {
                                        foreach($datos as $info): 
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

                                        endforeach;
                                    }
                                    else
                                    { ?>
                                        <td>$ 0</td> <?php
                                    }
                                endforeach;
                            endforeach; ?>
                    </tr> <?php
                    endforeach; ?>

                <tr class="active">
                    <th>Total: </th>
                    <th><b> <?= $this->Number->currency($efectivo) ?></b></th>
                    <th><b> <?= $this->Number->currency($tarjeta) ?></b></th>
                    <th><b> <?= $this->Number->currency($mixto) ?></b></th>
                </tr>
                    
            </table>
        </div>
    </div>
<?php } ?>