<h2>Editar Checador</h2>
<br>
<?= $this->element('forma_checador', ['url' => ['action' => 'actualizar','sucursal'=>$sucursal,'filtro'=>$filtro,'fecha_inicio'=>$desde_fecha,'fecha_termino'=>$hasta_fecha], 'submit' => 'Actualizar']) ?>