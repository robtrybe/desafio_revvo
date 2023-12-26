<?php
ob_start();
require('vendor/autoload.php');

use CoffeeCode\Router\Router;

$router = new Router(url());

$router->namespace("Source\Controllers");

$router->get('/course', "CourseController:index");
$router->get('/course/{id}', "CourseController:update");
$router->post('/course', "CourseController:index");
$router->put('/course/{id}', "CourseController:update");

$router->get('/oops/{error_code}', function(?array $data) {
    echo $data['error_code'];
});

$router->dispatch();

if($router->error()) {
    $router->redirect("/oops/{$router->error()}");
}

ob_flush();