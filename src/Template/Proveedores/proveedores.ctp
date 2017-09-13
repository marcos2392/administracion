<div class="titulo-principal">
	<h3><b>Proveedores</b></h3>
	<ul class="breadcrumb titulo-ligas">
		<li><?=$this->Html->link('Nuevo Proveedor',['controller' =>'Proveedores','action' => 'nuevo']); ?></li>
	</ul>
</div>

<?php if($proveedores!=[]){ ?>
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
				foreach ($proveedores as $proveedor): ?>
					<tr>
						<td><?= $i+=1; ?></td>
						<td><?= $this->Html->link($proveedor->nombre, ['controller' => 'Proveedores', 'action' => 'editar', 'id' => $proveedor->id], ['target' => '_self']) ?></td>
						<td><?= $this->Html->link('Eliminar', ['action' => 'eliminar', 'id' => $proveedor->id]) ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
<?php } ?>