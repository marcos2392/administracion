<h3>Sucursales</h3>
<br>
<?= $this->Form->create(false, ['class' => 'form-inline hidden-print']) ?>
	<div class="form-group">
		<?= $this->Form->label('sucursal', 'Sucursal: ', ['class' => 'col-md-4 control-label']) ?>
		<div class="col-md-3">
			<?= $this->Form->select('sucursal', $this->Select->options($sucursales, 'id', 'nombre', ['blank' => ['' => '--Seleccionar--']]), ['value' => $sucursal, 'class' => 'form-control']) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-1 col-md-11">
			<?= $this->Form->submit('Buscar', ['class' => 'btn btn-info']) ?>
		</div>
	</div>
<?= $this->Form->end() ?>
<br><br>
<?php if(isset($sucursal_capturada)){ ?>
<div class="row">
    <div class="col-sm-4 col-sm-offset-3 ">
        <table  class="table table-striped">
                <tr class="active">
                    <th>Nombre</th>
                    <th>Hrs</th>
                    <th>Sueldo</th>
                    <th>Comision</th>
                    <th>Joyeria</th>
                </tr>
                <?php $contador=1;
                foreach($sucursal_capturada as $reg): ?>
                     <tr>
                        <td><?= $reg->empleado->nombre ?></td>
                        <td><?= $reg->horas ?></td>
                        <td><?= $this->Number->currency($reg->sueldo) ?></td> 
                        <td><?= $this->Number->currency($reg->comision) ?></td>
                        <td><?= $this->Number->currency($reg->joyeria) ?></td>
                <?php endforeach; ?>
                </tr>
        </table>
    </div>
</div>
<?php } ?>