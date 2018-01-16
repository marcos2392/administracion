<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_crear_empleado', 'autocomplete' => "off"]) ?>
<div class="form-group">
	<?= $this->Form->label('nombre', 'Nombre: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('nombre', ['class' => 'focus form-control', 'value' => $empleado->nombre]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('apellidos', 'Apellidos: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('apellidos', ['class' => 'focus form-control', 'value' => $empleado->apellidos]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('sueldo', 'Sueldo: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('sueldo', ['class' => 'focus form-control', 'value' => $empleado->sueldo]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('bono', 'Bono Empleado: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('bono', ['class' => 'focus form-control', 'value' => $bono=($empleado->bono==null)?0 :$empleado->bono]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('porcentaje', 'Porcentaje comision: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('porcentaje', ['class' => 'focus form-control', 'value' => $porcentaje=($empleado->porcentaje_comision==null)?0 :$empleado->porcentaje_comision ]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('ahorro', 'Ahorro', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('ahorro', ['class' => 'focus form-control', 'value' => $ahorro=($empleado->ahorro==null)?0 :$empleado->ahorro]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('ahorro_cantidad', 'Cantidad Ahorro: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('ahorro_cantidad', ['class' => 'focus form-control', 'value' => $ahorro_cantidad=($empleado->ahorro_cantidad==null)?0 :$empleado->ahorro_cantidad]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('infonavit', 'Infonavit', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('infonavit', ['class' => 'focus form-control', 'value' => $infonavit=($empleado->infonavit==null)?0 :$empleado->infonavit]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('tarjeta', 'Tarjeta', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('tarjeta', ['class' => 'focus form-control', 'value' => $tarjeta=($empleado->tarjeta==null)?0 :$empleado->tarjeta]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('cliente_id', 'ID Cliente', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('cliente_id', ['class' => 'focus form-control', 'value' => $cliente_id=($empleado->empleado_id==0)?0 :$empleado->empleado_id]) ?>
	</div>
</div>
<div class="form-group">
	<?= $this->Form->label('joyeria', 'Joyeria', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('joyeria', ['class' => 'focus form-control', 'value' => $joyeria=($empleado->joyeria==0)?0 :$empleado->joyeria ]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Sin Credito Joyeria / 1= Con Credito Joyeria</span>
    </div>
</div>
<div class="form-group">
	<?= $this->Form->label('prestamo', 'Prestamo', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->text('prestamo', ['class' => 'focus form-control', 'value' => $prestamo=($empleado->prestamo==0)?0 :$empleado->prestamo]) ?>
	</div>
	<div class="col-md-6">
        <span class="help-block">0= Sin Prestamo / 1= Con Prestamo</span>
    </div>
</div>

<?php if($empleado->toArray()!=[])
	{ ?>
		<?php if($usuario->admin): ?>
		<div class="form-group">
			<?= $this->Form->label('descanso', 'Descanso: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('descanso', ['class' => 'focus form-control', 'value' => $empleado->descanso]) ?>
			</div>
			<div class="col-md-6">
		        <span class="help-block">Dia de la semana</span>
		    </div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('entrada', 'Lunes Entrada: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('lunes entrada', ['class' => 'focus form-control', 'value' =>$entrada=($empleado->lunes_entrada!="")? $empleado->lunes_entrada->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('salida', 'Lunes Salida: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('lunes_salida', ['class' => 'focus form-control', 'value' =>$salida=($empleado->lunes_salida!="")? $empleado->lunes_salida->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('entrada', 'Martes Entrada: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('martes_entrada', ['class' => 'focus form-control', 'value' =>$entrada=($empleado->martes_entrada!="")? $empleado->martes_entrada->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('salida', 'Martes Salida: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('martes_salida', ['class' => 'focus form-control', 'value' =>$salida=($empleado->martes_salida!="")? $empleado->martes_salida->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('entrada', 'Miercoles Entrada: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('miercoles_entrada', ['class' => 'focus form-control', 'value' =>$entrada=($empleado->miercoles_entrada!="")? $empleado->miercoles_entrada->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('salida', 'Miercoles Salida: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('miercoles_salida', ['class' => 'focus form-control', 'value' =>$salida=($empleado->miercoles_salida!="")? $empleado->miercoles_salida->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('entrada', 'Jueves Entrada: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('jueves_entrada', ['class' => 'focus form-control', 'value' =>$entrada=($empleado->jueves_entrada!="")? $empleado->jueves_entrada->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('salida', 'Jueves Salida: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('jueves_salida', ['class' => 'focus form-control', 'value' =>$salida=($empleado->jueves_salida!="")? $empleado->jueves_salida->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('entrada', 'Viernes Entrada: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('viernes_entrada', ['class' => 'focus form-control', 'value' =>$entrada=($empleado->viernes_entrada!="")? $empleado->viernes_entrada->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('salida', 'Viernes Salida: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('viernes_salida', ['class' => 'focus form-control', 'value' =>$salida=($empleado->viernes_salida!="")? $empleado->viernes_salida->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('entrada', 'Sabado Entrada: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('sabado_entrada', ['class' => 'focus form-control', 'value' =>$entrada=($empleado->sabado_entrada!="")? $empleado->sabado_entrada->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('salida', 'Sabado Salida: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('sabado_salida', ['class' => 'focus form-control', 'value' =>$salida=($empleado->sabado_salida!="")? $empleado->sabado_salida->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('entrada', 'Domingo Entrada: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('domingo_entrada', ['class' => 'focus form-control', 'value' =>$entrada=($empleado->domingo_entrada!="")? $empleado->domingo_entrada->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('salida', 'Domingo Salida: ', ['class' => 'col-md-2 control-label']) ?>
			<div class="col-md-3">
				<?= $this->Form->text('domingo_salida', ['class' => 'focus form-control', 'value' =>$salida=($empleado->domingo_salida!="")? $empleado->domingo_salida->format("h:i"): "00:00" ]) ?>
			</div>
		</div>
		<?php endif;
	}

if($usuario->admin)
{ ?>
	<div class="form-group">
	<?= $this->Form->label('sucursal', 'Sucursal: ', ['class' => 'col-md-2 control-label']) ?>
		<div class="col-md-3">
			<?= $this->Form->select('sucursal', $this->Select->options($sucursales, 'id', 'nombre', ['blank' => ['' => '--Seleccionar--']]), ['value' => $sucursal, 'class' => 'form-control']) ?>
		</div>
	</div>
<?php
}
else
{ ?>
	<?= $this->Form->hidden('sucursal', ['value' => $usuario->sucursal_id]) ?>
	<div class="form-group">
		<?= $this->Form->label('sucursal', 'Sucursal: ', ['class' => 'col-md-2 control-label']) ?>
		<div class="col-md-3">
			<p class="form-control-static"><?= $usuario->nombre ?></p>
		</div>
	</div>
<?php
} ?>

<?php if(isset($clientes)){ ?>
<div class="form-group">
	<?= $this->Form->label('empleado', 'Empleado Sistema: ', ['class' => 'col-md-2 control-label']) ?>
	<div class="col-md-3">
		<?= $this->Form->select('empleado', $this->Select->options($clientes, 'id', 'nombre', ['blank' => ['0' => '']]), ['class' => 'form-control chosen']) ?>
	</div>
    <div class="col-md-7">
        <span class="help-block">Seleccionar empleado</span>
    </div>
</div>
<?php } ?>

<div class="form-group">
	<div class="col-md-3 col-md-offset-2">
		<?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
	</div>
</div>
<?= $this->Form->end() ?>