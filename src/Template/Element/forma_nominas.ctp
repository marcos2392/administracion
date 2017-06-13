<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_nominas', 'autocomplete' => "off"]) ?>
<div class="row">
    <div class="col-sm-12">
        <table  class="table table-striped">
                <tr class="active">
                    <th>Nombre</th>
                    <th>Hrs</th>
                    <th>Sueldo</th>
                    <th>Comision</th>
                    <th>Bono</th>
                    <th>Joyeria</th>
                    <th>Prestamo</th>
                    <th>Infonavit</th>
                    <th>Deduccion</th>
                    <th>Extra</th>
                </tr>
                <?php $contador=1;
                foreach($sucursal_capturada as $reg):?> 


                    <?= $this->Form->hidden('empleados['.$reg->id.'][id]', ['value' => $reg->empleados_id]) ?>
                    <?= $this->Form->hidden('empleados['.$reg->id.'][fecha_inicio]', ['value' => $reg->fecha_inicio]) ?>
                    <?= $this->Form->hidden('empleados['.$reg->id.'][fecha_fin]', ['value' => $reg->fecha_fin]) ?>
                    <?= $this->Form->hidden('empleados['.$reg->id.'][venta_sucursal]', ['value' => $venta]) ?>
                     <tr>
                     	<td><?= $reg->empleado->nombre ?></td>
                        <td width="80px"><?= $this->Form->text('empleados['.$reg->id.'][horas]', ['class' => 'focus form-control', 'value' => $horas=gethoras($reg->horas)]) ?></td>
                        <td><?= $this->Number->currency($reg->sueldo) ?></td> 
                        <td><?= $this->Number->currency($reg->comision) ?></td>
                        <td><?= $this->Number->currency($reg->bono) ?></td>
                        <td><?= $this->Number->currency($reg->joyeria) ?></td>
                        <td><?= $this->Number->currency($reg->prestamo) ?></td>
                        <td><?= $this->Number->currency($reg->infonavit) ?></td>
                        <td width="80px"><?= $this->Form->text('empleados['.$reg->id.'][deduccion]', ['class' => 'focus form-control', 'value' => $reg->deduccion]) ?></td>
                        <td width="80px"><?= $this->Form->text('empleados['.$reg->id.'][extra]', ['class' => 'focus form-control', 'value' => $reg->extra]) ?></td>
                <?php endforeach; ?>
                </tr>
        </table>
    </div>
</div>
<div class="form-group">
	<div class="col-md-3 col-md-offset-2">
		<?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
	</div>
</div>
<?= $this->Form->end() ?>