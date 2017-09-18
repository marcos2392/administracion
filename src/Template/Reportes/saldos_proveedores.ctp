<?= $this->element($menu) ?>

<h3>Saldos Proveedores</h3>

<br><br>
    <div class="row" >
        <div class="col-sm-5 col-sm-offset-3">
            <table  class="table table-striped">
                    <tr class="active">
                        <th>#</th>
                        <th>Proveedor</th>
                        <th>Saldo</th>
                    </tr>

                    <?php 
                    $contador=1;
                    $total=0;
                    foreach ($saldos as $saldo): ?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><?= $saldo->proveedor->nombre ?></td>
                            <td><?= $this->Number->currency($saldo->saldo) ?></td>
                        </tr>
                    <?php
                        $contador++;
                        $total+=$saldo->saldo;
                    endforeach; ?>

                <tr class="active">
                    <th></th>
                    <th>Total: </th>
                    <th><b> <?= $this->Number->currency($total) ?></b></th>
                </tr>
                    
            </table>
        </div>
    </div>