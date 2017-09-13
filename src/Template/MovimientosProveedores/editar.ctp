<?= $this->element("menu_proveedores") ?>

<h3>Editar Movimiento</h3>

<?= $this->element('forma_movimientos_proveedores', ['url' => ['action' => 'actualizar'], 'submit' => 'Actualizar']) ?>