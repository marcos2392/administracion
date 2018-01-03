<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_nominas', 'autocomplete' => "off"]) ?>
<div class="row">
    <div class="col-sm-12">
        <table  class="table table-striped">
                <tr class="active">
                    <th>Nombre</th>
                    <th>Hrs</th>
                    <th>Sueldo</th>
                    <th>Ahorro</th>
                    <th>Comision</th>
                    <th>Bono</th>
                    <th>Joyeria</th>
                    <th>Prestamo</th>
                    <th>Infonavit</th>
                    <th>Deduccion</th>
                    <th>ISR</th>
                    <th>Extra</th>
                    <th>Pago Extras</th>
                </tr>
                <?php $contador=1;
                foreach($sucursal_capturada as $reg):?> 

                    <?= $this->Form->hidden('empleados['.$reg->id.'][id]', ['value' => $reg->empleados_id]) ?>
                    <?= $this->Form->hidden('empleados['.$reg->id.'][sueldo]', ['value' => $reg["empleado"]["sueldo"]]) ?>
                    <?= $this->Form->hidden('empleados['.$reg->id.'][fecha_inicio]', ['value' => $reg->fecha_inicio->format('Y-m-d')]) ?>
                    <?= $this->Form->hidden('empleados['.$reg->id.'][fecha_fin]', ['value' => $reg->fecha_fin->format('Y-m-d')]) ?>
                    <?= $this->Form->hidden('empleados['.$reg->id.'][venta_sucursal]', ['value' => $venta]) ?>
                    <?= $this->Form->hidden('empleados['.$reg->id.'][joyeria]', ['value' => $reg->joyeria]) ?>

                     <tr>
                     	<td><?= $reg->empleado->ncompleto ?></td>
                        <td width="80px"><?= $this->Form->text('empleados['.$reg->id.'][horas]', ['class' => 'focus form-control', 'value' => $horas=Horas($reg->horas)]) ?></td>
                        <td><?= $this->Number->currency($reg->sueldo) ?></td>
                        <td><?= $this->Number->currency($reg->ahorro_cantidad) ?></td> 
                        <td><?= $this->Number->currency($reg->comision) ?></td>
                        <td><?= $this->Number->currency($reg->bono) ?></td>
                        <td><?= $this->Number->currency($reg->joyeria) ?></td>
                        <td><?= $this->Number->currency($reg->prestamo) ?></td>
                        <td><?= $this->Number->currency($reg->infonavit) ?></td>
                        <td width="80px"><?= $this->Form->text('empleados['.$reg->id.'][deduccion]', ['class' => 'focus form-control', 'value' => $reg->deduccion]) ?></td>
                        <td width="80px"><?= $this->Form->text('empleados['.$reg->id.'][isr]', ['class' => 'focus form-control', 'value' => $reg->isr]) ?></td>
                        <td width="80px"><?= $this->Form->text('empleados['.$reg->id.'][extra]', ['class' => 'focus form-control', 'value' => $reg->extra]) ?></td>
                        <td><?= $this->Number->currency($reg->pago_extras) ?></td>
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