<?php
// Show errors for debugging (turn off in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set JSON response header
header("Content-Type: application/json");

// Load Router class
require_once __DIR__ . '/router.php';

// Get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base path (adjust this to your project folder)
$uri = str_replace('/LibraryManagementSystem/app/routes/api.php', '', $uri);

$method = $_SERVER['REQUEST_METHOD'];

// Initialize Router and dispatch request
$router = new Router();
$router->dispatch($uri, $method);
