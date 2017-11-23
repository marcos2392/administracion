<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_cobranzas', 'autocomplete' => "off",'method'=>'get']) ?>

<br><br>
<div class="form-group form-inline col-md-12">
	<?= $this->Form->label('id', 'Cobrador: ', ['class' => 'col-md-2 control-label']) ?>

	<div class="col-lg-2">
		<?= $this->Form->select('cobrador', $this->Select->options($cobradores, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value'=>$cobrador,'class' => 'form-control','id'=>'cobrador']) ?>
	</div>
	<br><br><br><br>
	<?= $this->Form->label('id', 'Fechas: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="form-group ">
    
    <?= $this->element('select_fecha', [
        'prefijo' => 'fecha1',
        'fecha' => $fechas['f1']
    ]) ?>
    -
    <?= $this->element('select_fecha', [
        'prefijo' => 'fecha2',
        'fecha' => $fechas['f2']
    ]) ?>

</div>
</div>

<br><br><br><br><br><br><br>

<div class="form-group form-inline control-label">
    <div class="col-md-3 col-md-offset-3">
		<?= $this->Form->button($submit, ['class' => 'btn btn-primary', 'id'=>'enviar']) ?>
	</div>
</div>

<?php if(isset($id)){ ?>
	<?= $this->Form->hidden('id', ['value' => $id]) ?>
<?php } ?>

<?= $this->Form->hidden('enviado', ['value' => true]) ?>

<?= $this->Form->end();
