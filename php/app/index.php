<?php
ob_start();
require('vendor/autoload.php');

use CoffeeCode\Router\Router;

$router = new Router(url());

$router->namespace("Source\Controllers");

$router->get('/', "SiteController:home");
$router->get('/login', "LoginController:login");
$router->post('/login', "LoginController:login");
$router->get('/logout', "LoginController:logout");
$router->get('/course/{id}', "CourseController:show");

$router->get('/admin', "AdminController:dash");
$router->get('/admin/course/create', "CourseController:store");
$router->post('/admin/course/create', "CourseController:store");
$router->get('/admin/course/{id}/edit', "CourseController:update");
$router->put('/admin/course/{id}/edit', "CourseController:update");
$router->delete('/admin/course/{id}', "CourseController:delete");

$router->get('/oops/{error_code}', function(?array $data) {
    echo $data['error_code'];
});

$router->dispatch();

if($router->error()) {
    $router->redirect("/oops/{$router->error()}");
}

ob_flush();