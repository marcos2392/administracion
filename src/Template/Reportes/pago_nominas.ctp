<!--<?= $this->element("menu_nominas") ?>
<h3>Pago Nominas</h3>
<br>

<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline col-md-12">
        <div class="col-md-4 radio">
            <label>
                <input type="radio" name="filtro" value="semanal" <?php if ($filtro == "semanal") echo "checked" ?> /> Nomina Actual
            </label>
        </div>
        <br><br>
        <div class="col-md-3 radio">
            <label>
                <input type="radio" name="filtro" value="rango" <?php if ($filtro == "rango") echo "checked" ?> /> Fecha Inicio Nomina
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
        <div class=" col-md-1">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>

     <?= $this->Form->hidden('enviado', ['value' => true]) ?>
<?= $this->Form->end() ?> -->