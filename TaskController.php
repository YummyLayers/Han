<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

use Han\Core\Routing\Router;

class TaskController {

    function action($id = null){
        echo "indexAction " . $id;
    }

    function createAction(){
        echo "createAction<br><br>";
        // task/create/blog/asd
        Router::match('blog/{name}')->setCallback(function($name){
            echo "task/create/blog/{$name}<br>";
        });
    }

    function editAction($id = null){
        echo "editAction " . $id . '<br>';
    }

}