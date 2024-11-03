<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('user/edit', 'UserController::edit');
$routes->post('user/edit/submit', 'UserController::submitEdit');
$routes->get('/user/login', 'UserController::login');
$routes->post('/user/login/submit', 'UserController::submitLogin');
$routes->post('/user/register/submit', 'UserController::submitRegister');
$routes->get('/user/register', 'UserController::register');
$routes->get('/user', 'UserController::index');
$routes->get('/', 'Home::index');
