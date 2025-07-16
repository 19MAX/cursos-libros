<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth\LoginController::index');

$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth\LoginController::index');
    $routes->post('login', 'Auth\LoginController::login');
    $routes->get('logout', 'Auth\LoginController::logout');

    $routes->get('recover', 'Auth\RecoverController::index');
    $routes->post('recover', 'Auth\RecoverController::index');
});

$routes->group('admin', function ($routes) {

    $routes->get('/', 'Admin\DashboardController::index');

    $routes->group('courses', function ($routes) {
        $routes->get('', 'Admin\Courses\CoursesController::index');
        $routes->get('create', 'Admin\Courses\CoursesController::create');
        $routes->post('store', 'Admin\Courses\CoursesController::store');
        $routes->get('edit/(:num)', 'Admin\Courses\CoursesController::edit/$1');
        $routes->post('update/(:num)', 'Admin\Courses\CoursesController::update/$1');
        $routes->get('delete/(:num)', 'Admin\Courses\CoursesController::delete/$1');
    });

});
$routes->group('docente', function ($routes) {
    $routes->get('', 'Docente\DashboardController::index');

    // Rutas para capacitaciones
    $routes->group('capacitaciones', function ($routes) {
        $routes->get('', 'Docente\CapacitacionesController::index');
        $routes->get('create', 'Docente\CapacitacionesController::create');
        $routes->post('store', 'Docente\CapacitacionesController::store');
        $routes->get('edit/(:num)', 'Docente\CapacitacionesController::edit/$1');
        $routes->post('update/(:num)', 'Docente\CapacitacionesController::update/$1');
        $routes->post('delete/(:num)', 'Docente\CapacitacionesController::delete/$1');
    });

    // Rutas para libros
    $routes->group('libros', function ($routes) {
        $routes->get('', 'Docente\LibrosController::index');
        $routes->get('create', 'Docente\LibrosController::create');
        $routes->post('store', 'Docente\LibrosController::store');
        $routes->get('edit/(:num)', 'Docente\LibrosController::edit/$1');
        $routes->post('update/(:num)', 'Docente\LibrosController::update/$1');
        $routes->post('delete/(:num)', 'Docente\LibrosController::delete/$1');
    });

    // Rutas para artículos
    $routes->group('articulos', function ($routes) {
        $routes->get('', 'Docente\ArticulosController::index');
        $routes->get('create', 'Docente\ArticulosController::create');
        $routes->post('store', 'Docente\ArticulosController::store');
        $routes->get('edit/(:num)', 'Docente\ArticulosController::edit/$1');
        $routes->post('update/(:num)', 'Docente\ArticulosController::update/$1');
        $routes->post('delete/(:num)', 'Docente\ArticulosController::delete/$1');
    });
});
