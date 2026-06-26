<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 *
 * TickTrack Routing Configuration
 */

// ── Landing Page ──
$routes->get('/', 'Home::index');

// ── About Us ──
$routes->get('about', 'Home::about');

// ══════════════════════════════════════
// AUTH ROUTES (guest only)
// ══════════════════════════════════════
$routes->group('auth', ['filter' => 'guest'], static function ($routes) {
    $routes->get('login',              'AuthController::login');
    $routes->post('login',             'AuthController::attemptLogin');
    $routes->get('register',           'AuthController::register');
    $routes->post('register',          'AuthController::attemptRegister');
    $routes->get('forgot-password',    'AuthController::forgotPassword');
    $routes->post('forgot-password',   'AuthController::processForgotPassword');
    $routes->get('reset-password/(:segment)',  'AuthController::resetPassword/$1');
    $routes->post('reset-password',    'AuthController::processResetPassword');
});

// Logout bisa diakses siapa saja yang sudah login
$routes->get('auth/logout', 'AuthController::logout', ['filter' => 'auth']);

// ══════════════════════════════════════
// USER ROUTES (auth required, role: user)
// ══════════════════════════════════════
$routes->group('user', ['filter' => 'auth', 'namespace' => 'App\Controllers\User'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    // Tiket
    $routes->get('tickets',              'TicketController::index');
    $routes->get('tickets/create',       'TicketController::create');
    $routes->post('tickets/store',       'TicketController::store');
    $routes->get('tickets/(:segment)',   'TicketController::show/$1');
    $routes->post('tickets/(:segment)/status', 'TicketController::updateStatus/$1');
    $routes->post('tickets/(:segment)/reply', 'TicketController::reply/$1');

    // Profil
    $routes->get('profile',       'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');

    // Notifikasi
    $routes->get('notifications', 'NotificationController::index');
});

// ══════════════════════════════════════
// ADMIN ROUTES (auth + admin required)
// ══════════════════════════════════════
$routes->group('admin', ['filter' => ['auth', 'admin'], 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    // Tiket Admin
    $routes->get('tickets',                     'TicketController::index');
    $routes->get('tickets/(:segment)',          'TicketController::show/$1');
    $routes->post('tickets/(:segment)/status',  'TicketController::updateStatus/$1');
    $routes->post('tickets/(:segment)/reply',   'TicketController::reply/$1');
    $routes->delete('tickets/(:segment)',       'TicketController::delete/$1');

    // CRUD User
    $routes->get('users',              'UserController::index');
    $routes->get('users/create',       'UserController::create');
    $routes->post('users/store',       'UserController::store');
    $routes->get('users/(:num)/edit',  'UserController::edit/$1');
    $routes->post('users/(:num)/update', 'UserController::update/$1');
    $routes->delete('users/(:num)',    'UserController::delete/$1');

    // Kategori
    $routes->get('categories',               'CategoryController::index');
    $routes->post('categories/store',        'CategoryController::store');
    $routes->post('categories/(:num)/update','CategoryController::update/$1');
    $routes->delete('categories/(:num)',     'CategoryController::delete/$1');

    // Laporan
    $routes->get('reports',                  'ReportController::index');

    // Pengaturan
    $routes->get('settings',        'SettingController::index');
    $routes->post('settings/save',  'SettingController::save');

    // Profil Admin
    $routes->get('profile',                  'ProfileController::index');
    $routes->post('profile/update',          'ProfileController::update');

    // Notifikasi
    $routes->get('notifications',            'NotificationController::index');
});

// ══════════════════════════════════════
// API ROUTES — Notifikasi (auth required)
// ══════════════════════════════════════
$routes->group('api', ['filter' => 'auth', 'namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('notifications/fetch', 'NotificationAPIController::fetch');
    $routes->post('notifications/read', 'NotificationAPIController::markAsRead');
});

// ══════════════════════════════════════
// REST API ROUTES — CRUD Resources
// ══════════════════════════════════════
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    $routes->resource('users',      ['controller' => 'Users']);
    $routes->resource('tickets',    ['controller' => 'Tickets']);
    $routes->resource('categories', ['controller' => 'Categories']);
});
