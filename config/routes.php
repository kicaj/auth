<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::prefix('admin', function (RouteBuilder $routes) {
    $routes->connect('/', [
        'plugin' => 'Auth',
        'controller' => 'Users',
        'action' => 'dashboard',
    ]);

    $routes->plugin('Auth', function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    });

    $routes->fallbacks(DashedRoute::class);
});

Router::plugin('Auth', function (RouteBuilder $routes) {
    $routes->fallbacks(DashedRoute::class);
});
