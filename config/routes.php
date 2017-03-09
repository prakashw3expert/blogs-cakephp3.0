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
use Cake\Core\Configure;

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
Router::defaultRouteClass('DashedRoute');

$categories = Configure::read('Categories');

Router::extensions(['pdf']);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'pages', 'action' => 'display', 'home']);
    
    
    // Blog and Blog Categories Dynamic Routes
    $categories = Configure::read('Categories');

    foreach ($categories as $key => $value) {
        $metaData = json_decode($value);
        if(isset($metaData->parent->slug)){
            $routes->connect('/' . $metaData->parent->slug.'/'.$key, ['controller' => 'blogs', 'action' => 'index', 'category' => $key,'parent' => $metaData->parent->slug], ['pass' => ['parent','category']]);

            $routes->connect('/' . $metaData->parent->slug.'/'. $key . '/:slug', ['controller' => 'blogs', 'action' => 'view', 'parent' => $metaData->parent->slug,'category' => $key], ['pass' => ['parent','category','slug']]);
        }
        else{
            $routes->connect('/' . $key, ['controller' => 'blogs', 'action' => 'index', 'category' => $key], ['pass' => ['category']]);

            $routes->connect('/' . $key . '/:slug', ['controller' => 'blogs', 'action' => 'view', 'category' => $key], ['pass' => ['category','slug']]);
        }
        
    }

    $routes->connect('/tag/:tag', ['controller' => 'blogs', 'action' => 'index'], ['pass' => ['tag']]);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/login', ['controller' => 'users', 'action' => 'login']);

    $routes->connect('/user/settings', ['controller' => 'users', 'action' => 'view']);

    $routes->connect('/about-us', ['controller' => 'Pages', 'action' => 'view','about-us']);
    $routes->connect('/contact-us', ['controller' => 'contacts', 'action' => 'view','contact-us']);
    $routes->connect('/privacy-policy', ['controller' => 'Pages', 'action' => 'view','privacy-policy']);
    $routes->connect('/term-and-conditions', ['controller' => 'Pages', 'action' => 'view','term-and-conditions']);
    $routes->connect('/profile/:slug', ['controller' => 'authors', 'action' => 'view'], ['pass' => ['slug']]);
    $routes->connect('/magazines/:slug', ['controller' => 'magazines', 'action' => 'view'], ['pass' => ['slug']]);
    $routes->connect('/magazines/download/:slug', ['controller' => 'magazines', 'action' => 'download'], ['pass' => ['slug']]);
    $routes->connect('/contests/:slug', ['controller' => 'contests', 'action' => 'view'], ['pass' => ['slug']]);
    $routes->connect('/contests/:slug/participate', ['controller' => 'contests', 'action' => 'participate'], ['pass' => ['slug']]);
    $routes->connect('/contests/:slug/upload', ['controller' => 'contests', 'action' => 'upload'], ['pass' => ['slug']]);
    $routes->connect('/contests/:slug/entries', ['controller' => 'contests', 'action' => 'enteries'], ['pass' => ['slug']]);
    $routes->connect('/contests/:slug/entries/:entry', ['controller' => 'contests', 'action' => 'entry'], ['pass' => ['slug','entry']]);
    $routes->connect('/contests/:slug/like/:entry', ['controller' => 'contests', 'action' => 'like'], ['pass' => ['slug','entry']]);
    
    $routes->connect('/event/:slug', ['controller' => 'events', 'action' => 'view'], ['pass' => ['slug']]);
    $routes->connect('/event-detail/:slug', ['controller' => 'events', 'action' => 'viewDetails'], ['pass' => ['slug']]);
    
    
    $routes->connect('/account-activate/:code', ['controller' => 'users', 'action' => 'activate'], ['pass' => ['code']]);

    $routes->connect('/resend-activation-code/:slug/:code', ['controller' => 'users', 'action' => 'resendActivation'], ['pass' => ['slug','code']]);

    $routes->connect('/reset-password/:code', ['controller' => 'users', 'action' => 'resetPassword'], ['pass' => ['code']]);
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
    $routes->fallbacks('DashedRoute');
});

// Or with prefix()
Router::prefix('admin', ['_namePrefix' => 'admin:'], function ($routes) {
    $routes->connect('/', ['controller' => 'dashboard', 'action' => 'index']);
    $routes->connect('/event/:slug', ['controller' => 'events', 'action' => 'view'], ['pass' => ['slug']]);
    $routes->connect('/contests/detail/:slug', ['controller' => 'contests', 'action' => 'view'], ['pass' => ['slug']]);
    $routes->connect('/user/:slug', ['controller' => 'users', 'action' => 'view'], ['pass' => ['slug']]);
    $routes->connect('/magazines/download/:slug', ['controller' => 'magazines', 'action' => 'download'], ['pass' => ['slug']]);
    
    $routes->fallbacks('DashedRoute');
    
});

Router::prefix('author', ['_namePrefix' => 'admin:'], function ($routes) {
    $routes->connect('/', ['controller' => 'blogs', 'action' => 'index']);
    $routes->fallbacks('DashedRoute');
    
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
