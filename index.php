<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

$start_memory = memory_get_usage();

use Han\Core\Routing\Router;

include 'Han/autoload.php';

include 'LoggerMiddleware.php';
include 'AuthMiddleware.php';
include 'TaskController.php';
include 'TaskEdit.php';


Router::match('han.cibirlan.com', true)->setCallback(function (){


    Router::match('/')->setCallback(function(){
        echo "home";
    });

    Router::match('user')->setCallback(function(){
        echo "users";
    });

    Router::match('user/{id}')->setCallback(function($id){
        echo "user " . $id;
    });

    Router::match('task/edit/username/{name}')->setMethod("TaskEdit", "username");

    Router::match('task')->setController("TaskController");


})->setMiddleware([ "LoggerMiddleware", "AuthMiddleware" ]);