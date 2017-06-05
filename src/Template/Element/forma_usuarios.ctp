<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_crear_usuario', 'autocomplete' => "off"]) ?>
<div class="form-group">
	<?= $this->Form->label('nombre', 'Nombre: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('nombre', ['class' => 'focus form-control', 'value' => $user->nombre]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('usuario', 'Usuario: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('usuario', ['class' => 'focus form-control', 'value' => $user->usuario]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('password', 'Password: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('password', ['class' => 'focus form-control', 'value' => $user->password]) ?>
	</div>
</div>
<?php
	$tipo;
	$tipo=($user->tipo_usuario==1)?$tipo=1 :$tipo=0;
?>
<div class="form-group">
	<?= $this->Form->label('tipo', 'Tipo Usuario: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('tipo', ['class' => 'focus form-control', 'value' => $tipo]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Usuario Normal, 1= Administrador  </span>
    </div>
</div>
<div class="form-group">
	<div class="col-md-3 col-md-offset-2">
		<?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
	</div>
</div>
<?= $this->Form->end() ?>