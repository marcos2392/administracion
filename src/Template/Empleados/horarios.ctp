<?= $this->element("menu_checador") ?>

<h3><b>Edicion Horarios</b></h3>
<br>
<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline control-label">
        <?= $this->Form->label('sucursal', 'Sucursal:', ['class' => 'control-label col-md-1']) ?>
        <div class="col-md-2">
            <?= $this->Form->select('sucursal', $this->Select->options($sucursales, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value' => $sucursal, 'class' => 'form-control']) ?>
        </div>
        <div class=" col-md-1">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>

     <?= $this->Form->hidden('enviado', ['value' => true]) ?>
<?= $this->Form->end() ?>