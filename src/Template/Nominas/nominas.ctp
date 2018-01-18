
<h3><b>Nominas</b></h3>
<br>
<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline control-label">
        <h4><?= $this->Form->label('sucursal', 'Sucursal:', ['class' => 'control-label col-md-1']) ?></h4>
        <div class="col-md-2">
            <?= $this->Form->select('sucursal', $this->Select->options($sucursales, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value' => $sucursal, 'class' => 'form-control']) ?>
        </div>
        <div class=" col-md-1">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>

     <?= $this->Form->hidden('enviado', ['value' => true]) ?>
<?= $this->Form->end() ?>
<br>
<?php if(!$sucursal_capturada->isEmpty()){

        $total_nomina=0;
        foreach($sucursal_capturada as $reg)
        {
            if($reg->empleado->tarjeta==false)
            {
                $total_nomina+= $reg->sueldo_final;
            }
        } ?>

        <h4><b>Sucursal: </b><?= $sucursal_info->nombre ?></h4>
        <h4><b>Fecha: </b><?= $inicio_nomina," / ",$termino_nomina ?></h4>
        <h4><b>Venta Sucursal: </b><?= $this->Number->currency($venta_semanal) ?></h4>
        <h4><b>Total Nomina: </b><?= $this->Number->currency($total_nomina) ?></h4>

        <ol class="breadcrumb center hidden-print">
            <li><?=$this->Html->link('Editar',['controller' =>'Nominas','action' => 'editar','sucursal'=>$sucursal,'inicio'=>$inicio_nomina]); ?></li>
            <li><?=$this->Html->link('Agregar Empleado',['controller' =>'Nominas','action' => 'agregarEmpleado','sucursal'=>$sucursal,'inicio'=>$inicio_nomina,'termino'=>$termino_nomina],['target'=>'_self']); ?></li>
            <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
        </ol>

        <?php $bono=false;$comision=false;$deduccion=false;$infonavit=false;$joyeria=false;$prestamo=false;
        foreach($datos_generales as $datos)
        {
            if($datos->comision>0){ $comision=true;}
            if($datos->bono>0){ $bono=true;}
            if($datos->deduccion>0){ $deduccion=true;}
            if($datos->infonavit>0){ $infonavit=true;}
            if($datos->joyeria>0){ $joyeria=true;}
            if($datos->prestamo>0){ $prestamo=true;}
        } ?>

        <br>
        <table  class="table table-striped">
            <tr class="active">
                <th>Nombre</th>
                <th>Hrs</th>
                <th>Sueldo</th>
                <?php if($comision==true){ ?>
                    <th>% Venta</th>
                    <th>Comision</th>
                <?php }
                if($bono==true){ ?>
                    <th>Bono</th>
                <?php } ?>
                <th>Ahorro</th>
                <?php if($joyeria==true){ ?>
                    <th>Joyeria</th>
                <?php }
                if($prestamo==true){ ?>
                    <th>Prestamo</th>
                <?php }
                if($infonavit==true){ ?>
                    <th>Infonavit</th>
                <?php }
                if($deduccion==true){ ?>
                    <th>Deduccion</th>
                <?php } ?>
                <th>ISR</th>
                <th>Extra</th>
                <th>Sueldo Final</th>
                <th>Firma</th>
            </tr>
            <?php $contador=1;
            foreach($sucursal_capturada as $reg):
                if($reg["empleado"]["tarjeta"]==true)
                {
                    ?><tr class="hidden-print">
                <?php }
                else {
                     ?> <tr>
                 <?php } ?>
                <td class="hidden-print"><?= $this->Html->link($reg->empleado->nombre, ['controller'=>'Empleados','action' => 'editar', 'id' => $reg->empleado->id],['target'=>'_blank']) ?></td>
                <td class="visible-print-block"><?= $reg->empleado->ncompleto ?></td>
                <td><?= $horas=Horas($reg->horas); ?></td>
                <td><?= $this->Number->currency($reg->sueldo) ?></td>
                <?php if($comision==true){ ?>
                    <th><?= $reg->empleado->porcentaje_comision ?></th> 
                    <td><?= $this->Number->currency($reg->comision) ?></td>
                <?php }
                if($bono==true){ ?>
                    <td><?= $this->Number->currency($reg->bono) ?></td>
                <?php } ?>
                <td><?= $this->Number->currency($reg->ahorro_cantidad) ?></td>
                <?php if($joyeria==true){ ?>
                    <td><?= $this->Number->currency($reg->joyeria) ?></td>
                <?php }
                if($prestamo==true){ ?>
                    <td><?= $this->Number->currency($reg->prestamo) ?></td>
                <?php }
                if($infonavit==true){ ?>
                    <td><?= $this->Number->currency($reg->infonavit) ?></td>
                <?php }
                if($deduccion==true){ ?>
                    <td><?= $this->Number->currency($reg->deduccion) ?></td>
                <?php } ?>
                <td><?= $this->Number->currency($reg->isr) ?></td>
                <td><?= $this->Number->currency($reg->extra+$reg->pago_extras) ?></td>
                <th><?= $this->Number->currency($reg->sueldo_final) ?></th>
                <th width="110px"></th>
               <th class="hidden-print" style="min-width: 25px" >
                    <?=$this->Html->link( $this->Html->image('delete.png',['width'=>"10px"]), array('controller'=>'Nominas','action'=>'eliminar','id'=>$reg->id,'venta'=>$venta_semanal), array('escape'=>false)); ?>
                </th>
            <?php 
            endforeach; ?>
            </tr>
        </table>
<?php } ?>