
<div class="row">
    <div class="col-sm-12 ">
        <table  class="table table-striped table table-bordered">
            <tr class="active">
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
            $i=1; 
            foreach($registro as $id=>$reg):  ?>
                <tr>
                    <td><?= $reg["empleado"] ?></td>
                    <?php 
                    foreach(range(1,7) as $dia):
                        $entrada="";
                        $salida="";
                        $asistio=false;

                        foreach($reg["checadas"] as $r):

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
                        endforeach; ?>
                        </td>
                        </tr>
                <?php endforeach; ?>

                
            <?php
            endforeach;
            ?>
        </table>
    </div>
</div>
