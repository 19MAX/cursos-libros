<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth\LoginController::index');

$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth\LoginController::index', ['as' => 'login']);
    $routes->post('login', 'Auth\LoginController::login', ['as' => 'login.post']);
    $routes->get('logout', 'Auth\LoginController::logout', ['as' => 'logout']);
});
