<?php
const DB_HOST = 'db';
require 'vendor/autoload.php';
require 'app/autoload.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response;
use HttpSoft\Emitter\SapiEmitter;

$request = ServerRequestFactory::fromGlobals();

function processInput(string $uri): string
{
    return urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}

function processOutput(Response $response): void
{
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}

$router = new RouteCollector();

$router->get('/', function(){
    return new Response\HtmlResponse(file_get_contents('view/index.html'));
});

$router->get('/support', function(){
    return new Response\HtmlResponse(file_get_contents('view/user/form.html'));
});

$router->get('/help', function(){
    return new Response\HtmlResponse(file_get_contents('view/operator/form.html'));
});

$router->get('/user', function() use ($request) {
    return new Response\JsonResponse(\App\Controllers\UserController::get($request),);
});

$router->post('/user/create', function() use ($request) {
    return new Response\JsonResponse(\App\Controllers\UserController::create($request));
});

$router->get('/operator', function() use ($request) {
    return new Response\JsonResponse(\App\Controllers\OperatorController::get($request));
});


$router->get('/chat', function() use ($request) {
    return new Response\JsonResponse(\App\Controllers\ChatController::get($request));
});

$router->post('/chat/create', function() use ($request) {
    return new Response\JsonResponse(\App\Controllers\ChatController::create());
});

$router->get('/chats/active', function() {
    return new Response\JsonResponse(\App\Controllers\ChatController::listActive());
});

$router->get('/chat/user', function() use ($request) {
    return new Response\JsonResponse(\App\Controllers\ChatController::getUser($request));
});

$router->get('/chat/operator', function() use ($request) {
    return new Response\JsonResponse(\App\Controllers\ChatController::getOperator($request));
});

$router->get('/chat/messages', function() use ($request) {
    return new Response\JsonResponse(\App\Controllers\ChatController::getMessages($request));
});

$dispatcher = new Dispatcher($router->getData());

try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], processInput($_SERVER['REQUEST_URI']));
} catch (Throwable $e) {
    $response = new Response\TextResponse($e->getMessage(), 400);
}

processOutput($response);
