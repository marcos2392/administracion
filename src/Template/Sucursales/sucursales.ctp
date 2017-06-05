<h2>Sucursales</h2>
<h4><?=$this->Html->link('Nuevo',['controller' =>'Sucursales','action' => 'nuevo']); ?></h4>
<br>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3 ">
        <table  class="table table-striped">
                <tr class="active">
                    <th>#</th>
                    <th>Sucursal</th>
                    <th colspan="2"></th>
                </tr>

                <?php
                $contador=1;
                foreach ($sucursales as $sucursal): ?>
                    <tr>
                        <td><?= $contador ?></td>
                        <td><?= $sucursal->nombre ?></td>
                        <td><?= $this->Html->link('Editar', ['action' => 'editar', 'id' => $sucursal->id]) ?></td>
                        <td><?= $this->Html->link('Eliminar', ['action' => 'eliminar', 'id' => $sucursal->id]) ?></td>
                    </tr> 
                <?php
                    $contador++;
                 endforeach; ?>
        </table>
    </div>
</div>