<?php

namespace Config;

use Myth\Auth\Config\Auth as AuthConfig;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index', ['filter' => 'login']);
$routes->get('phpinfo', 'Home::phpinfo');
$routes->get('trial', 'Home::trial');
$routes->get('migration', 'Home::migration');

// Myth/Auth Routes
$routes->group('/', static function ($routes) {
    $config         = config(AuthConfig::class);
    $reservedRoutes = $config->reservedRoutes;

    // Login/out
    $routes->get($reservedRoutes['login'], 'Auth::login', ['as' => 'login']);
    $routes->post($reservedRoutes['login'], 'Auth::attemptLogin');
    $routes->get($reservedRoutes['logout'], 'Auth::logout', ['as' => 'logout']);

    // Registration
    $routes->get($reservedRoutes['register'], 'Auth::register', ['as' => 'register']);
    $routes->post($reservedRoutes['register'], 'Auth::attemptRegister');

    // Activation
    $routes->get($reservedRoutes['activate-account'], 'Auth::activateAccount', ['as' => 'activate-account']);
    $routes->get($reservedRoutes['resend-activate-account'], 'Auth::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/Resets
    $routes->get($reservedRoutes['forgot'], 'Auth::forgotPassword', ['as' => 'forgot']);
    $routes->post($reservedRoutes['forgot'], 'Auth::attemptForgot');
    $routes->get($reservedRoutes['reset-password'], 'Auth::resetPassword', ['as' => 'reset-password']);
    $routes->post($reservedRoutes['reset-password'], 'Auth::attemptReset');
});

// Require login
$routes->group('', ['filter' => 'login'], function($routes) {
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('myaccount', 'Account::index');
    $routes->post('updateaccount', 'Account::updateaccount');
});

// User/Member
$routes->group('users', ['filter' => 'login'], function($routes) {
    $routes->get('', 'Account::list', ['filter' => 'role:owner,staff']);
    $routes->get('newmember', 'Account::newmember', ['filter' => 'role:owner,staff']);
    $routes->post('create', 'Account::createmember', ['filter' => 'role:owner,staff']);
    $routes->get('checkin', 'Account::checkin', ['filter' => 'role:owner,staff']);
    $routes->post('checked', 'Account::checked', ['filter' => 'role:owner,staff']);
    $routes->get('extend', 'Account::extend', ['filter' => 'role:owner,staff']);
    $routes->post('extending', 'Account::extending', ['filter' => 'role:owner,staff']);
    $routes->get('update/(:num)', 'Account::update/$1', ['filter' => 'role:owner,staff']);
    $routes->post('updating', 'Account::updating', ['filter' => 'role:owner,staff']);
    $routes->post('delete', 'Account::delete', ['filter' => 'role:owner,staff']);
});

// Report
$routes->group('report', ['filter' => 'login'], function($routes) {
    $routes->get('checkin', 'Report::checkin', ['filter' => 'role:owner,staff']);
});

// Promo
$routes->group('promo', ['filter' => 'login'], function($routes) {
    $routes->get('', 'Promo::index', ['filter' => 'role:owner,staff']);
    $routes->post('create', 'Promo::create', ['filter' => 'role:owner,staff']);
    $routes->post('update/(:num)', 'Promo::update/$1', ['filter' => 'role:owner,staff']);
    $routes->post('delete', 'Promo::delete', ['filter' => 'role:owner,staff']);
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
