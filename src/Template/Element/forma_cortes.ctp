<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_cortes', 'autocomplete' => "off",'method'=>'get']) ?>
<h3>Cortes Cobradores</h3>
<br><br>
<div class="form-group form-inline col-md-12">
	<?= $this->Form->label('id', 'Cobrador: ', ['class' => 'col-md-2 control-label']) ?>

	<div class="col-lg-2">
		<?= $this->Form->select('cobrador', $this->Select->options($cobradores, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value'=>$cobrador_id,'class' => 'form-control','id'=>'cobrador_id']) ?>
	</div>
	<br><br><br><br>
	<?= $this->Form->label('id', 'Fechas Corte :  ', ['class' => 'col-md-2 control-label']) ?>
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

<div class="form-group form-inline control-label">
    <div class="col-md-3 col-md-offset-2">
		<?= $this->Form->button($submit, ['class' => 'btn btn-primary', 'id'=>'enviar']) ?>
	</div>
</div>
<br><br>
<?php if(isset($id)){ ?>
	<?= $this->Form->hidden('id', ['value' => $id]) ?>
<?php } ?>

<?= $this->Form->hidden('enviado', ['value' => true]) ?>

<?= $this->Form->end(); ?>

<?php if($cortes!=[]){ ?>
	<h4>Cobrador: <b><?=$info_cobrador->nombre ?></b></h4>
	<h4><b>Fechas de Cortes:</b> <?=date("d-M-Y",$fechas["f1"])." / ".date("d-M-Y",$fechas["f2"]) ?></h4>

	<br>
	<div class="row">
	    <div class="col-sm-12 ">
			<table class="table">
				<tr>
					<th></th>
					<th>Fecha</th>
					<th>Corte ID</th>
					<th>Cobrador</th>
					<th>Cobranza General</th>
					<th>Cobranza Sucursales</th>
					<th>Cobranza Cobrador</th>
					<th>Dinero Entregado</th>
				</tr>
				<?php 
				$i=0;
				foreach ($cortes as $corte): //debug($corte); die; ?>
					<tr>
						<td><?= $i+=1; ?></td>
						<td><?= $corte->fecha->format('d-M-Y h:i') ?></td>
						<!-- <td><?= $this->Html->link($corte->id, ['controller' => 'Reportes', 'action' => 'cortes', 'corte_id' => $corte->id], ['target' => '_self']) ?></td> -->
						<td><?= $corte->id ?></td>
						<td><?= $corte["cobrador"]["nombre"] ?></td>
						<td><?= $this->number->currency($corte->total) ?></td>
						<td><?= $this->number->currency($corte->total_sucursales) ?></td>
						<td><?= $this->number->currency($corte->total_cobrador) ?></td>
						<td><?= $this->number->currency($corte->ingreso_caja) ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
<?php } ?>