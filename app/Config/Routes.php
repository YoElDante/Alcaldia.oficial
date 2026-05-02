<?php
/**
 * Registro central de rutas HTTP del portal.
 * Define navegacion publica y endpoints de acceso/descarga protegida.
 * Dependencia critica: filtros auth y ratelimit de CodeIgniter.
 */

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->set404Override('App\Controllers\ErrorsController::notFound');

$routes->get('/', 'HomeController::index');
$routes->get('/pagos', 'PagosController::index');
$routes->get('/tutoriales', 'TutorialesController::index');
$routes->get('/descargas', 'DescargasController::index');
$routes->post('/descargas/login', 'DescargasController::login', ['filter' => 'ratelimit']);
$routes->get('/descargas/panel', 'DescargasController::panel', ['filter' => 'auth']);
$routes->get('/descargas/archivo/(:segment)', 'DescargasController::download/$1', ['filter' => 'auth']);
$routes->get('/descargas/logout', 'DescargasController::logout', ['filter' => 'auth']);
