<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 19.01.2016
 */

namespace Han\Core\Routing\Routes;


use Exception;
use Han\Core\Routing\Route;

abstract class PathRoute extends Route {

    protected static $segmentCounter = 0;

    protected $controllerName;
    protected $methodName;

    protected $controllerArgs = array();

    protected $pathArr;
    protected $patternArr;

    protected $arguments;

    public function setMethod($controllerName, $methodName){
        if(is_string($controllerName) && is_string($methodName)){
            $this->controllerName = $controllerName;
            $this->methodName = $methodName;

            return $this;
        } else {
            throw new Exception("Controller name or method name is not a string");
        }
    }

    protected function callMethod($className, $methodName, array $args = null){
        $obj = new $className();
        if(!empty($args)) $obj->$methodName(...$args);
        else $obj->$methodName();
    }

}