<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/', ['controller' => 'Principal', 'action' => 'inicio']);
    $routes->connect('/nominas/nominas', ['controller' => 'Nominas', 'action' => 'nominas']);

    $routes->connect('/sucursales/:id/editar', ['controller' => 'Sucursales', 'action' => 'editar']);
    $routes->connect('/sucursales/:id/actualizar', ['controller' => 'Sucursales', 'action' => 'actualizar']);

    $routes->connect('/movimientos/caja', ['controller' => 'MovimientosCaja', 'action' => 'caja']);
    $routes->connect('/movimientos/movimientos', ['controller' => 'MovimientosCaja', 'action' => 'movimientos']);

    $routes->connect('/movimientos/:id/movimientos', ['controller' => 'MovimientosCaja', 'action' => 'editar']);
    $routes->connect('/movimientos/:id/editar', ['controller' => 'MovimientosCaja', 'action' => 'actualizar']);
    $routes->connect('/reportes/:id/caja', ['controller' => 'MovimientosCaja', 'action' => 'eliminar']);

    $routes->connect('/reportes/pago_nominas', ['controller' => 'Reportes', 'action' => 'PagoNominas']);

    $routes->connect('/reparaciones/:id/editar', ['controller' => 'Reparaciones', 'action' => 'editar']);
    $routes->connect('/reparaciones/:id/eliminar', ['controller' => 'Reparaciones', 'action' => 'eliminar']);

    $routes->connect('/joyeros/:id/eliminar', ['controller' => 'Joyeros', 'action' => 'eliminar']);
    $routes->connect('/joyeros/:id/editar', ['controller' => 'Joyeros', 'action' => 'editar']);
    $routes->connect('/joyeros/:id/actualizar', ['controller' => 'Joyeros', 'action' => 'actualizar']);


    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
