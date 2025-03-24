<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Accounts Routes
$routes->get('/', 'Home::index');
$routes->get('/user', 'AccountController::user');
$routes->get('/register', 'AccountController::register');
$routes->match(['get','post'],'/regcomplete','AccountController::regcomplete');
$routes->get('/regcomplete', 'AccountController::regcomplete');
$routes->get('/signin', 'AccountController::signin');
$routes->get('/register_verify/(:any)', 'AccountController::register_verify/$1');
$routes->match(['get','post'],'/signin_verify','AccountController::signin_verify');
$routes->get('/signout', 'AccountController::signout');

//Contacts Routes
$routes->match(['get','post'],'/contacts','ContactsController::contacts');
$routes->match(['get','post'],'/add_contacts','ContactsController::add_contacts');
$routes->match(['get','post'],'/search_contacts','ContactsController::search_contacts');
$routes->match(['get','post'],'/edit_contacts','ContactsController::edit_contacts');
$routes->match(['get','post'],'/delete_contact','ContactsController::delete_contact');





