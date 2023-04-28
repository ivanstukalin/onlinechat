<?php
const DB_HOST = 'db';
require 'vendor/autoload.php';
require 'app/autoload.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

function processInput(string $uri): string
{
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    return $uri;
}

function processOutput(array $response): void
{
    echo json_encode($response);
}

$router = new RouteCollector();

$router->get('/', function(){
    echo file_get_contents('view/index.html');
    die();
});

$router->get('/support', function(){
    echo file_get_contents('view/user/form.html');
    die();
});

$router->get('/help', function(){
    echo file_get_contents('view/operator/form.html');
    die();
});

$router->get('/user', function(){
    return json_encode(\App\Controllers\UserController::get($_GET['id']));
});

$router->get('/operator', function(){
    return json_encode(\App\Controllers\OperatorController::get($_GET['id']));
});

$router->get('/chats/active', function(){
    return json_encode(\App\Controllers\ChatController::listActive());
});

$router->get('/chat', function(){
    return json_encode(\App\Controllers\ChatController::get((int)$_GET['id']));
});

$router->get('/chat/user', function(){
    return json_encode(\App\Controllers\ChatController::getUser((int)$_GET['id']));
});

$router->get('/chat/operator', function(){
    return json_encode(\App\Controllers\ChatController::getOperator((int)$_GET['id']));
});

$router->get('/chat/messages', function(){
    return json_encode(\App\Controllers\ChatController::getMessages((int)$_GET['id']));
});

$router->post('/user/create', function() {
    return json_encode(\App\Controllers\UserController::create($_POST['chat_id']));
});

$router->post('/chat/create', function() {
    return json_encode(\App\Controllers\ChatController::create());
});

$dispatcher = new Dispatcher($router->getData());

try {
    $response = [
        'body' => $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], processInput($_SERVER['REQUEST_URI'])),
        'status' => 200,
    ];
} catch (Throwable $e) {
    $response = [
        'status'  => $e->getCode(),
        'message' => $e->getMessage(),
    ];
}

processOutput($response);
