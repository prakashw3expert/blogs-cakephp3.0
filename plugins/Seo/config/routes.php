<?php

use Cake\Routing\Router;
Router::prefix('admin', ['_namePrefix' => 'admin:'], function ($routes) {
    $routes->connect('/', ['controller' => 'dashboard', 'action' => 'index']);
//    $routes->fallbacks('DashedRoute');

    $routes->plugin('Seo', function ($routes) {
        $routes->connect('/', ['controller' => 'seo-meta-tags', 'action' => 'index']);
        $routes->connect('/add', ['controller' => 'seo-meta-tags', 'action' => 'add']);
        $routes->connect('/edit/:id', ['controller' => 'seo-meta-tags', 'action' => 'edit'],['id' => '\d+', 'pass' => ['id']]);
        $routes->fallbacks('DashedRoute');
    });
});


