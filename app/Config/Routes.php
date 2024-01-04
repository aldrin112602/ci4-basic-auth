<?php

use App\Controllers\AuthController;
use App\Controllers\LoginController;
use App\Controllers\SignupController;
use App\Controllers\ProfileController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'SignupController::index');
$routes->get('/register', 'SignupController::index');
$routes->match(['get', 'post'], 'SignupController/store', 'SignupController::store');
$routes->match(['get', 'post'], 'LoginController/loginAuth', 'LoginController::loginAuth');
$routes->get('/login', 'LoginController::index');
$routes->get('/profile', 'ProfileController::index',['filter' => 'authGuard']);
$routes->get('/dashboard', 'ProfileController::dashboard',['filter' => 'authGuard']);