<ol class="breadcrumb center hidden-print">
	<?php if($usuario->checador or $usuario->super_admin){ ?>
		<li><?= $this->Html->link('Checador', ['controller' =>'Checador','action' => 'reporte','menu'=>'menu_reportes']); ?></li>
	<?php } ?>
	<?php if($usuario->movimientos_caja or $usuario->super_admin){ ?>
		<li><?= $this->Html->link('Movimientos de Caja', ['controller' =>'Reportes','action' => 'caja','menu'=>'menu_reportes']); ?></li>
	<?php } ?>
	<?php if($usuario->proveedores or $usuario->super_admin){ ?>
		<li><?= $this->Html->link('Movimientos Proveedores', ['controller' =>'Reportes','action' => 'movimientos_proveedores','menu'=>'menu_reportes']); ?></li>
		<li><?= $this->Html->link('Saldos Proveedores', ['controller' =>'Reportes','action' => 'saldos_proveedores','menu'=>'menu_reportes']); ?></li>
	<?php } ?>
	<?php if($usuario->reparaciones or $usuario->super_admin){ ?>
		<li><?= $this->Html->link('Reparaciones', ['controller' =>'Reportes','action' => 'reparaciones','menu'=>'menu_reportes']); ?></li>
	<?php } ?>
	
</ol>