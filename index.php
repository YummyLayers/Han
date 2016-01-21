<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

echo "<pre>";

$start_memory = memory_get_usage();

use Han\Core\Request;
use Han\Core\Routing\Router;

include 'Han/autoload.php';

include 'LoggerMiddleware.php';
include 'AuthMiddleware.php';
include 'TaskController.php';
include 'TaskEdit.php';


Router::groupByDomain('han.cibirlan.com')->setCallback(function(){

    Router::group("/name/{name}")->setCallback(function($name){
        echo "Your name is " . $name;
    })->via(Request::POST);

    // TODO: to low case

})->setMiddleware([ "LoggerMiddleware", "AuthMiddleware" ]);

echo "</pre>";