<?= $this->element("menu_reparaciones") ?>
<h3>Reporte Reparaciones Joyeria</h3>
<br>
<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>

<div class="form-group form-inline col-md-12">
    
    <div class="col-lg-2">
        <label>
            <input type="radio" name="filtro" value="dia" <?php if ($filtro == "dia") echo "checked" ?> /> Dia
        </label>
    </div>
    <br><br>
    <div class="col-lg-3">
        <label>
            <input type="radio" name="filtro" value="rango" <?php if ($filtro == "rango") echo "checked" ?> /> Rango Fecha Reporte
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
    <br><br><br>
    <?= $this->Form->label('id', 'Joyero: ', ['class' => 'col-md-1 control-label']) ?>
    <div class="col-lg-2">
            <?= $this->Form->select('joyero', $this->Select->options($joyeros, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value' => $joyero, 'class' => 'form-control','id'=>'joyero']) ?>
    </div>
</div>
<br><br>
    <div class="form-group form-inline control-label">
        <div class=" col-md-1 ">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>

    <?= $this->Form->hidden('enviado', ['value' => true]) ?>
<?= $this->Form->end() ?>
<br><br><br>
<?php if($recibos!=[]) { ?>
<h4>Joyero: <b><?= $joyero_nombre ?></b></h4>
<?php if($filtro=='dia'){ ?><h4>Fecha: <b><?= $fecha ?></b></h4> <?php } else { ?> <h4>Fecha: <b><?= $fecha_inicio.' / '.$fecha_fin ?></b></h4> <?php } ?>
<br><br>
    <div class="row" >
        <div class="col-sm-5 col-sm-offset-3">
            <table  class="table table-striped">
                    <tr class="active">
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Cantidad</th>
                    </tr>

                    <?php 
                    $contador=1;
                    $total=0;
                    foreach ($recibos as $recibo): ?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><?= $recibo->sucursal_nombre ?></td>
                            <td><?= $this->Number->currency($recibo->cantidad) ?></td>
                        </tr>
                    <?php
                        $contador++;
                        $total+=$recibo->cantidad;
                    endforeach; ?>

                <tr class="active">
                    <th></th>
                    <th>Total: </th>
                    <th><b> <?= $this->Number->currency($total) ?></b></th>
                </tr>
                    
            </table>
        </div>
    </div>

<?php } ?>