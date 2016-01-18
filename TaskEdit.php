<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 16.01.2016
 */

use Han\Core\Routing\Router;

class TaskEdit {

    function username(){
        echo "username<br><br>";

        // task/blog/asd
        Router::match('blog/{name}')->setCallback(function($name){
            echo "task/blog/{$name}<br>";
        });
    }

    function usersex($sex = null){
        echo "usersex " . $sex . "<br>";
    }

}