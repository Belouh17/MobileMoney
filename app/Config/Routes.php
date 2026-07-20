<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/', 'LivreController::index');
$routes->get('/livre/(:num)', 'LivreController::show/$1');

$routes->get('/livre/create', 'LivreController::create');
$routes->post('/livre/store', 'LivreController::store');

$routes->post('/livre/delete/(:num)', 'LivreController::delete/$1');

$routes->post('/livre/emprunter/(:num)', 'EmpruntController::emprunter/$1');
$routes->post('/livre/retourner/(:num)', 'EmpruntController::retourner/$1');