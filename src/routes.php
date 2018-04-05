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