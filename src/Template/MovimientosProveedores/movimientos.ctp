<?= $this->element("menu_proveedores") ?>

<h3>Movimientos Proveedores</h3>

<?= $this->element('forma_movimientos_proveedores', ['url' => ['action' => 'movimientos'], 'submit' => 'Guardar']) ?>