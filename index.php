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
    echo "Callback han.cibirlan.com";
})->setMiddleware([ "LoggerMiddleware", "AuthMiddleware" ])->run();
