<?= $this->Form->create(null, ['url' => $url, 'class' => 'form-horizontal disable', 'id' => 'forma_nominas', 'autocomplete' => "off"]) ?>
<div class="row">
    <div class="col-sm-12 ">
        <table  class="table table-striped table table-bordered">
            <tr class="active">
                <th colspan="1">ID</th>
                <th colspan="2">Nombre</th>
                <th >Lunes</th>
                <th >Martes</th>
                <th >Miercoles</th>
                <th >Jueves</th>
                <th >Viernes</th>
                <th >Sabado</th>
                <th >Domingo</th>
                <th >R</th>
                <th >F</th>
                <th >Hrs</th>
                <th width="100px">Hrs Editadas</th>
                </tr>
                <?php
                foreach($registro as $id=>$reg):
                
                    $horas_checadas_semanales=Horas($reg["hrs_semanales"]);
                 ?> 
                    <tr>
                        <td colspan="1"><?= $id ?></td>
                        <td colspan="2"><?= $reg["empleado"] ?></td>
                        <?php 
                        $contador=false;
                        $retardos=0;
                        $faltas=0;
                        $minutos=0; 

                        $i=1;
                        $fecha=$desde_fecha;

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
                                if($dia==1)
                                {
                                    $fecha = $fecha;
                                }

                                if($descanso==true || $falta==true)
                                { 
                                    if($descanso==true): ?><td width="80px"><?= $this->Form->text('empleados['.$id.']['.$i.']['.$fecha.'][entrada]', ['class' => 'focus form-control', 'value' => '']) ?>
                                    <?= $this->Form->text('empleados['.$id.']['.$i.']['.$fecha.'][salida]', ['class' => 'focus form-control', 'value' => '']) ?></td><?php endif;
                                    if($falta==true): ?><td>Falta</td><?php endif;
                                }
                                else
                                { ?>
                                        <td width="80px"><?= $this->Form->text('empleados['.$id.']['.$i.']['.$fecha.'][entrada]', ['class' => 'focus form-control', 'value' => $entrada]) ?>
                                        <?= $this->Form->text('empleados['.$id.']['.$i.']['.$fecha.'][salida]', ['class' => 'focus form-control', 'value' => $salida]) ?></td>
                                <?php }
                            }
                            else
                            {  
                                
                                ?>
                                <td width="80px"><?= $this->Form->text('empleados['.$id.']['.$i.']['.$fecha.'][entrada]', ['class' => 'focus form-control', 'value' => $entrada]) ?>
                                <?= $this->Form->text('empleados['.$id.']['.$i.']['.$fecha.'][salida]', ['class' => 'focus form-control', 'value' => $salida]) ?></td>
                                
                            <?php } 
                            $fecha=date("Y-m-d",strtotime('+1 day',strtotime($fecha)));
                            $i++;
                        endforeach; ?>
                        <td><?=  $retardos ?></td>
                        <td><?=  $faltas ?></td>
                        <td><?= $hrs_t=Horas($minutos); ?></td>
                        <td><?= $this->Form->text('horas_finales_total['.$id.'][horas_finales_total]', ['class' => 'focus form-control', 'value' => $horas_checadas_semanales]) ?></td></td>
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