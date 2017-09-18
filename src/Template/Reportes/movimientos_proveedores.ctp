<?= $this->element($menu) ?>
<h3>Reporte Movimientos de Proveedores</h3>
<br>
<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline col-md-12">

        
        <?= $this->Form->label('proveedor', 'Proveedor:', ['class' => 'control-label col-md-1']) ?>
        <div class="col-md-3">
            <?= $this->Form->select('proveedor', $this->Select->options($proveedores, 'id', 'nombre', ['blank' => ['0' => 'Todos']]), ['value' => $proveedor, 'class' => 'form-control']) ?>
        </div>
        <br><br>
        

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
     <?= $this->Form->hidden('menu', ['value' => $menu]) ?>
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
                <th>Usuario</th>
                <th>Proveedor</th>
                <th>Descripcion</th>
                <th width="15%">Tipo Movimiento</th>
                <th width="15%">Cantidad</th>
                <th width="15%">Saldo</th>
            </tr>
            <?php
            $total_depositos=0;
            $total_notas=0;

            foreach($movimientos as $mov)
            {
                ?>
                <tr>
                    <?php if($mov->usuario_id==$usuario->id){ ?>
                    <td><?= $this->Html->link($mov->fecha->format('d-m-Y h:i'), ['controller' => 'MovimientosProveedores', 'action' => 'editar', 'id' => $mov->id], ['target' => '_blank']) ?></td>
                    <?php 
                    } 
                    else
                    { ?> 
                        <td><?= $mov->fecha->format('d-m-Y h:i'); ?></td>
                    <?php 
                    } ?>
                    <td><?= $mov->usuario->nombre; ?></td>
                    <td><?= $mov->proveedor->nombre; ?></td>
                    <td><?= $mov->descripcion; ?></td>
                    <td><?= $mov->tipo ?></td>
                    <td><?= $this->number->currency($mov->cantidad) ?></td>
                    <td><?= $this->number->currency($mov->saldo) ?></td>
                    <?php if($mov->usuario_id==$usuario->id){ ?>
                        <td style="border: hidden"><?= $this->Html->link('Eliminar', ['controller' => 'MovimientosProveedores', 'action' => 'eliminar', 'id' => $mov->id,'filtro'=>$filtro], ['target' => '_self']) ?></td>
                    <?php } ?>
                </tr>
                <?php
                $saldo=$mov->saldo;
                $total_depositos=($mov->tipo=="Deposito")? $total_depositos+$mov->cantidad : $total_depositos;
                $total_notas=($mov->tipo=="Nota")? $total_notas+$mov->cantidad : $total_notas ;
            } ?>

            <tr>
                <td></td>
            </tr>
            <tr style="border: hidden">
                <td colspan="4"></td>
                <td><b>Total Depositos</b></td>
                <td><?= $this->number->currency($total_depositos) ?></td>
            </tr>
            <tr style="border: hidden">
                <td colspan="4"></td>
                <td><b>Total Notas</b></td>
                <td><?= $this->number->currency($total_notas) ?></td>
            </tr>
        </table>
    </div>
</div>
<?php } ?>