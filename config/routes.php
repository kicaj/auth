<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
    $routes->prefix('admin', function (RouteBuilder $routes) {
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

    $routes->plugin('Auth', function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    });
};
