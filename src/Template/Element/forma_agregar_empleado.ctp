
<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_cobranzas', 'autocomplete' => "off",'method'=>'get']) ?>
	<br><br>

	<div class="form-group form-inline col-md-12">
		<?= $this->Form->label('id', 'Empleado: ', ['class' => 'col-md-1 control-label']) ?>
		<div class="col-lg-2">
			<?= $this->Form->select('empleado', $this->Select->options($empleados_sin_nomina, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value'=>$empleado,'class' => 'form-control','id'=>'empleado']) ?>
		</div>
	</div>

	<br><br>

	<div class="form-group form-inline control-label">
	    <div class="col-md-3 col-md-offset-3">
			<?= $this->Form->button($submit, ['class' => 'btn btn-primary', 'id'=>'enviar']) ?>
		</div>
	</div>
	<?= $this->Form->hidden('enviado', ['value' => true]) ?>
	<?= $this->Form->hidden('inicio', ['value' => $fecha_inicio]) ?>
	<?= $this->Form->hidden('termino', ['value' => $fecha_termino]) ?>
	<?= $this->Form->hidden('sucursal', ['value' => $sucursal]) ?>
	<?= $this->Form->hidden('venta_id', ['value' => $venta_id]) ?>

<?= $this->Form->end();