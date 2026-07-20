<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'ClientController::register');

$routes->group('operateur', ['filter' => 'operateurAuth'], function($routes) {
$routes->get('/operateur/login', 'OperateurController::login');
$routes->post('/login', 'OperateurController::auth');   // correspond à action="/login" de ta vue
$routes->get('/operateur/logout', 'OperateurController::logout');

    $routes->get('prefixes', 'OperateurController::prefixes');
    $routes->post('prefixes/ajouter', 'OperateurController::ajouterPrefixe');
    $routes->post('prefixes/supprimer/(:num)', 'OperateurController::supprimerPrefixe/$1');

    $routes->get('types', 'OperateurController::types');
    $routes->post('types/ajouter', 'OperateurController::ajouterType');

    $routes->get('baremes/(:num)', 'OperateurController::baremes/$1');
    $routes->post('baremes/ajouter', 'OperateurController::ajouterBareme');
    $routes->post('baremes/modifier/(:num)', 'OperateurController::modifierBareme/$1');
    $routes->post('baremes/supprimer/(:num)', 'OperateurController::supprimerBareme/$1');

    $routes->get('gains', 'OperateurController::gains');
    $routes->get('comptes', 'OperateurController::comptes');
});

$routes->group('client', function ($routes) {
    $routes->get('login', 'ClientController::login');
    $routes->post('auth', 'ClientController::auth');
    $routes->get('dashbord', 'ClientController::dashbord');
    $routes->get('historique', 'ClientController::historique');

    // formulaire (GET) + traitement (POST) séparés
    $routes->get('depot', 'ClientController::depotForm');
    $routes->post('depot', 'ClientController::depot');

    $routes->get('retrait', 'ClientController::retraitForm');
    $routes->post('retrait', 'ClientController::retrait');

    $routes->get('transfert', 'ClientController::transfertForm');
    $routes->post('transfert', 'ClientController::transfert');

    $routes->get('logout', 'ClientController::logout');
});