<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('auth/login', 'AuthController::login');
$routes->get('pdf', 'UserController::pdf');

$routes->group('api', ['filter' => 'authFilter'], function($routes) {
    $routes->get('users', 'UserController::index');
    $routes->post('users', 'UserController::store');
    $routes->put('users', 'UserController::update');
    $routes->delete('users', 'UserController::delete');
    $routes->get('users-download', 'UserController::downloadPdf');
});

