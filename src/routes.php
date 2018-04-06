<?php

use Slim\Http\Request;
use Slim\Http\Response;

//rutas de usuario

include 'get_datos.php';

// Routes

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
