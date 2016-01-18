<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

echo "<pre>";

$start_memory = memory_get_usage();

use Han\Core\Routing\Router;

include 'Han/autoload.php';

include 'LoggerMiddleware.php';
include 'AuthMiddleware.php';
include 'TaskController.php';
include 'TaskEdit.php';


Router::match('han.cibirlan.com', true)->setCallback(function(){


    Router::match('/')->setCallback(function(){
        echo "home";
    });

    Router::match('user')->setCallback(function(){
        echo "users";
    });

    Router::match('user/{id}')->setCallback(function($id){
        echo "user " . $id;
    });

    //TODO: explore this anomaly
    Router::match('etask')->setController("TaskController");


    Router::group('task')->setController("TaskController");

    Router::group('task')->setMethod("TaskEdit", "username");

    Router::match('blog/{name}')->setCallback(function($name){
        echo "blog/{$name}<br>";
    });


})->setMiddleware([ "LoggerMiddleware", "AuthMiddleware" ]);

echo "</pre>";