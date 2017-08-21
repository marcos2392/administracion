<?= $this->element("menu_checador") ?>

<h3><b>Reportes Checador</b></h3>

<?= $this->Form->create(null, ['class' => ' form-inline hidden-print', 'id' => 'reporte_checador_forma','method'=>'get']) ?>

<div class="form-group ">
    <div class="radio">
        <label >
            <input type="radio" name="filtro" value="semanal" <?php if ($filtro == "semanal") echo "checked" ?> /> Semanal Nomina
        </label>
    </div>
</div>
<br><br>
<div class="form-group  ">
    <div class="radio">
        <label>
            <input type="radio" name="filtro" value="rango" <?php if ($filtro == "rango") echo "checked" ?> /> Rango
        </label>
    </div>
</div>
<div class="form-group ">
    
    <?= $this->element('select_fecha', [
        'prefijo' => 'fecha1',
        'fecha' => $fechas['f1']
    ]) ?>
    -
    <?= $this->element('select_fecha', [
        'prefijo' => 'fecha2',
        'fecha' => $fechas['f2']
    ]) ?>
</div>
<br>
<br>
<div class="form-group form-inline control-label">
        <?= $this->Form->label('sucursal', 'Sucursal:', ['class' => 'control-label col-md-3']) ?>
        <div class="col-md-5">
            <?= $this->Form->select('sucursal', $this->Select->options($sucursales, 'id', 'nombre', ['blank' => ['' => 'Seleccionar']]), ['value' => $sucursal, 'class' => 'form-control']) ?>
        </div>
        <div class=" col-md-2">
            <?= $this->Form->submit('Enviar', ['class' => 'btn btn-info']) ?>
        </div>
    </div>


<?= $this->Form->end() ?>

<br>   
<?php if(!empty($registro)): ?>
<h4><b>Sucursal :</b><?= $sucursal_nombre ?></h4>
<h4><b>Fecha :</b><?= $inicio ?>/<?= $fin ?></h4>
<br>

<ol class="breadcrumb center hidden-print">
    <li><?=$this->Html->link('Editar',['controller' =>'Checador','action' => 'editar','sucursal'=>$sucursal,'inicio'=>$inicio,'fin'=>$fin]); ?></li>
    <li><?=$this->Html->link('Imprimir', '#', ['class' => 'link_imprimir']) ?></li>
</ol>

<div class="row">
    <div class="col-sm-12 ">
        <table  class="table table-striped table table-bordered">
            <tr class="active">
                <th colspan="3">ID</th>
                <th colspan="3">Nombre</th>
                <th colspan="2">Lunes</th>
                <th colspan="2">Martes</th>
                <th colspan="2">Miercoles</th>
                <th colspan="2">Jueves</th>
                <th colspan="2">Viernes</th>
                <th colspan="2">Sabado</th>
                <th colspan="2">Domingo</th>
                <th colspan="2">R</th>
                <th colspan="2">F</th>
                <th colspan="2">Hrs</th>
                </tr>
                <?php
                foreach($registro as $id=>$reg): ?> 
                    <tr>
                        <td colspan="3"><?= $id ?></td>
                        <td colspan="3"><?= $reg["empleado"] ?></td>
                        <?php 
                        $contador=false;
                        $retardos=0;
                        $faltas=0;
                        $minutos=0;

                        foreach(range(1,7) as $dia):
                            $descanso=false;
                            $falta=false;
                            $asistio=false;
                            $entrada="";
                            $salida="";

                            foreach($reg["checadas"] as $r): 
                                if($contador==false)
                                {
                                    if($r->retardo): $retardos++; endif;
                                    if($r->falta): $faltas++; endif;
                                    if($r->horas!=NULL): $minutos+=$r->minutos(); endif;
                                }
                                if($r->dia==$dia)
                                { 
                                    $asistio=true;
                                    if($r->entrada!= NULL)
                                    {
                                        if($entrada!="")
                                        {
                                            $entrada.= "<br>";
                                            $salida.= "<br>";
                                        }

                                        $entrada.=$r->entrada->format("h:i");
                                        if ($r->salida) {
                                            $salida.=$r->salida->format("h:i");
                                        }
                                    }
                                    else
                                    {
                                        if($r->descanso==1):$descanso=true; endif;
                                        if($r->falta==1):$falta=true; endif;
                                    }
                                }
                            endforeach;
                            $contador=true;
                            if($asistio)
                            { 
                                if($descanso==true || $falta==true)
                                    { 
                                        if($descanso==true): ?><td colspan="2">Descanso</td><?php endif;
                                        if($falta==true): ?><td colspan="2">Falta</td><?php endif;
                                    }
                                else
                                {  ?>
                                        <td><?= $entrada ?></td>
                                        <td><?= $salida ?></td>
                                <?php }
                            }
                            else
                            { ?>
                                <td colspan="2"></td>
                            <?php }
                        endforeach; ?>
                        <td colspan="2"><?=  $retardos ?></td>
                        <td colspan="2"><?=  $faltas ?></td>
                        <td colspan="2"><?= $hrs_t=Horas($minutos); ?></td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </div>
</div>
<?php endif; ?>

