<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_nominas', 'autocomplete' => "off"]) ?>
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
                foreach($registro as $id=>$reg): 
                
                 ?> 
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
                            //$fecha=null;

                            foreach($reg["checadas"] as $r):
                                if($contador==false)
                                {
                                    if($r->retardo): $retardos++; endif;
                                    if($r->falta): $faltas++; endif;
                                    if($r->horas!=NULL): $minutos+=$r->minutos(); endif;
                                }
                                if($r->dia==$dia)
                                { 
                                    $fecha=$r->fecha->format("Y-m-d");
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
                                        <td width="80px"><?= $this->Form->text('empleados['.$id.']['.$fecha.'][entrada]', ['class' => 'focus form-control', 'value' => $entrada]) ?></td>
                                        <td width="80px"><?= $this->Form->text('empleados['.$id.']['.$fecha.'][salida]', ['class' => 'focus form-control', 'value' => $salida]) ?></td>
                                <?php }
                            }
                            else
                            {   
                                $fecha=strtotime('+1 day',strtotime($fecha));
                                $fecha=date('Y-m-d',$fecha);?>
                                <td width="80px"><?= $this->Form->text('empleados['.$id.']['.$fecha.'][entrada]', ['class' => 'focus form-control', 'value' => $entrada]) ?></td>
                                <td width="80px"><?= $this->Form->text('empleados['.$id.']['.$fecha.'][salida]', ['class' => 'focus form-control', 'value' => $salida]) ?></td>
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
<div class="form-group">
    <div class="col-md-6 col-md-offset-5">
        <?= $this->Form->button($submit, ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?= $this->Form->end() ?>