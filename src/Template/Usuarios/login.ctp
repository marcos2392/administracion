<h3>Iniciar sesión</h3>

<?= $this->Form->create(false, ['class' => 'form-horizontal']) ?>

<div class="form-group">
    <?= $this->Form->label('usuario', 'Usuario', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-5">
        <?= $this->Form->text('usuario', ['class' => 'form-control focus']) ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label('password', 'Contraseña', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-5">
        <?= $this->Form->password('password', ['class' => 'form-control']) ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?= $this->Form->submit('Entrar', ['class' => 'btn btn-default']) ?>
    </div>
</div>

<?= $this->Form->end() ?>