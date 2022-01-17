<?php

$includePath = __DIR__ . "/..";
include '../bootstrap.php';

use lib\CRUD;
use lib\Router;
use function lib\Request\parseJsonFromRequest;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

Router::get('/', function () {
    return CRUD::readAll();
});

Router::get('/{id}', function ($id) {
    return CRUD::read($id);
});

Router::post('/', function () {    
    $payload = parseJsonFromRequest();
    return CRUD::create($payload);
});

Router::delete('/{id}', function ($id) {
    return CRUD::delete($id);
});

Router::put('/{id}', function ($id) {
    $payload = parseJsonFromRequest();
    return CRUD::update($id, $payload);
});

Router::notFound(function () {
    return "Error 404";
});
