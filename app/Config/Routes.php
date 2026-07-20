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
$routes->get('/register', 'ClientController::register');

$routes->group('operateur', function($routes) {
    // Préfixes
    $routes->get('prefixes', 'OperateurController::prefixes');
    $routes->post('prefixes/ajouter', 'OperateurController::ajouterPrefixe');
    $routes->post('prefixes/supprimer/(:num)', 'OperateurController::supprimerPrefixe/$1');

    // Types d'opérations + barèmes
    $routes->get('types', 'OperateurController::types');
    $routes->post('types/ajouter', 'OperateurController::ajouterType');

    $routes->get('baremes/(:num)', 'OperateurController::baremes/$1');           // liste par type
    $routes->post('baremes/ajouter', 'OperateurController::ajouterBareme');
    $routes->post('baremes/modifier/(:num)', 'OperateurController::modifierBareme/$1');
    $routes->post('baremes/supprimer/(:num)', 'OperateurController::supprimerBareme/$1');

    // Rapports
    $routes->get('gains', 'OperateurController::gains');
    $routes->get('comptes', 'OperateurController::comptes');
});
$routes->get('/client/login', 'ClientController::login');
$routes->post('/client/auth', 'ClientController::auth');

$routes->get('/client/dashbord','ClientController::dashbord');


$routes->get('/client/historique','ClientController::historique');


$routes->post('/client/depot','ClientController::depot');


$routes->post('/client/retrait','ClientController::retrait');


$routes->post('/client/transfert','ClientController::transfert');
