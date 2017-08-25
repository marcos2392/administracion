<?= $this->element("menu_caja") ?>
<h3>Reporte Movimientos de Caja</h3>
<br>
<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline col-md-12">

        <?php if($usuario->admin){ ?>
            <?= $this->Form->label('sucursal', 'Usuario:', ['class' => 'control-label col-md-1']) ?>
            <div class="col-md-2">
                <?= $this->Form->select('usuarios', $this->Select->options($usuarios, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value' => $usuario_caja, 'class' => 'form-control']) ?>
            </div>
            <br><br>
        <?php } ?>

        <div class="col-md-4 radio">
            <label>
                <input type="radio" name="filtro" value="dia" <?php if ($filtro == "dia") echo "checked" ?> /> Dia
            </label>
        </div>
        <br><br>
        <div class="col-md-2 radio">
            <label>
                <input type="radio" name="filtro" value="rango" <?php if ($filtro == "rango") echo "checked" ?> /> Rango Fecha Reporte
            </label>
        </div>
        <div class="col-md-4">
            <?= $this->element('select_fecha', [
                'prefijo' => 'fecha1',
                'fecha' => $fechas['f1']
            ])
             ?>
        </div>
        <div class="col-md-5">
            <?= $this->element('select_fecha', [
                'prefijo' => 'fecha2',
                'fecha' => $fechas['f2']
            ])
             ?>
        </div>
    </div>
    <br><br>
    <div class="form-group form-inline control-label">
        <div class=" col-md-1 ">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>
     <?= $this->Form->hidden('enviado', ['value' => true]) ?>
<?= $this->Form->end() ?>
<br><br>

<?php if(!empty($movimientos)){ ?>
<div class="row">
    <div class="col-sm-10 ">
        <h4>Fecha: <?= ($filtro=="dia")? $fecha : $fecha_inicio ." / ".$fecha_fin ?></h4>
        <ol class="breadcrumb center hidden-print">
            <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
        </ol>
        <br>
        <table  class="table table-striped">
            <tr class="active">
                <th width="20%">Fecha</th>
                <th>Descripcion</th>
                <th width="15%">Tipo Movimiento</th>
                <th width="15%">Cantidad</th>
            </tr>
            <?php
            $total_ingresos=0;
            $total_gastos=0;
            $total_caja=0;
            foreach($movimientos as $mov)
            {
                ?>
                <tr>
                    <?php if($mov->usuario_id==$usuario->id){ ?>
                    <td><?= $this->Html->link($mov->fecha->format('d-m-Y'), ['controller' => 'MovimientosCaja', 'action' => 'editar', 'id' => $mov->id], ['target' => '_blank']) ?></td>
                    <?php 
                    } 
                    else
                    { ?> 
                        <td><?= $mov->fecha->format('d-m-Y h:i'); ?></td>
                    <?php 
                    } ?>
                    <td><?= $mov->descripcion; ?></td>
                    <td><?= $mov->tipo_movimiento ?></td>
                    <td><?= $this->number->currency($mov->cantidad) ?></td>
                    <?php if($mov->usuario_id==$usuario->id){ ?>
                        <td style="border: hidden"><?= $this->Html->link('Eliminar', ['controller' => 'MovimientosCaja', 'action' => 'eliminar', 'id' => $mov->id,'filtro'=>$filtro], ['target' => '_self']) ?></td>
                    <?php } ?>
                </tr>
                <?php
                $total_caja=$mov->cantidad_existente;
                $total_gastos=($mov->tipo_movimiento=="Gasto")? $total_gastos+$mov->cantidad : $total_gastos;
                $total_ingresos=($mov->tipo_movimiento=="Ingreso")? $total_ingresos+$mov->cantidad : $total_ingresos ;
            } ?>
            <tr>
                <td colspan="2"></td>
                <td><b>Total Dinero en Caja</b></td>
                <td><b><?= $this->number->currency($total_caja) ?></b></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr style="border: hidden">
                <td colspan="2"></td>
                <td><b>Total Ingresos</b></td>
                <td><?= $this->number->currency($total_ingresos) ?></td>
            </tr>
            <tr style="border: hidden">
                <td colspan="2"></td>
                <td><b>Total Gastos</b></td>
                <td><?= $this->number->currency($total_gastos) ?></td>
            </tr>
        </table>
    </div>
</div>
<?php } ?>