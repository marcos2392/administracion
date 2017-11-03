
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
<br><br>
<?php if(!$sucursal_capturada->isEmpty()){ ?>
<div class="row">
    <div class="col-sm-14 ">

        <h4><b>Sucursal: </b><?= $sucursal_info->nombre ?></h4>
        <h4><b>Fecha: </b><?= $inicio_nomina," / ",$termino_nomina ?></h4>
        <h4><b>Venta Sucursal: </b><?= $this->number->currency($venta_semanal) ?></h4>

        <ol class="breadcrumb center hidden-print">
            <li><?=$this->Html->link('Editar',['controller' =>'Nominas','action' => 'editar','sucursal'=>$sucursal,'inicio'=>$inicio_nomina]); ?></li>
            <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
        </ol>
        <br>
        <table  class="table table-striped">
            <tr class="active">
                <th>Nombre</th>
                <th>Hrs</th>
                <th>Sueldo</th>
                <th>% Venta</th>
                <th>Comision</th>
                <th>Bono</th>
                <th>Joyeria</th>
                <th>Prestamo</th>
                <th>Infonavit</th>
                <th>Deduccion</th>
                <th>ISR</th>
                <th>Extra</th>
                <th>Sueldo Final</th>
                <th>Firma</th>
            </tr>
            <?php $contador=1; $total_nomina=0;
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
                <th><?= $reg->empleado->porcentaje_comision ?></th> 
                <td><?= $this->Number->currency($reg->comision) ?></td>
                <td><?= $this->Number->currency($reg->bono) ?></td>
                <td><?= $this->Number->currency($reg->joyeria) ?></td>
                <td><?= $this->Number->currency($reg->prestamo) ?></td>
                <td><?= $this->Number->currency($reg->infonavit) ?></td>
                <td><?= $this->Number->currency($reg->deduccion) ?></td>
                <td><?= $this->Number->currency($reg->isr) ?></td>
                <td><?= $this->Number->currency($reg->extra+$reg->pago_extras) ?></td>
                <th><?= $this->Number->currency($reg->sueldo_final) ?></th>
                <th width="110px"></th>
               <th class="hidden-print">
                    <?=$this->Html->link( $this->Html->image('delete.png', ['class' => 'img-responsive','height' => 10, 'width' => 10]), array('controller'=>'Nominas','action'=>'eliminar','id'=>$reg->id,'venta'=>$venta_semanal), array('escape'=>false)); ?>
                </th>
            <?php 
            if($reg->empleado->tarjeta==false)
            {
                $total_nomina+= $reg->sueldo_final;
            }
            endforeach; ?>
            </tr>
            <tr> 
                <td colspan="11"></td>
                <th><b>Total Nomina</b></th>
                <th><?= $this->Number->currency($total_nomina) ?></th>
        </table>
    </div>
</div>
<?php } ?>