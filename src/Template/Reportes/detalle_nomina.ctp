<?php if($nomina!=[]){ ?>
<div class="row">
    <div class="col-sm-14 ">

        <h4><b>Sucursal: </b><?= $sucursal_info->nombre ?></h4>
        <h4><b>Fecha: </b><?= date("d-M-Y",strtotime($fecha_inicio))." / ".date("d-M-Y",strtotime($fecha_fin)) ?></h4>
        <h4><b>Venta Sucursal: </b><?= $this->Number->currency($venta_sucursal) ?></h4>

        <ol class="breadcrumb center hidden-print">
            <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
        </ol>
        <br>
        <table  class="table table-striped">
            <tr class="active">
                <th>Nombre</th>
                <th>Hrs</th>
                <th>Sueldo</th>
                <th>% Venta</th>
                <th>Comision</th>
                <th>Bono</th>
                <th>Joyeria</th>
                <th>Prestamo</th>
                <th>Infonavit</th>
                <th>Deduccion</th>
                <th>ISR</th>
                <th>Extra</th>
                <th>Sueldo Final</th>
            </tr>
            <?php $contador=1; $total_nomina=0;
            foreach($nomina as $reg):?>
                <tr>
                <td><?= $reg->empleado->ncompleto ?></td>
                <td><?= $horas=Horas($reg->horas); ?></td>
                <td><?= $this->Number->currency($reg->sueldo) ?></td>
                <th><?= $reg->empleado->porcentaje_comision ?></th> 
                <td><?= $this->Number->currency($reg->comision) ?></td>
                <td><?= $this->Number->currency($reg->bono) ?></td>
                <td><?= $this->Number->currency($reg->joyeria) ?></td>
                <td><?= $this->Number->currency($reg->prestamo) ?></td>
                <td><?= $this->Number->currency($reg->infonavit) ?></td>
                <td><?= $this->Number->currency($reg->deduccion) ?></td>
                <td><?= $this->Number->currency($reg->isr) ?></td>
                <td><?= $this->Number->currency($reg->extra+$reg->pago_extras) ?></td>
                <th><?= $this->Number->currency($reg->sueldo_final) ?></th>
            <?php
            endforeach; ?>
            </tr>
        </table>
    </div>
</div>

<?php } ?>