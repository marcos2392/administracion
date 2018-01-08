<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_movimientos_caja', 'autocomplete' => "off"]) ?>

<br><br>
<div class="form-group">
	<?= $this->Form->label('id', 'Tipo Movimiento: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<select class="selectpicker" name="tipo_movimiento" id='tipo' class='hidden' required>
		    <?php
		    	if(isset($movimiento))
		    	{
		    		echo '<option value="'.$movimiento->tipo_movimiento.'">' .$movimiento->tipo_movimiento. '</option>';
		    	}
		    	else
		    	{
		    		echo '<option value="">--Seleccionar--</option>';
		    	}  

		        echo '<option value="ingreso">Ingreso</option>';
		        echo '<option value="gasto">Gasto</option>';
		    ?>
		</select>
	</div>
</div>
<br>
<div class="form-group">
	<?= $this->Form->label('descripcion', 'Descripcion: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-7">
		<?= $this->Form->text('descripcion', ['class' => 'focus form-control' ,'required','value'=>(isset($movimiento)?$movimiento->descripcion:'')]) ?>
	</div>
</div>
<br>
<div class="form-group">
	<?= $this->Form->label('cantidad', 'Cantidad: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-2">
		<?= $this->Form->number('cantidad', ['class' => 'focus form-control' ,'required', 'value'=>(isset($movimiento)?$movimiento->cantidad:''), 'step'=>'any']) ?>
	</div>
</div>
<br>
<div class="form-group">
	<div class="col-md-3 col-md-offset-2">
		<?= $this->Form->button($submit, ['class' => 'btn btn-primary'])?>
	</div>
</div>

<?= $this->Form->hidden('id', ['value' => (isset($movimiento)?$movimiento->id:'')]) ?>
<?= $this->Form->end() ?>