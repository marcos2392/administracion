<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_corte', 'autocomplete' => "off"]) ?>

	<ol class="breadcrumb center hidden-print">
        <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
    </ol>

	<br>
	<table>
		<tr>
			<td width="50%">
				<table class="table table-striped">
				<?php
					foreach($cobranzas as $cobranza)
					{ if($cobranza["cobranza"]["nombre"]!='nomina'){?> 
					    <tr>
					    	 <td align="left"><?= $this->Form->label($cobranza["cobranza"]["descripcion"], $cobranza["cobranza"]["descripcion"],['class' => 'control-label']) ?></td>
					    	 <td width="25%"><?= $this->Form->Number('cobranza['.$cobranza["cobranza"]["nombre"].']['.$cobranza["id"].']', ['class' => 'focus form-control corte','value'=>$totales[$cobranza["cobranza"]["nombre"]], 'step'=>'any','data-porcentaje'=>$cobranza["porcentaje_comision"],'id'=>$cobranza["cobranza"]["id"],['class' => 'col-md-1']]) ?></td>
					    	 <td><?= $this->Form->label('porcentaje', '% '.$cobranza["porcentaje_comision"]*100,['class' => 'control-label']) ?></td>
					    </tr>
					  <?php } ?>
				<?php }  ?>
					<tr>
						<td><?= $this->Form->label('folios','Folios',['class' => ' control-label']) ?></td>
						<td><?= $this->Form->text('folios', ['class' => 'focus form-control','id'=>'folios']) ?></td>
					</tr>
					<tr align="center">
						<td><?= $this->Form->label('extra','Extra',['class' => 'control-label']) ?></td>
						<td><?= $this->Form->Number('extra', ['class' => 'focus form-control corte','id'=>'extra','value'=>0]) ?></td>
					</tr>
				</table>
			</td>
			<td>
				<td width="5%"></td>
				<td>
				<table class="table">
				    <tr>
			    	 <td><?= $this->Form->label('suma_cobranzas','Suma Cobranzas', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('suma_cobranzas', ['class' => 'focus form-control cobranzas', 'readonly'=>'readonly']) ?></td>
				    </tr>
				    <tr>
			    	 <td><?= $this->Form->label('cobranza_entregada','Cobranza Entregado', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('cobranza_entregada', ['class' => 'focus form-control cobranza_entregado', 'readonly'=>'readonly']) ?></td>
				    </tr>
				    <tr>
			    	 <td><?= $this->Form->label('suma_comisiones','Suma Comisiones', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('suma_comisiones', ['class' => 'focus form-control comisiones', 'readonly'=>'readonly']) ?></td>
				    </tr>
				    <?php if(isset($totales["nomina"])) { ?>
					    <tr>
				    	 <td><?= $this->Form->label('nomina','Nomina', ['class' => 'control-label']) ?></td>
				    	 <td><?= $this->Form->text('nomina', ['class' => 'focus form-control nomina','value'=>$totales["nomina"], 'readonly'=>'readonly']) ?></td>
					    </tr>
					<?php } ?>
				    <tr>
			    	 <td><?= $this->Form->label('extras','Extra', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('extras', ['class' => 'focus form-control extras', 'readonly'=>'readonly']) ?></td>
				    </tr>
				    <tr>
			    	 <td><?= $this->Form->label('ingresos','Dinero a Entregar', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('ingreso', ['class' => 'focus form-control ingreso', 'readonly'=>'readonly']) ?></td>
				    </tr>
				</table>
				</td>
			</td>
		</tr>
	</table>

	<br>
	<?= $this->Form->hidden('cobrador', ['value' => $cobrador]) ?>
	<div class="form-group">
		<div class="col-md-3 col-md-offset-4 hidden-print">
			<?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
</div>

<?= $this->Form->end() ?>