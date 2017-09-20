<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_crear_usuario', 'autocomplete' => "off"]) ?>
<div class="form-group">
	<?= $this->Form->label('nombre', 'Nombre: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('nombre', ['class' => 'focus form-control', 'value' => $user->nombre]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('usuario', 'Usuario: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('usuario', ['class' => 'focus form-control', 'value' => $user->usuario]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('password', 'Password: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('password', ['class' => 'focus form-control', 'value' => $user->password]) ?>
	</div>
</div>
<?php
	$tipo;
	$tipo=($user->tipo_usuario==1)?$tipo=1 :$tipo=0;
?>
<div class="form-group">
	<?= $this->Form->label('tipo', 'Tipo Usuario: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('tipo', ['class' => 'focus form-control', 'value' => $tipo]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Usuario Normal, 1= Administrador  </span>
    </div>
</div>
<div class="form-group">
	<?= $this->Form->label('movimientos', 'Modulo Movimientos Caja: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('caja', ['class' => 'focus form-control', 'value' => ($user->caja)? $user->caja : 0]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Usuario sin Caja, 1= Usuario con Caja </span>
    </div>
</div>
<div class="form-group">
	<?= $this->Form->label('permiso_nomina', 'Permiso Nomina: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('permiso_nomina', ['class' => 'focus form-control', 'value' => ($user->nominas)? $user->nominas : 0]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Sin Permiso, 1= Permiso  </span>
    </div>
</div>
<div class="form-group">
	<?= $this->Form->label('permiso_checador', 'Permiso Checador: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('permiso_checador', ['class' => 'focus form-control', 'value' => ($user->checador)? $user->checador : 0]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Sin Permiso, 1= Permiso </span>
    </div>
</div>
<div class="form-group">
	<?= $this->Form->label('permiso_movimientos_caja', 'Permiso Movimientos Caja: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('permiso_movimientos_caja', ['class' => 'focus form-control', 'value' => ($user->movimientos_caja)? $user->movimientos_caja : 0]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Sin Permiso, 1= Permiso </span>
    </div>
</div>
<div class="form-group">
	<?= $this->Form->label('permiso_proveedores', 'Permiso Proveedores: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('permiso_proveedores', ['class' => 'focus form-control', 'value' => ($user->proveedores)? $user->proveedores : 0]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Sin Permiso, 1= Permiso </span>
    </div>
</div>
<div class="form-group">
	<?= $this->Form->label('permiso_reparaciones', 'Permiso Reparaciones: ', ['class' => 'col-md-3 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('permiso_reparaciones', ['class' => 'focus form-control', 'value' => ($user->reparaciones)? $user->reparaciones : 0]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Sin Permiso, 1= Permiso </span>
    </div>
</div>
<div class="form-group">
	<div class="col-md-3 col-md-offset-3">
		<?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
	</div>
</div>
<?= $this->Form->end() ?>