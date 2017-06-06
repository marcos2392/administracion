<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_crear_sucursal', 'autocomplete' => "off"]) ?>
<div class="form-group">
    <?= $this->Form->label('nombre', 'Nombre: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('nombre', ['class' => 'focus form-control', 'value' => $sucursal->nombre]) ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label('comision', 'Comision: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('comision', ['class' => 'focus form-control', 'value' => ($sucursal->comision==false)? 0 : 1]) ?>
    </div>
    <div class="col-md-6">
        <span class="help-block">0=N/A, 1=Aplica</span>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label('bono', 'Bono: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('bono', ['class' => 'focus form-control', 'value' => ($sucursal->bono==false)? 0 : 1]) ?>
    </div>
    <div class="col-md-6">
        <span class="help-block">0=N/A, 1=Aplica</span>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label('cantidad_bono', 'Cantidad Bono: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('cantidad_bono', ['class' => 'focus form-control', 'value' => $sucursal->cantidad_bono]) ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label('venta_minima', 'Venta Minima: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('venta_minima', ['class' => 'focus form-control', 'value' => ($sucursal->minimo_venta==false)? 0 : $sucursal->minimo_venta]) ?>
    </div>
    <div class="col-md-6">
        <span class="help-block">0=N/A, 1=Aplica</span>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label('cantidad_venta_minima', 'Cantidad Venta Minima: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('cantidad_venta_minima', ['class' => 'focus form-control', 'value' => $sucursal->cantidad_minima_venta]) ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label('comision_venta', 'Comision % Venta: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('comision_venta', ['class' => 'focus form-control', 'value' => ($sucursal->comision_empleados==false)? 0 : 1]) ?>
    </div>
    <div class="col-md-6">
        <span class="help-block">0=N/A, 1=Aplica</span>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label('porcentaje_venta', 'Porcentaje Venta: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('porcentaje_venta', ['class' => 'focus form-control', 'value' => $sucursal->porcentaje_comision_empleados]) ?>
    </div>
</div>
<?php if(isset($sucursales_sistema)){ ?>
<div class="form-group">
    <?= $this->Form->label('sucursal_sistema', 'Sucursal Sistema: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->select('sucursal_sistema', $this->Select->options($sucursales_sistema, 'id', 'nombre', ['blank' => ['0' => '']]), ['class' => 'form-control chosen']) ?>
    </div>
    <div class="col-md-7">
        <span class="help-block">Seleccionar Sucursal</span>
    </div>
</div>
<?php } ?>
<div class="form-group">
    <?= $this->Form->label('activo', 'Activo: ', ['class' => 'col-md-2 control-label']) ?>
    <div class="col-md-3">
        <?= $this->Form->text('activo', ['class' => 'focus form-control', 'value' => ($sucursal->status==false)? 1 : $sucursal->status]) ?>
    </div>
    <div class="col-md-6">
        <span class="help-block">0=Inactivo, 1=Activo</span>
    </div>
</div>
<div class="form-group">
    <div class="col-md-3 col-md-offset-2">
        <?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?= $this->Form->end() ?>

