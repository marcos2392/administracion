<?= $this->element("menu_reparaciones") ?>

<h3>Edicion Recibos Reparacion</h3>
<br><br><br>

<?php if(!empty($recibos)){ ?>
<div class="row" >
    <div class="col-sm-8 col-sm-offset-2">
        <table  class="table table-striped">
                <tr class="active">
                    <th>#</th>
                    <th>Joyero</th>
                    <th>Sucursal</th>
                    <th>Cantidad</th>
                    <th colspan="2"></th>
                </tr>

                <?php 
                $contador=1;
                foreach ($recibos as $recibo): ?>
                    <tr>
                    	<td><?= $this->Html->link($contador, ['controller' => 'Reparaciones', 'action' => 'editar', 'id' => $recibo->id], ['target' => '_self']) ?></td>
                        <td><?= $recibo->joyero->nombre ?></td>
                        <td><?= $recibo->sucursal->nombre ?></td>
                        <td><?= $this->Number->currency($recibo->cantidad) ?></td>
                        <td><?= $this->Html->link('Eliminar', ['action' => 'eliminar', 'id' => $recibo->id]) ?></td>
                    </tr>
                <?php
                    $contador++;
                endforeach; ?>
                
        </table>
    </div>
</div>

<?php } ?>