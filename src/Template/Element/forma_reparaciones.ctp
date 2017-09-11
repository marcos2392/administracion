<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_reparaciones', 'autocomplete' => "off"]) ?>

<br><br>
<div class="row">
	<?= $this->Form->label('id', 'Joyero: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-lg-2">
		    <?= $this->Form->select('joyero', $this->Select->options($joyeros, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value' => $joyero, 'class' => 'form-control','id'=>'joyero']) ?>
	</div>
	<?= $this->Form->label('id', 'Sucursal: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-lg-2">
		<?= $this->Form->select('sucursal', $this->Select->options($sucursales, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value' => $sucursal, 'class' => 'form-control', 'id'=>'sucursal']) ?>
	</div>
</div>
<br><br>
<div class="form-group">
	<?= $this->Form->label('can', 'Cantidad: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-2">
		<?= $this->Form->text('cantidad', ['class' => 'focus form-control' ,'required', 'id'=>'cantidad', 'value'=>(isset($cantidad)?$cantidad:'')]) ?>
	</div>
</div>

<br>
<br>

<?php if(isset($id)){ ?>
	<?= $this->Form->hidden('id', ['value' => $id]) ?>
<?php } ?>

<div class="form-group">
	<div class="col-md-3 col-md-offset-2">
		<?= $this->Form->button($submit, ['class' => 'btn btn-primary', 'id'=>'enviar']) ?>
	</div>
</div>

<?= $this->Form->end() ?>

<!--

<input type="button" id="cargar" value="agregar">
<input type="button" id="eliminar" value="eliminar">

<br><br><br>

<div class="row col-md-5">
	<table  class="table table-striped" id="tabla">
	    <tr>
	        <th>Joyero</th>
	        <th>Sucursal</th>
	        <th>Cantidad</th>
	    </tr>
	</table>
</div>

-->
