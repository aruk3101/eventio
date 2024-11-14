<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/user/events', 'EventController::myEvents');
$routes->get('/user/edit', 'UserController::edit');
$routes->post('/user/edit/submit', 'UserController::submitEdit');
$routes->get('/user/login', 'UserController::login');
$routes->post('/user/login/submit', 'UserController::submitLogin');
$routes->post('/user/register/submit', 'UserController::submitRegister');
$routes->get('/user/register', 'UserController::register');
$routes->get('/user', 'UserController::index');
$routes->get('/events/add', 'EventController::addEvent');
$routes->post('/events/add/submit', 'EventController::submitAddEvent');
$routes->get('/events/view/(:num)', 'EventController::view/$1');
$routes->get('/', 'Home::index');
$routes->get('/events/events', 'EventController::events');
$routes->post('/events/register/(:num)', 'EventController::register/$1');
$routes->get('/events/unregister/(:num)', 'EventController::unregister/$1');
$routes->get('/events/edit/(:num)', 'EventController::edit/$1');
$routes->post('/events/update/(:num)', 'EventController::update/$1');
$routes->post('/events/addMedia/(:num)', 'EventController::addMedia/$1');
$routes->get('/events/deleteMedia/(:num)', 'EventController::deleteMedia/$1');
