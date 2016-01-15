<?php

/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

class TaskController {

    function action(){
        echo "indexAction";
    }

    function createAction(){
        echo "createAction";
    }

    function editAction($id = null){

        echo "editAction " . $id . '<br>';
    }

}