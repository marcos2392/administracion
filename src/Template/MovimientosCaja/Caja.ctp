<?= $this->element("menu_caja") ?>

<?php foreach($sucursales_caja as $sucursal=>$cantidad)
{
	?>
	<h3>Cantidad Dinero en Caja <?php if($usuario->admin){ ?> (<b><?= $sucursal ?></b>) <?php } ?> : <b><?= $this->number->currency($cantidad) ?></b> </h3> 
	<?php
}
