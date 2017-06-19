<h2>Empleados</h2>
<?php if($usuario->admin): ?><h4><?=$this->Html->link('Nuevo',['controller' =>'Empleados','action' => 'nuevo']); ?></h4> <?php endif; ?>
<br>
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
                    <th>Descanso</th>
                    <th>Dia Extra</th>
                    <th>Tipo Extra</th>
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
                        <td><?= $empleado->desc() ?></td>
                        <td><?= $empleado->diaextra() ?></td>
                        <td><?= $empleado->tipoextra() ?></td>
                        <td><?= $this->Html->link('Editar', ['action' => 'editar', 'id' => $empleado->id]) ?></td>
                        <td><?= $this->Html->link('Eliminar', ['action' => 'eliminar', 'id' => $empleado->id]) ?></td>
                    </tr>
                <?php
                    $contador++;
                endforeach; ?>
                
        </table>
    </div>
</div>