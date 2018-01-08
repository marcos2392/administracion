
<h3>Cobrador: <b><?= $corte->cobrador_nombre ?></b></h3>
<h4>Fecha Corte: <b><?= $corte->fecha->format("d-M-Y"); ?></b></h4>
<h4>Rango Fecha Corte: <b><?= $corte->fecha_inicio->format("d-M-Y")." / ".$corte->fecha_termino->format("d-M-Y") ?></b></h4>

<br>

	<ol class="breadcrumb center hidden-print">
        <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
    </ol>

	<br><br>
	<table>
		<tr>
			<td width="50%">
				<table class="table table-striped">
				<?php
					$comisiones=0;
					foreach($detalles as $detalle)
					{  
						foreach($detalle as $det) {?> 
						    <tr>
						    	 <td align="left"><?= $this->Form->label($det->cobranza_descripcion, $det->cobranza_descripcion,['class' => 'control-label']) ?></td>
						    	 <td width="30%"><?= $this->Form->text('det['.$det->cobranza_nombre.']['.$corte->id.']', ['class' => 'focus form-control prueba','value'=>$this->Number->currency($det->cantidad), 'readonly'=>'readonly']) ?></td>
						    	 <td><?= $this->Form->label('porcentaje', '% '.$det->porcentaje_comision*100,['class' => 'control-label']) ?></td>
						    </tr>
						<?php $comisiones+=$det->comision; }}  ?>
						<tr>
							<td><?= $this->Form->label('folios','Folios',['class' => ' control-label']) ?></td>
							<td><?= $this->Form->text('folios', ['class' => 'focus form-control', 'readonly'=>'readonly','value'=>$corte->folios]) ?></td>
						</tr>
				</table>
			</td>
			<td>
				<td width="5%"></td>
				<td>
				<table class="table">
				    <tr>
			    	 <td><?= $this->Form->label('suma_cobranzas','Suma Cobranzas', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('suma_cobranzas', ['class' => 'focus form-control cobranzas', 'readonly'=>'readonly','value'=>$this->Number->currency($corte->total)]) ?></td>
				    </tr>
				    <tr>
			    	 <td><?= $this->Form->label('cobranza_entregada','Cobranza Entregado', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('cobranza_entregada', ['class' => 'focus form-control cobranza_entregado', 'readonly'=>'readonly','value'=>$this->Number->currency($corte->total_cobrador)]) ?></td>
				    </tr>
				    <tr>
			    	 <td><?= $this->Form->label('suma_comisiones','Suma Comisiones', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('suma_comisiones', ['class' => 'focus form-control comisiones', 'readonly'=>'readonly','value'=>$this->Number->currency($comisiones)]) ?></td>
				    </tr>
				    <?php if($corte->nomina!=null) { ?>
					    <tr>
				    	 <td><?= $this->Form->label('nomina','Nomina', ['class' => 'control-label']) ?></td>
				    	 <td><?= $this->Form->text('nomina', ['class' => 'focus form-control nomina','value'=>$this->Number->currency($corte->nomina), 'readonly'=>'readonly']) ?></td>
					    </tr>
					<?php } ?>
				    <tr>
			    	 <td><?= $this->Form->label('extras','Extra', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('extras', ['class' => 'focus form-control extras', 'readonly'=>'readonly','value'=>$this->Number->currency($corte->extra)]) ?></td>
				    </tr>
				    <tr>
			    	 <td><?= $this->Form->label('ingresos','Dinero a Entregar', ['class' => 'control-label']) ?></td>
			    	 <td><?= $this->Form->text('ingreso', ['class' => 'focus form-control ingreso', 'readonly'=>'readonly','value'=>$this->Number->currency($corte->ingreso_caja)]) ?></td>
				    </tr>
				</table>
				</td>
			</td>
		</tr>
	</table>
</div>

