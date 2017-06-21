<h3>Nominas</h3>
<br>
<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline col-md-12">
        <div class="col-md-4 radio">
            <label>
                <input type="radio" name="filtro" value="semanal" <?php if ($filtro == "semanal") echo "checked" ?> /> Nomina Actual
            </label>
        </div>
        <br><br>
        <div class="col-md-3 radio">
            <label>
                <input type="radio" name="filtro" value="rango" <?php if ($filtro == "rango") echo "checked" ?> /> Fecha Inicio Nomina
            </label>
        </div>
        <div class="col-md-9">
            <?= $this->element('select_fecha', [
                'prefijo' => 'fecha1',
                'fecha' => $fechas['f1']
            ])
             ?>
        </div>
    </div>
    <br><br>
    <div class="form-group form-inline control-label">
        <?= $this->Form->label('sucursal', 'Sucursal:', ['class' => 'control-label col-md-1']) ?>
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

        <h4><b>Sucursal: </b><?= $sucursal_nombre ?></h4>
        <h4><b>Fecha: </b><?= $inicio_nomina," / ",$termino_nomina ?></h4>
        <h4><b>Venta Sucursal: </b><?= $this->number->currency($ventasemanal) ?></h4>

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
                <th>Extra</th>
                <th>Sueldo Final</th>
                <th>Firma</th>
            </tr>
            <?php $contador=1; $total_nomina=0;
            foreach($sucursal_capturada as $reg): ?>
                 <tr>
                    <th><?= $reg->empleado->ncompleto ?></th>
                    <td><?= $horas=gethoras($reg->horas); ?></td>
                    <td><?= $this->Number->currency($reg->sueldo) ?></td>
                    <th><?= $reg->empleado->porcentaje_comision ?></th> 
                    <td><?= $this->Number->currency($reg->comision) ?></td>
                    <td><?= $this->Number->currency($reg->bono) ?></td>
                    <td><?= $this->Number->currency($reg->joyeria) ?></td>
                    <td><?= $this->Number->currency($reg->prestamo) ?></td>
                    <td><?= $this->Number->currency($reg->infonavit) ?></td>
                    <td><?= $this->Number->currency($reg->deduccion) ?></td>
                    <td><?= $this->Number->currency($reg->extra) ?></td>
                    <th><?= $this->Number->currency($reg->sueldo_final) ?></th>
                    <th width="110px"></th>
            <?php $total_nomina+= $reg->sueldo_final;
            endforeach; ?>
            </tr>
            <tr>
                <td colspan="9"></td>
                <th><b>Total Nomina</b></th>
                <th><?= $this->Number->currency($total_nomina) ?></th>
        </table>
    </div>
</div>
<?php } ?>