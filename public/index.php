<?php

use app\controllers\SiteController;
use app\core\Application;

include __DIR__."/../vendor/autoload.php";

$app = new Application(dirname(__DIR__));


$app->router->get('/',[SiteController::class, 'home']);

$app->router->get('/users', function(){
    return "Users";
});

$app->router->get('/contact', 'contact');
$app->router->post('/contact',[SiteController::class, 'contact']);

$app->run();
