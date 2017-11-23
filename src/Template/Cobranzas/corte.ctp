
<h3>Cobrador : <b><?= $info_cobrador->nombre ?></b></h3>
<h4>Fecha : <b><?= date("d-M-Y") ?></b></h4>
<br>
<?= $this->element('forma_corte', ['url' => ['action' => 'corte','fecha_inicio'=>$fecha_inicio,'fecha_termino'=>$fecha_termino], 'submit' => 'Finalizar']) ?>