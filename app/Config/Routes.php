<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'ClientController::register');

// ---------- OPÉRATEUR (sans auth) ----------
$routes->get('/operateur/login', 'OperateurController::login');
$routes->post('/operateur/auth', 'OperateurController::auth');
$routes->get('/operateur/logout', 'OperateurController::logout');

$routes->get('operateur/dashboard', 'OperateurController::dashboard');

$routes->get('operateur/prefixes', 'OperateurController::prefixes');
$routes->post('operateur/prefixes/ajouter', 'OperateurController::ajouterPrefixe');
$routes->post('operateur/prefixes/supprimer/(:num)', 'OperateurController::supprimerPrefixe/$1');

$routes->get('operateur/types', 'OperateurController::types');
$routes->post('operateur/types/ajouter', 'OperateurController::ajouterType');

$routes->get('operateur/baremes/(:num)', 'OperateurController::baremes/$1');
$routes->post('operateur/baremes/ajouter', 'OperateurController::ajouterBareme');
$routes->post('operateur/baremes/modifier/(:num)', 'OperateurController::modifierBareme/$1');
$routes->post('operateur/baremes/supprimer/(:num)', 'OperateurController::supprimerBareme/$1');

$routes->get('operateur/gains', 'OperateurController::gains');
$routes->get('operateur/comptes', 'OperateurController::comptes');

$routes->get('operateur/autres-operateurs', 'OperateurController::autresOperateurs');
$routes->post('operateur/autres-operateurs/ajouter', 'OperateurController::ajouterAutreOperateur');
$routes->post('operateur/autres-operateurs/modifier/(:num)', 'OperateurController::modifierAutreOperateur/$1');

$routes->get('operateur/autres-operateurs/(:num)/prefixes', 'OperateurController::prefixesAutreOperateur/$1');
$routes->post('operateur/autres-operateurs/prefixes/ajouter', 'OperateurController::ajouterPrefixeAutreOperateur');
$routes->post('operateur/autres-operateurs/prefixes/supprimer/(:num)', 'OperateurController::supprimerPrefixeAutreOperateur/$1');

$routes->get('operateur/montants-a-envoyer', 'OperateurController::montantsAEnvoyer');

// ---------- CLIENT ----------
$routes->group('client', function ($routes) {
    $routes->get('login', 'ClientController::login');
    $routes->post('auth', 'ClientController::auth');
    $routes->get('dashboard', 'ClientController::dashboard');
    $routes->get('historique', 'ClientController::historique');

    $routes->get('depot', 'ClientController::depotForm');
    $routes->post('depot', 'ClientController::depot');

    $routes->get('retrait', 'ClientController::retraitForm');
    $routes->post('retrait', 'ClientController::retrait');

    $routes->get('transfert', 'ClientController::transfertForm');
    $routes->post('transfert', 'ClientController::transfert');

    $routes->get('logout', 'ClientController::logout');

    $routes->get('transfert-multiple', 'ClientController::transfertMultipleForm');
    $routes->post('transfert-multiple', 'ClientController::transfertMultiple');
});