<?= $this->Form->day($prefijo . '_dia', [
	'class' => 'form-control',
	'empty' => false,
	'value' => date('d', $fecha)
]) ?>
<?= $this->Form->month($prefijo . '_mes', [
	'class' => 'form-control',
	'monthNames' => [
		'01' => 'Enero',
		'02' => 'Febrero',
		'03' => 'Marzo',
		'04' => 'Abril',
		'05' => 'Mayo',
		'06' => 'Junio',
		'07' => 'Julio',
		'08' => 'Agosto',
		'09' => 'Septiembre',
		'10' => 'Octubre',
		'11' => 'Noviembre',
		'12' => 'Diciembre'
	],
	'empty' => false,
	'value' => date('m', $fecha)
]) ?>
<?= $this->Form->year($prefijo . '_anio', [
	'class' => 'form-control',
	'minYear' => 2017,
	'maxYear' => date('Y'),
	'empty' => false,
	'value' => date('Y', $fecha)
]) ?>