<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_corte', 'autocomplete' => "off"]) ?>

	<ol class="breadcrumb center hidden-print">
        <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
    </ol>

<div class="col-md-6">
	<br>
	<?php
		foreach($cobranzas as $cobranza)
		{ //debug($cobranzas); die;?> 
			
			<div class="form-group">
			
					<?= $this->Form->label($cobranza["cobranza"]["descripcion"], $cobranza["cobranza"]["descripcion"],['class' => 'col-md-4 control-label']) ?>
					
					<div class="col-md-3">
						<?= $this->Form->text('cobranza['.$cobranza["cobranza"]["nombre"].']['.$cobranza["id"].']', ['class' => 'focus form-control prueba','value'=>$totales[$cobranza["cobranza"]["nombre"]],'data-porcentaje'=>$cobranza["porcentaje_comision"],'id'=>$cobranza["cobranza"]["id"],['class' => 'col-md-1']]) ?>
					</div>
					<?= $this->Form->label('porcentaje', '% '.$cobranza["porcentaje_comision"],['class' => 'col-md-2 control-label']) ?>
					
			</div>	
		<?php } ?>
		<div class="form-group">
			<?= $this->Form->label('folios','Folios',['class' => 'col-md-4 control-label']) ?>
						
			<div class="col-md-4">
				<?= $this->Form->text('folios', ['class' => 'focus form-control']) ?>
			</div>
			<br><br><br>
			<?= $this->Form->label('extra','Extra',['class' => 'col-md-4 control-label']) ?>
						
			<div class="col-md-2">
				<?= $this->Form->text('extra', ['class' => 'focus form-control prueba','id'=>'extra','value'=>0]) ?>
			</div>
		</div>

</div>
<div class="col-md-6">

	<div class="form-group">
		<?= $this->Form->label('suma_cobranzas','Suma Cobranzas', ['class' => 'col-md-4 control-label']) ?>
		<div class="col-md-3">
			<?= $this->Form->text('suma_cobranzas', ['class' => 'focus form-control cobranzas', 'readonly'=>'readonly']) ?>
		</div>
	</div>
	<div class="form-group">
		<?= $this->Form->label('cobranza_entregada','Cobranza Entregado', ['class' => 'col-md-4 control-label']) ?>
		<div class="col-md-3">
			<?= $this->Form->text('cobranza_entregada', ['class' => 'focus form-control cobranza_entregado', 'readonly'=>'readonly']) ?>
		</div>
	</div>
	<div class="form-group">
		<?= $this->Form->label('suma_comisiones','Suma Comisiones', ['class' => 'col-md-4 control-label']) ?>
		<div class="col-md-3">
			<?= $this->Form->text('suma_comisiones', ['class' => 'focus form-control comisiones', 'readonly'=>'readonly']) ?>
		</div>
	</div>
	<div class="form-group">
		<?= $this->Form->label('extras','Extra', ['class' => 'col-md-4 control-label']) ?>
		<div class="col-md-3">
			<?= $this->Form->text('extras', ['class' => 'focus form-control extras', 'readonly'=>'readonly']) ?>
		</div>
	</div>
	<br>
	<div class="form-group">
		<?= $this->Form->label('ingresos','Ingreso a Caja', ['class' => 'col-md-4 control-label']) ?>
		<div class="col-md-3">
			<?= $this->Form->text('ingreso', ['class' => 'focus form-control ingreso', 'readonly'=>'readonly']) ?>
		</div>
	</div>
	<br>
	<?= $this->Form->hidden('cobrador', ['value' => $cobrador]) ?>
	<div class="form-group">
		<div class="col-md-3 col-md-offset-4 hidden-print">
			<?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
</div>

<?= $this->Form->end() ?>