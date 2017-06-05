<h2>Editar Usuario</h2>
<br>
<?= $this->element('forma_usuarios', ['url' => ['action' => 'actualizar','id'=> $user->id], 'submit' => 'Actualizar']) ?>