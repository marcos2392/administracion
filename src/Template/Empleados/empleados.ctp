<h2>Empleados</h2>
<?php if($usuario->admin): ?><h4><?=$this->Html->link('Nuevo',['controller' =>'Empleados','action' => 'nuevo']); ?></h4> <?php endif; ?>
<br>

    <?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline control-label">
        <h4><?= $this->Form->label('sucursal', 'Sucursal:', ['class' => 'control-label col-md-1']) ?></h4>
        <div class="col-md-2">
            <?= $this->Form->select('sucursal', $this->Select->options($sucursales, 'id', 'nombre', ['blank' => ['0' => 'Todos']]), ['value' => $sucursal, 'class' => 'form-control']) ?>
        </div>
        <div class=" col-md-1">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>

     <?= $this->Form->hidden('enviado', ['value' => true]) ?>
<?= $this->Form->end() ?>

<br><br>
<?php if($empleados!=[]){ ?>
<div class="row">
    <div class="col-sm-12 ">
        <table  class="table table-striped">
                <tr class="active">
                    <th>#</th>
                    <th>Nombre</th>
                    <th>ID</th>
                    <th>Sucursal</th>
                    <th>Sueldo</th>
                    <th>% Comision</th>
                    <th>Infonavit</th>
                    <th>Tipo Pago</th>
                    <th colspan="2"></th>
                </tr>

                <?php 
                $contador=1;
                foreach ($empleados as $empleado): ?>
                    <tr>
                        <td><?= $contador ?></td>
                        <td><?= $empleado->ncompleto ?></td>
                        <td><b><?= $empleado->id ?></b></td>
                        <td><?= $empleado->sucursal->nombre ?></td>
                        <td><?= $this->number->currency($empleado->sueldo) ?></td>
                        <td><?= $empleado->porcentaje_comision ?></td>
                        <td><?= $this->number->currency($empleado->infonavit) ?></td>
                        <?php $tipo_pago=($empleado->tarjeta)? "Tarjeta" : "Efectivo" ; ?>
                        <td><?= $tipo_pago ?></td>
                        <td><?= $this->Html->link('Editar', ['action' => 'editar', 'id' => $empleado->id]) ?></td>
                        <td><?= $this->Html->link('Eliminar', ['action' => 'eliminar', 'id' => $empleado->id]) ?></td>
                    </tr>
                <?php
                    $contador++;
                endforeach; ?>
                
        </table>
    </div>
</div>
<?php } ?>