<div class="titulo-principal">
	<h3><b>Cobradores</b></h3>
	<ul class="breadcrumb titulo-ligas">
		<li><?=$this->Html->link('Nuevo Cobrador',['controller' =>'Cobradores','action' => 'nuevo']); ?></li>
	</ul>
</div>

<div class="row">
    <div class="col-sm-5 col-sm-offset-3">
		<table class="table">
			<tr>
				<th></th>
				<th>Nombre</th>
				<th></th>
			</tr>
			<?php 
			$i=0;
			foreach ($cobradores as $cobrador): ?>
				<tr>
					<td><?= $i+=1; ?></td>
					<td><?= $this->Html->link($cobrador->nombre, ['controller' => 'Cobradores', 'action' => 'editar', 'id' => $cobrador->id], ['target' => '_self']) ?></td>
					<td><?= $this->Html->link('Eliminar', ['action' => 'eliminar', 'id' => $cobrador->id]) ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>