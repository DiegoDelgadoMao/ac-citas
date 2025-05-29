<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Público
$routes->get('/', 'Home::index');
$routes->post('/registro-usuario', 'Home::registroUsuario');
$routes->match(['get', 'post'], '/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// Rutas que requieren sesión iniciada
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Dashboard del cliente (rol 3) — cualquier logged-in puede entrar,
    // pero desde Auth ya redirigimos a este path sólo al rol 3
    $routes->get('/dashboard', 'Cliente::dashboard');
    // Panel Admin (rol 1)
    $routes->group('admin', ['filter' => 'role:1'], static function ($routes) {
        $routes->get('dashboard', 'Admin::dashboard');
        // aquí añadirás más rutas administrativas
    });
    // Panel Técnico (rol 2)
    $routes->group('tecnico', ['filter' => 'role:2'], static function ($routes) {
        $routes->get('dashboard', 'Tecnico::dashboard');
        $routes->get('completar/(:num)', 'Tecnico::completar/$1');
        // aquí añadirás más rutas para técnicos
    });
    // CRUD técnicos
    $routes->group('/tecnicos', static function ($routes) {
        $routes->get('/',            'Tecnicos::index');   // lista
        $routes->get('create',       'Tecnicos::create');  // form nuevo
        $routes->post('store',       'Tecnicos::store');   // guardar
        $routes->get('edit/(:num)',  'Tecnicos::edit/$1'); // form editar
        $routes->post('update/(:num)', 'Tecnicos::update/$1');
        $routes->get('delete/(:num)', 'Tecnicos::delete/$1');
    });
    // CRUD USUARIOS
    $routes->group('/usuarios', ['filter' => 'role:1'], static function ($routes) {
        $routes->get('/',            'Usuarios::index');          // lista
        $routes->get('create',       'Usuarios::create');         // form nuevo
        $routes->post('store',       'Usuarios::store');
        $routes->get('edit/(:num)',  'Usuarios::edit/$1');        // form editar
        $routes->post('update/(:num)', 'Usuarios::update/$1');
        $routes->get('delete/(:num)', 'Usuarios::delete/$1');
    });
    $routes->group('/admin/citas', static function ($routes) {
        $routes->get('/',              'CitasAdmin::index');       // lista
        $routes->get('cambiar/(:num)/(:alpha)', 'CitasAdmin::cambiar/$1/$2'); // estado
        $routes->get('delete/(:num)',  'CitasAdmin::delete/$1');   // opcional
    });
    $routes->group('/citas', ['filter' => ['auth', 'role:3']], static function ($routes) {
        $routes->get('crear', 'CitasCliente::create'); // formulario
        $routes->post('store', 'CitasCliente::store'); // guardar
        $routes->get('cancelar/(:num)', 'CitasCliente::cancel/$1'); // opcional
    });
});
