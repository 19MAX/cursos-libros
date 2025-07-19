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

    $routes->group('capacitaciones', function ($routes) {
        $routes->get('', 'Admin\CapacitacionesController::index');
        $routes->get('show/(:num)', 'Admin\CapacitacionesController::show/$1');
        $routes->post('aprobar/(:num)', 'Admin\CapacitacionesController::aprobar/$1');
        $routes->post('rechazar/(:num)', 'Admin\CapacitacionesController::rechazar/$1');
    });

    $routes->group('libros', function ($routes) {
        $routes->get('', 'Admin\LibrosController::index');
        $routes->get('show/(:num)', 'Admin\LibrosController::show/$1');
        $routes->post('aprobar/(:num)', 'Admin\LibrosController::aprobar/$1');
        $routes->post('rechazar/(:num)', 'Admin\LibrosController::rechazar/$1');
    });

    $routes->group('articulos', function ($routes) {
        $routes->get('', 'Admin\ArticulosController::index');
        $routes->get('show/(:num)', 'Admin\ArticulosController::show/$1');
        $routes->post('aprobar/(:num)', 'Admin\ArticulosController::aprobar/$1');
        $routes->post('rechazar/(:num)', 'Admin\ArticulosController::rechazar/$1');
    });
    $routes->group('documentos', function ($routes) {
        $routes->get('', 'Admin\DocumentosController::index');
        $routes->get('show/(:num)', 'Admin\DocumentosController::show/$1');
        $routes->post('aprobar/(:num)', 'Admin\DocumentosController::aprobar/$1');
        $routes->post('rechazar/(:num)', 'Admin\DocumentosController::rechazar/$1');
    });
    $routes->group('docentes', function ($routes) {
        $routes->get('', 'Admin\DocentesController::index');
        $routes->get('create', 'Admin\DocentesController::create');
        $routes->post('store', 'Admin\DocentesController::store');
        $routes->get('edit/(:num)', 'Admin\DocentesController::edit/$1');
        $routes->post('update/(:num)', 'Admin\DocentesController::update/$1');
        $routes->get('delete/(:num)', 'Admin\DocentesController::delete/$1');
    });

});
$routes->group('docente', function ($routes) {
    $routes->get('', 'Docente\DashboardController::index');
    $routes->get('perfil', 'Docente\DashboardController::perfil');
    $routes->post('perfil', 'Docente\DashboardController::updatePerfil');

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

    // Rutas para documentos
    $routes->group('documentos', function ($routes) {
        $routes->get('', 'Docente\DocumentosController::index');
        $routes->get('create', 'Docente\DocumentosController::create');
        $routes->post('store', 'Docente\DocumentosController::store');
        $routes->get('edit/(:num)', 'Docente\DocumentosController::edit/$1');
        $routes->post('update/(:num)', 'Docente\DocumentosController::update/$1');
        $routes->post('delete/(:num)', 'Docente\DocumentosController::delete/$1');
    });
});
