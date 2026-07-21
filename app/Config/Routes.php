<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'ClientController::register');

$routes->get('/operateur/login', 'OperateurController::login');
$routes->post('/login', 'OperateurController::auth');
$routes->get('/operateur/logout', 'OperateurController::logout');

$routes->group('operateur', ['filter' => 'operateurAuth'], function ($routes) {

 $routes->get('dashboard', 'OperateurController::dashboard');

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

    $routes->get('autres-operateurs', 'OperateurController::autresOperateurs');
    $routes->post('autres-operateurs/ajouter', 'OperateurController::ajouterAutreOperateur');
    $routes->post('autres-operateurs/modifier/(:num)', 'OperateurController::modifierAutreOperateur/$1');

    $routes->get('autres-operateurs/(:num)/prefixes', 'OperateurController::prefixesAutreOperateur/$1');
    $routes->post('autres-operateurs/prefixes/ajouter', 'OperateurController::ajouterPrefixeAutreOperateur');
    $routes->post('autres-operateurs/prefixes/supprimer/(:num)', 'OperateurController::supprimerPrefixeAutreOperateur/$1');

    $routes->get('montants-a-envoyer', 'OperateurController::montantsAEnvoyer');
    $routes->get('promotions', 'OperateurController::promotions');
    $routes->post('promotions/modifier', 'OperateurController::modifierPromotion');
});

$routes->group('client', function ($routes) {
    $routes->get('login', 'ClientController::login');
    $routes->post('auth', 'ClientController::auth');
    $routes->get('dashbord', 'ClientController::dashbord');
    $routes->get('historique', 'ClientController::historique');
    $routes->get('logout', 'ClientController::logout');

    $routes->get('depot', 'ClientController::depotForm');
    $routes->post('depot', 'ClientController::depot');

    $routes->get('retrait', 'ClientController::retraitForm');
    $routes->post('retrait', 'ClientController::retrait');

    $routes->get('transfert', 'ClientController::transfertForm');
    $routes->post('transfert', 'ClientController::transfert');

    $routes->get('transfert-multiple', 'ClientController::transfertMultipleForm');
    $routes->post('transfert-multiple', 'ClientController::transfertMultiple');
    $routes->get('epargne', 'ClientController::epargne');
    $routes->post('epargne/definir', 'ClientController::definirEpargne');
});

