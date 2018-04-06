<?php

use Slim\Http\Request;
use Slim\Http\Response;

//rutas de usuario

include 'get_datos.php';

// Routes

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', 'http://10.64.65.200')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/getdata', function (Request $request, Response $response, array $args){

    $DATA = getData();

    return $DATA;
});


$app->get('/tickets', function (Request $request, Response $response, array $args) {
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'ticketlist.phtml', $args);
});

$app->get('/getTickets', function (Request $request, Response $response, array $args){

    $DATA = getTickets();

    return $DATA;
});
