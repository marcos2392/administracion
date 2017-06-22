<h3>Reportes Semanales</h3>

<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline col-md-12">
        <div class="col-md-4 radio">
            <label>
                <input type="radio" name="filtro" value="semanal" <?php if ($filtro == "semanal") echo "checked" ?> /> Semana Actual
            </label>
        </div>
        <br><br>
        <div class="col-md-3 radio">
            <label>
                <input type="radio" name="filtro" value="rango" <?php if ($filtro == "rango") echo "checked" ?> /> Fecha Inicio Semana
            </label>
        </div>
        <div class="col-md-9">
            <?= $this->element('select_fecha', [
                'prefijo' => 'fecha1',
                'fecha' => $fechas['f1']
            ])
             ?>
        </div>
    </div>
    <br><br>
    <div class="form-group form-inline control-label">
        <?= $this->Form->label('sucursal', 'Sucursal:', ['class' => 'control-label col-md-1']) ?>
        <div class="col-md-2">
            <?= $this->Form->select('sucursal', $this->Select->options($sucursales, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value' => $sucursal, 'class' => 'form-control']) ?>
        </div>
    </div>
    <br>
    <div class="form-group">
        <div class="col-md-offset-1 col-md-11">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>
     <?= $this->Form->hidden('enviado', ['value' => true]) ?>
<?= $this->Form->end() ?>