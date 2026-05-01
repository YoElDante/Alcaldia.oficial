<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/pagos', 'PagosController::index');
$routes->get('/tutoriales', 'TutorialesController::index');
$routes->get('/descargas', 'DescargasController::index');
$routes->post('/descargas/login', 'DescargasController::login', ['filter' => 'ratelimit']);
$routes->get('/descargas/panel', 'DescargasController::panel', ['filter' => 'auth']);
$routes->get('/descargas/logout', 'DescargasController::logout', ['filter' => 'auth']);
