<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('tasks', 'Tasks::index');
$routes->post('tasks', 'Tasks::create', ['filter' => 'csrf']);
$routes->get('tasks/(:num)/edit', 'Tasks::edit/$1');
$routes->post('tasks/(:num)/update', 'Tasks::update/$1', ['filter' => 'csrf']);
$routes->post('tasks/(:num)/start', 'Tasks::start/$1', ['filter' => 'csrf']);
$routes->post('tasks/(:num)/toggle', 'Tasks::toggle/$1', ['filter' => 'csrf']);
$routes->post('tasks/(:num)/delete', 'Tasks::delete/$1', ['filter' => 'csrf']);
$routes->get('profile', 'Profile::index');
$routes->get('about', 'About::index');
