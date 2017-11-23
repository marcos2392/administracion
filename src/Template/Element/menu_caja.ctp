<ol class="breadcrumb center hidden-print">
<?php if($usuario->movimientos_caja){ ?>
	<li><?= $this->Html->link('Movimientos', ['controller' =>'MovimientosCaja','action' => 'movimientos']); ?></li>
<?php } ?>
	<li><?= $this->Html->link('Reportes', ['controller' =>'Reportes','action' => 'caja']); ?></li>
</ol>