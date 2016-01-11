<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

include( "Han/autoload.php" );

use Han\Core\Routing\DomainRouter;
use Han\Core\Routing\PathRouter;
//use Han\Core\Request;

$domainRouter = new DomainRouter();
$pathRouter = new PathRouter();
//$request = new Request();

//var_dump($request->getPath());


include("LoggerMiddleware.php");
include("AuthMiddleware.php");
include("TaskController.php");


$domainRouter->route("han.cibirlan.com", function() use($pathRouter){

    $pathRouter->get("/", function(){
        echo "Main";
    });

    $pathRouter->controlle(['GET', 'POST'], "task", 'TaskController');

    //$pathRouter->get("task", 'TaskController');

    $pathRouter->get("login/user", function(){
        echo "Validate login for user";
    });

    // login/user/3/level/10 
    $pathRouter->get("login/user/{user_id}/level/{level_id}", function($user_id, $level_id){
        echo "Login user page ".$user_id." ".$level_id;
    });

}, ['LoggerMiddleware','AuthMiddleware']);


$domainRouter->route("api.han.cibirlan.com", function() use($pathRouter){

    // user/3
    $pathRouter->any("user/{id}", function($id){
        echo "User ".$id;
    });

    $pathRouter->any("product/{categoty_id}/{product_id}", function($category_id, $product_id){
        echo "Product ".$product_id.' in category '.$category_id;
    });

});
