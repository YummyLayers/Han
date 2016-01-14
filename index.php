<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

use Han\Core\Routing\Router;

include 'Han/autoload.php';

include 'LoggerMiddleware.php';
include 'AuthMiddleware.php';
include 'TaskController.php';


Router::match('han.cibirlan.com', true)->setCallback(function (){


    Router::match('/')->setCallback(function(){
        echo "home";
    })->run();

    Router::match('user')->setCallback(function(){
        echo "users";
    })->run();

    Router::match('user/{id}/{id2}/{id3}')->setCallback(function($id){
        echo "user " . $id;
    })->run();

    Router::match('task/edit/{id}')->setMethod("TaskController", "edit")->run();

    // task/edit/4
    Router::match('task@dfg')->setController("TaskController@dfg")->run();


})->setMiddleware([ "LoggerMiddleware", "AuthMiddleware" ])->run();
