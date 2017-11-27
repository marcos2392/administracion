<?= $this->element($menu) ?>

<h3>Cortes Cobradores</h3>
<br>
<?php if($cortes!=[]){ ?>
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
					<th>Ingreso Caja</th>
				</tr>
				<?php 
				$i=0;
				foreach ($cortes as $corte): //debug($corte); die; ?>
					<tr>
						<td><?= $i+=1; ?></td>
						<td><?= $corte->fecha->format('d-m-Y h:i') ?></td>
						<td><b><?= $corte->id ?></b></td>
						<!-- <td><?= $this->Html->link($corte["cobrador"]["nombre"], ['controller' => 'Reportes', 'action' => 'cortes', 'id' => $corte->id], ['target' => '_self']) ?></td> -->
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