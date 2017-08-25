<?= $this->element("menu_caja") ?>

<?php foreach($usuarios_caja as $usuarios=>$cantidad)
{
	?>
	<h3>Cantidad Dinero en Caja <?php if($usuario->admin){ ?> (<b><?= $usuarios ?></b>) <?php } ?> : <b><?= $this->number->currency($cantidad) ?></b> </h3> 
	<?php
}
