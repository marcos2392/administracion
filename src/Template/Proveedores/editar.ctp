<h2>Editar Proveedor</h2>
<br>
<?= $this->element('forma_proveedores', ['url' => ['action' => 'actualizar','id'=> $proveedores->id], 'submit' => 'Actualizar']) ?>