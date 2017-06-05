<h2>Editar Empleado</h2>
<br>
<?= $this->element('forma_empleados', ['url' => ['action' => 'actualizar','id'=> $empleado->id], 'submit' => 'Actualizar']) ?>