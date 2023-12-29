<?php
ob_start();
require('vendor/autoload.php');

use CoffeeCode\Router\Router;

$router = new Router(url());

$router->namespace("Source\Controllers");

$router->get('/', "SiteController:home");
$router->get('/course', "CourseController:index");
$router->get('/course/{id}', "CourseController:show");
$router->put('/course/{id}', "CourseController:update");
$router->delete('/course/{id}', "CourseController:delete");

$router->get('/admin', "AdminController:dash");
$router->get('/admin/course/create', "CourseController:store");
$router->post('/admin/course/create', "CourseController:store");

$router->get('/oops/{error_code}', function(?array $data) {
    echo $data['error_code'];
});

$router->dispatch();

if($router->error()) {
    $router->redirect("/oops/{$router->error()}");
}

ob_flush();