<h2>Usuarios</h2>
<?php if($usuario->admin): ?><h4><?=$this->Html->link('Nuevo',['controller' =>'Usuarios','action' => 'nuevo']); ?></h4> <?php endif; ?>
<br>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2 ">
        <table  class="table table-striped">
                <tr class="active">
                    <th>#</th>
                    <th>Nombre</th>
                    <th>ID</th>
                    <th>Tipo Usuario</th>
                    <th colspan="2"></th>
                </tr>

                <?php 
                $contador=1;
                foreach ($usuarios as $usuario):
                $tipo=($usuario->admin)? "Admin" : ""; ?>
                    <tr>
                        <td><?= $contador ?></td>
                        <td><?= $usuario->nombre ?></td>
                        <td><b><?= $usuario->id ?></b></td>
                        <td><?= $tipo ?></td>
                        <td><?= $this->Html->link('Editar', ['action' => 'editar', 'id' => $usuario->id]) ?></td>
                        <td><?= $this->Html->link('Eliminar', ['action' => 'eliminar', 'id' => $usuario->id]) ?></td>
                    </tr>
                <?php
                    $contador++;
                endforeach; ?>
                
        </table>
    </div>
</div>