<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Start session
session_start();

// Import core classes
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';

// Import models and controllers
require_once __DIR__ . '/../app/Models/Product.php';
require_once __DIR__ . '/../app/Repositories/ProductRepository.php';
require_once __DIR__ . '/../app/Controllers/ProductController.php';

// Create router
$router = new App\Core\Router();

// Define routes
$router->get('/', function() {
    header("Location: /products");
    exit();
});

$router->get('/products', 'ProductController@index');
$router->get('/products/create', 'ProductController@create');
$router->post('/products', 'ProductController@store');
$router->get('/products/{id}', 'ProductController@show');
$router->get('/products/{id}/edit', 'ProductController@edit');
$router->put('/products/{id}', 'ProductController@update');
$router->delete('/products/{id}', 'ProductController@destroy');

// 404 handler
$router->setNotFound(function() {
    http_response_code(404);
    echo "404 - Page Not Found";
});

// Run the router
$router->run();