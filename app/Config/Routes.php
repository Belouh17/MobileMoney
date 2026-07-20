<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/test-db', function () {
    $db = \Config\Database::connect();

    echo "Connexion SQLite OK";
});
$routes->get('/', 'Home::index');
$routes->get('/client/login', 'ClientController::login');
$routes->post('/client/auth', 'ClientController::auth');

$routes->get('/client/dashbord','ClientController::dashbord');


$routes->get('/client/historique','ClientController::historique');


$routes->post('/client/depot','ClientController::depot');


$routes->post('/client/retrait','ClientController::retrait');


$routes->post('/client/transfert','ClientController::transfert');