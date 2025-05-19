<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// Admin Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('reports', 'Dashboard::reports');
    $routes->post('generate-report', 'Dashboard::generateReport');

    // Departments
    $routes->get('departments', 'Departments::index');
    $routes->get('departments/new', 'Departments::new');
    $routes->post('departments/create', 'Departments::create');
    $routes->get('departments/edit/(:num)', 'Departments::edit/$1');
    $routes->post('departments/update/(:num)', 'Departments::update/$1');
    $routes->get('departments/delete/(:num)', 'Departments::delete/$1');

    // Documents
    $routes->get('documents', 'Documents::index');
    $routes->get('documents/view/(:num)', 'Documents::view/$1');
    $routes->post('documents/update-status/(:num)', 'Documents::updateStatus/$1');
    $routes->get('documents/history/(:num)', 'Documents::history/$1');
    $routes->get('documents/download/(:num)', 'Documents::download/$1');

    // Users
    $routes->get('users', 'Users::index');
    $routes->get('users/new', 'Users::new');
    $routes->post('users/create', 'Users::create');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
    $routes->get('users/delete/(:num)', 'Users::delete/$1');
    $routes->get('users/reset-password/(:num)', 'Users::resetPassword/$1');

    // Categories
    $routes->get('categories', 'Categories::index');
    $routes->get('new', 'Categories::new');
    $routes->post('create', 'Categories::create');
    $routes->get('edit/(:num)', 'Categories::edit/$1');
    $routes->post('update/(:num)', 'Categories::update/$1');
    $routes->post('delete/(:num)', 'Categories::delete/$1');
});



// User Routes
$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'UserDashboard::index');
    $routes->get('submissions', 'UserDashboard::submissions');
    
    $routes->group('submit', function($routes) {
        $routes->get('/', 'UserDashboard::submitDocument');
        $routes->post('save', 'UserDashboard::saveSubmission');
    });
    
    $routes->group('resubmit', function($routes) {
        $routes->get('(:num)', 'UserDashboard::resubmitDocument/$1');
        $routes->post('update/(:num)', 'UserDashboard::updateSubmission/$1');
    });
    
    $routes->get('requirements', 'UserDashboard::requirements');
    $routes->get('notifications', 'UserDashboard::notifications');
    $routes->get('profile', 'UserDashboard::profile');
    $routes->post('profile/update', 'UserDashboard::updateProfile');
    $routes->get('download/template/(:num)', 'UserDashboard::downloadTemplate/$1');
    $routes->get('download/(:num)', 'UserDashboard::downloadSubmission/$1');
});

//Authentication Routes
$routes->get('login', 'Auth::login');
$routes->post('login/attempt', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password/send', 'Auth::sendResetLink');
$routes->get('reset-password/(:any)', 'Auth::resetPassword/$1');
$routes->post('reset-password/(:any)', 'Auth::updatePassword/$1');