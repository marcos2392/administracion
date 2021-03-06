<?= $this->element($menu) ?>
<h3>Reporte Movimientos de Proveedores</h3>
<br>
<?= $this->Form->create(false, ['class' => 'form-horizontal hidden-print','method'=>'get']) ?>
   
    <div class="form-group form-inline col-md-12">

        
        <?= $this->Form->label('proveedor', 'Proveedor:', ['class' => 'control-label col-md-1']) ?>
        <div class="col-md-3">
            <?= $this->Form->select('proveedor', $this->Select->options($proveedores, 'id', 'nombre', ['blank' => ['0' => 'Todos']]), ['value' => $proveedor, 'class' => 'form-control']) ?>
        </div>
        <br><br><br>
        
        <div class="col-md-3 form-inline">
            <?= $this->Form->checkbox('checkbox_notas_pagadas',[$checked]); ?>
            <?= $this->Form->label('notas_pagadas', 'Notas Pagadas', ['class' => 'control-label col-md-offset-2']) ?>
        </div>
        <br><br><br>

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
    <div class="col-sm-12 ">
        <?php if($checkbox_notas_pagadas){?> <h3><b>Notas Pagadas</b></h3> <?php } ?>
        <h4>Fecha: <?= ($filtro=="dia")? $fecha : $fecha_inicio ." / ".$fecha_fin ?></h4>
        <ol class="breadcrumb center hidden-print">
            <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
        </ol>
        <br>
        <?php if($checkbox_notas_pagadas){ ?>
            <table  class="table table-striped">
                <tr class="active">
                    <th >Fecha</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Nota Costeo ID</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                </tr>
                <?php

                foreach($movimientos as $mov)
                {
                    ?>
                    <tr>
                        <?php if($mov->usuario_id==$usuario->id || $usuario->admin==true){ ?>
                        <td><?= $mov->fecha->format('d-m-Y h:i') ?></td>
                        <?php 
                        } 
                        else
                        { ?> 
                            <td><?= $mov->fecha->format('d-m-Y h:i'); ?></td>
                        <?php 
                        } ?>
                        <td><?= $mov->usuario->nombre; ?></td>
                        <td><?= $mov->proveedor->nombre; ?></td>
                        <td><?= $mov->nota_proveedor_id; ?></td>
                        <td><?= $mov->descripcion; ?></td>
                        <td><?= $this->Number->currency($mov->cantidad) ?></td>
                        <?php if($mov->usuario_id==$usuario->id || $usuario->admin==true){
                                if($mov->nota_proveedor_id==null){ ?>
                            <td style="border: hidden"><?= $this->Html->link('Eliminar', ['controller' => 'MovimientosProveedores', 'action' => 'eliminar', 'id' => $mov->id,'filtro'=>$filtro], ['target' => '_self']) ?></td>
                        <?php } } ?>
                    </tr>
            </table>

        <?php } } else{ ?>
        <table  class="table table-striped">
            <tr class="active">
                <th >Fecha</th>
                <th>Usuario</th>
                <th>Proveedor</th>
                <?php if($nota_proveedor_id){ ?>
                    <th>Nota Costeo ID</th>
                <?php } ?>
                <th>Descripcion</th>
                <th >Tipo Movimiento</th>
                <th >Cantidad</th>
                <th >Saldo</th>
            </tr>
            <?php
            $total_depositos=0;
            $total_notas=0;

            foreach($movimientos as $mov)
            {
                ?>
                <tr>
                    <?php if($mov->usuario_id==$usuario->id || $usuario->admin==true){ ?>
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
                    <?php if($nota_proveedor_id){ ?>
                        <td><?= $mov->nota_proveedor_id; ?></td>
                    <?php } ?>
                    <td><?= $mov->descripcion; ?></td>
                    <td><?= $mov->tipo ?></td>
                    <td><?= $this->Number->currency($mov->cantidad) ?></td>
                    <td><?= $this->Number->currency($mov->saldo) ?></td>
                    <?php if($mov->usuario_id==$usuario->id || $usuario->admin==true){
                            if($mov->nota_proveedor_id==null){ ?>
                        <td style="border: hidden"><?= $this->Html->link('Eliminar', ['controller' => 'MovimientosProveedores', 'action' => 'eliminar', 'id' => $mov->id,'filtro'=>$filtro], ['target' => '_self']) ?></td>
                    <?php } } ?>
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
                <td><?= $this->Number->currency($total_depositos) ?></td>
            </tr>
            <tr style="border: hidden">
                <td colspan="4"></td>
                <td><b>Total Notas</b></td>
                <td><?= $this->Number->currency($total_notas) ?></td>
            </tr>
        </table>
    </div>
</div>
<?php } } ?>