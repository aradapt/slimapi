<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

// Customer Routes
//require '../src/routes/customers.php';

//entitys Routes
require '../src/routes/entitys.php';

//diysis Routes
//require '../src/routes/diysis.php';

// Customer Routes
//require '../src/routes/venders.php';

// Rawdata Routes
//require '../src/routes/rawdatas.php';
$app->run();