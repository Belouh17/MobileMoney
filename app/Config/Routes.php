<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
if (ENVIRONMENT === 'development') {
    $routes->get('/test-db', static function () {
        \Config\Database::connect();
        return 'Connexion SQLite OK';
    });
}
$routes->get('/', 'Home::index');
$routes->get('/client/login', 'ClientController::login');
$routes->post('/client/auth', 'ClientController::auth');

$routes->get('/client/dashbord','ClientController::dashbord');
$routes->get('/client/depot', 'ClientController::depotForm');
$routes->get('/client/retrait', 'ClientController::retraitForm');
$routes->get('/client/transfert', 'ClientController::transfertForm');
$routes->post('/client/transfert', 'ClientController::transfert');

$routes->get('/client/historique','ClientController::historique');
$routes->post('/client/retrait', 'ClientController::retrait');
$routes->post('/client/depot','ClientController::depot');

