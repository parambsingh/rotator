<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

Router::prefix('Admin', ['_namePrefix' => 'admin:'], function (RouteBuilder $routes) {

    $routes->connect('/', ['controller' => 'Admins', 'action' => 'login']);
    $routes->connect('/dashboard', ['controller' => 'Admins', 'action' => 'dashboard']);
    $routes->connect('/distributors/*', ['controller' => 'Users']);
    $routes->connect('/distributors/:action/*', ['controller' => 'Users']);
    $routes->connect('/distributors/manage-positions/*', ['controller' => 'Users', 'action'=>'managePositions']);
    $routes->fallbacks(DashedRoute::class);
});


$routes->scope('/', function (RouteBuilder $builder) {
    // Register scoped middleware for in scopes.
    //    $builder->registerMiddleware('csrf', new CsrfProtectionMiddleware([
    //        'httpOnly' => true,
    //    ]));

    /*
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered through `Application::routes()` with `registerMiddleware()`
     */
    //$builder->applyMiddleware('csrf');

    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, templates/Pages/home.php)...
    */
    $builder->connect('/', ['controller' => 'Pages', 'action' => 'home']);
    $builder->connect('/sign-in', ['controller' => 'Users', 'action' => 'login']);
    $builder->connect('/sign-up', ['controller' => 'Users', 'action' => 'register']);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /*
     * Connect catchall routes for all controllers.
     *
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $builder->connect('/:controller', ['action' => 'index']);
     * $builder->connect('/:controller/:action/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks();
});