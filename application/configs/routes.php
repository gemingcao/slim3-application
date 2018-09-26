<?php
// Routes
$app->get('/', 'App\Controllers\IndexController:hello');
$app->get('/hello[/{name}]', 'App\Controllers\IndexController:hello');

$app->group('/admin', function () {
    $this->get('', 'App\Controllers\AdminController:welcome')->setName('adminHome');
});