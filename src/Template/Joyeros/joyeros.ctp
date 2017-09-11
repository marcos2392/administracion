<div class="titulo-principal">
	<h3><b>Joyeros</b></h3>
	<ul class="breadcrumb titulo-ligas">
		<li><?=$this->Html->link('Nuevo Joyero',['controller' =>'Joyeros','action' => 'nuevo']); ?></li>
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
			foreach ($joyeros as $joyero): ?>
				<tr>
					<td><?= $i+=1; ?></td>
					<td><?= $this->Html->link($joyero->nombre, ['controller' => 'Joyeros', 'action' => 'editar', 'id' => $joyero->id], ['target' => '_blank']) ?></td>
					<td><?= $this->Html->link('Eliminar', ['action' => 'eliminar', 'id' => $joyero->id]) ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>