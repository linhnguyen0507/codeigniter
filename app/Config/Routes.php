<?php

use App\Controllers\News;
use App\Controllers\Pages;
use App\Controllers\Auth;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', [Auth::class, 'view']);           
$routes->post('login', [Auth::class, 'login']);           
$routes->get('register', [Auth::class, 'view']);           
$routes->post('register', [Auth::class, 'register']);   
$routes->group('admin', ['filter' => 'permission'], function ($routes) {
    $routes->get('/', [News::class, 'index']);           
    $routes->get('news/new', [News::class, 'new']);

});

$routes->group('leader', ['filter' => 'permission'], function ($routes) {
    $routes->get('/', [News::class, 'index']);           
    
});

$routes->group('member', ['filter' => 'permission'], function ($routes) {
    $routes->get('/', [News::class, 'index']);           
$routes->get('news/new', [News::class, 'new']);
});     
// $routes->get('news', [News::class, 'index']);           
// $routes->get('news/new', [News::class, 'new']); // Add this line
// $routes->post('news', [News::class, 'create']); // Add this line
// $routes->get('news/(:segment)', [News::class, 'show']);
//  $routes->get('pages', [Pages::class, 'index']);
//  $routes->get('(:segment)', [Pages::class, 'view']);
