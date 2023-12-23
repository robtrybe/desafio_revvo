<?php
ob_start();
require('vendor/autoload.php');

use CoffeeCode\Router\Router;

$router = new Router(url());

$router->namespace("Source\Controllers");

$router->get('/course', "CourseController:index");
$router->post('/course', "CourseController:index");

$router->get('/oops/{error_code}', function(?array $data) {
    echo $data['error_code'];
});

$router->dispatch();

if($router->error()) {
    $router->redirect("/oops/{$router->error()}");
}

ob_flush();