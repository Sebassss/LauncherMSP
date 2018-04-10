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
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:81')
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

$app->get('/sendticket', function (Request $request, Response $response, array $args){


    //return $response->withJson($a,200);


    $url= 'http://10.64.65.200:84/otrs/nph-genericinterface.pl/Webservice/bott/Ticket?UserLogin=LauncherMSP&Password=123456';

     $data = array(
        'Ticket' => array(
            'QueueID' => 38,
            'PriorityID'=> '3',
            'CustomerUser'=> $request->getParam('customer'),
            'Title'=> $request->getParam('title'),
            'StateID'=> '1',
            'Type'=> $request->getParam('type')
            
        ),
        'Article' => array(
            'ContentType'=>'text/plain; charset=utf8',
            'Subject'=> $request->getParam('subject'),
            'Body'=> $request->getParam('body')
        )
    );

    $content = json_encode($data);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
/*
    if ( $status != 201 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
*/

    curl_close($curl);

    //$response = json_decode($json_response, true);

    //return $json_response;
    return $response->withJson(json_decode($json_response, true),200);

});