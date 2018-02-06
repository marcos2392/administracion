<?= $this->Form->create($cobrador, ['class' => 'form-horizontal disable', 'id' => 'forma_crear_cobrador', 'autocomplete' => "off"]) ?>
	
	<div class="form-inline">
		<?= $this->Form->label('nombre', 'Nombre: ', ['class' => ' control-label col-md-1']) ?>
		<div>
			<?= $this->Form->text('nombre', ['class' => 'focus form-control col-md-5']) ?>
		</div>
	</div>
	<br><br><br>
	<div>
        <?= $this->Form->checkbox('checkbox_empleado',['class' => 'col-md-offset-4']); ?>
        <?= $this->Form->label('empleado', 'Empleado (Seleccionar si el cobrador tendra nomina)') ?>
    </div><br><br>
	
	<?php
		$i=0;
		foreach($cobranzas as $cobranza)
		{
			$cobranza_cobrador=[];
			
			if($cobrador->id!=null)
			{
				$cobranza_cobrador = $cobrador->tieneCobranza($cobranza->id);
			} ?>
			 
			<div class="form-inline col-md-offset-1">
				<label class="custom-control custom-checkbox">
				  <input type="checkbox" <?php if ($cobranza_cobrador) echo 'checked'; ?> class="custom-control-input checkbox_cobranza" data-target=<?= "cobranza_".$cobranza->id ?> name=<?= "cobranza_".$cobranza->id ?>>
				  <span><?= $cobranza->descripcion ?></span>
				  <?= $this->Form->text('cobranzas_cobradores['.$i.'].porcentaje_comision',['class'=>($cobranza_cobrador ? '' : 'hidden').' cobranza_'.$cobranza->id ,'disabled'=>!$cobranza_cobrador, 'value'=> $cobranza_cobrador ? $cobranza_cobrador->porcentaje_comision : "" ]) ?>
				</label>
			</div>

			<?= $this->Form->hidden('cobranzas_cobradores['.$i.'].cobranza_id', ['value' => $cobranza->id , 'class'=>'hidden cobranza_'.$cobranza->id, 'disabled'=>!$cobranza_cobrador]) ?>

			<?php if ($cobranza_cobrador): ?>
				<?= $this->Form->hidden('cobranzas_cobradores['.$i.'].id', ['value' => $cobranza_cobrador->id , 'class'=>'hidden cobranza_'.$cobranza->id, 'disabled'=>!$cobranza_cobrador]) ?>
			<?php endif; ?>

		<?php $i++; }
	?>
	<br><br>
	<div class="form-group">
		<div class="col-md-3 col-md-offset-4">
			<?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
<?= $this->Form->end() ?>