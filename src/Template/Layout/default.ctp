<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */


?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery.js"></script>
    <title>
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->AssetCompress->css('all') ?>
    <?= $this->AssetCompress->css('administracion.min') ?>
    <?= $this->AssetCompress->script('libs') ?>
    <?= $this->AssetCompress->script('administracion.min') ?>

    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="container clearfix">
                    <?=$this->Html->link( $this->Html->image('jmeza_logo.jpg', ['class' => 'img-responsive ','width'=>"200px"]), array('controller'=>'Principal','action'=>'inicio'), array('escape'=>false)); ?>
            </div>
            <!--<div style="float: right;"> 
            <div class="col-md-12 hidden-print">
                <?php if (isset($usuario)): ?>
                    <div class="der">
                        Usuario: <strong><?= $usuario->nombre ?></strong>
                    </div>
                    <div class="der">
                        Fecha: <strong><?= $fecha ?></strong>
                    </div>
                    <div class="der">
                        <?= $this->Html->link('Cerrar sesión', ['controller' => 'Usuarios', 'action' => 'logout']) ?>
                    </div>
                <?php endif; ?>
            </div>
            </div> -->
        </div>
        <br>
        <?php if (isset($usuario)): ?>
            <div class="navbar navbar-inverse">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>
                <div class="collapse navbar-collapse" id="menu">
                    <ul class="nav navbar-nav">
                        <li><?= $this->Html->link('Inicio', ['controller' =>'Principal','action' => 'inicio']); ?></li>
                        <?php if($usuario->nominas){ ?>
                            <li><?= $this->Html->link('Nominas', ['controller' =>'Nominas','action' => 'nominas']); ?></li>
                        <?php } ?>
                        <?php if($usuario->movimientos_caja){ ?>
                            <li><?= $this->Html->link('Movimientos de Caja', ['controller' =>'MovimientosCaja','action' => 'caja']); ?></li>
                        <?php } ?>
                        <?php if($usuario->checador){ ?>
                            <li><?= $this->Html->link('Checador', ['controller' =>'Checador','action' => 'reporte']); ?></li>
                        <?php } ?>
                        <?php if($usuario->reparaciones){ ?>
                            <li><?= $this->Html->link('Reparaciones', ['controller' =>'Reparaciones','action' => 'reparaciones']); ?></li>
                        <?php } ?>
                        <?php if($usuario->proveedores){ ?>
                            <li><?= $this->Html->link('Proveedores', ['controller' =>'MovimientosProveedores','action' => 'inicio']); ?></li>
                        <?php } ?>
                        <?php if($usuario->cobranzas){ ?>
                            <li><?= $this->Html->link('Cobranzas', ['controller' =>'Cobranzas','action' => 'cobranzas']); ?></li>
                        <?php } ?>

                        <li><?= $this->Html->link('Reportes', ['controller' =>'Reportes','action' => 'reportes']); ?></li>
                    </ul> 
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Acciones<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php if($usuario->super_admin ){ ?>
                                    <li><?= $this->Html->link('Usuarios', ['controller' =>'Usuarios','action' => 'usuarios']); ?></li>
                                <?php } ?>

                                <?php if($usuario->admin){ ?>
                                    <li><?= $this->Html->link('Empleados', ['controller' =>'Empleados','action' => 'empleados']); ?></li>
                                <?php } ?>

                                <?php if($usuario->super_admin){ ?>
                                    <li><?= $this->Html->link('Sucursales', ['controller' =>'Sucursales','action' => 'sucursales']); ?></li>
                                <?php } ?>

                                <?php if($usuario->super_admin){ ?>
                                    <li><?= $this->Html->link('Joyeros', ['controller' =>'Joyeros','action' => 'joyeros']); ?></li>
                                <?php } ?>

                                <?php if($usuario->super_admin || $usuario->proveedores){ ?>
                                    <li><?= $this->Html->link('Proveedores', ['controller' =>'Proveedores','action' => 'proveedores']); ?></li>
                                <?php } ?>

                                <?php if($usuario->super_admin || $usuario->cobranzas){ ?>
                                    <li><?= $this->Html->link('Cobradores', ['controller' =>'Cobradores','action' => 'cobradores']); ?></li>
                                <?php } ?>
                                <li role="separator" class="divider"></li>
                                <li>Usuario: <strong><?= $usuario->nombre ?></strong></li>
                                <li role="separator" class="divider"></li>
                                <li><b><?= $this->Html->link('Cerrar sesión', ['controller' => 'Usuarios', 'action' => 'logout']) ?></b></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
        
        <div class="container clearfix">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
        <footer>
        </footer>
</body>
</html>
