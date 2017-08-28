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
        <div class="row margenes">
            <div class="col-md-7">
                <div class="row">
                    <?=$this->Html->link( $this->Html->image('logojmeza.jpg', ['class' => 'pull-left imagen-logo']), array('controller'=>'Principal','action'=>'inicio'), array('escape'=>false)); ?>
                    <?= $this->Html->image('logojoyeriameza.jpg', ['class' => 'pull-left']) ?>
                </div>
            </div>

            <div class="col-md-5 hidden-print">
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
                        <!--<li><?= $this->Html->link('Reportes', ['controller' =>'Reportes','action' => 'inicio']); ?></li> -->
                        <?php if($usuario->nominas){ ?>
                            <li><?= $this->Html->link('Nominas', ['controller' =>'Nominas','action' => 'nominas']); ?></li>
                        <?php } ?>
                        <?php if($usuario->movimientos_caja){ ?>
                            <li><?= $this->Html->link('Movimientos de Caja', ['controller' =>'MovimientosCaja','action' => 'caja']); ?></li>
                        <?php } ?>
                        <?php if($usuario->checador){ ?>
                            <li><?= $this->Html->link('Checador', ['controller' =>'Checador','action' => 'inicio']); ?></li>
                        <?php } ?>
                    </ul> 
                    <?php if($usuario->admin){ ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administracion<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    
                                    <li><?= $this->Html->link('Usuarios', ['controller' =>'Usuarios','action' => 'usuarios']); ?></li>
                                    <li><?= $this->Html->link('Empleados', ['controller' =>'Empleados','action' => 'empleados']); ?></li>
                                    <li><?= $this->Html->link('Sucursales', ['controller' =>'Sucursales','action' => 'sucursales']); ?></li>
                                    
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="container-fluid">

        <?= $this->Flash->render() ?>
        <div class="container clearfix">
            <?= $this->fetch('content') ?>
        </div>
        <footer>
        </footer>
    </div>
</body>
</html>
