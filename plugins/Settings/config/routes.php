<?php

use Cake\Routing\Router;
Router::prefix('admin', ['_namePrefix' => 'admin:'], function ($routes) {
    $routes->connect('/', ['controller' => 'dashboard', 'action' => 'index']);
//    $routes->fallbacks('DashedRoute');

    $routes->plugin('Settings', function ($routes) {
//        $routes->connect('/settings', ['controller' => 'settings', 'action' => 'index']);
//        $routes->connect('/add', ['controller' => 'settings', 'action' => 'add']);
//        $routes->connect('/edit/:id', ['controller' => 'settings', 'action' => 'edit'],['id' => '\d+', 'pass' => ['id']]);
        $routes->fallbacks('DashedRoute');
    });
});


