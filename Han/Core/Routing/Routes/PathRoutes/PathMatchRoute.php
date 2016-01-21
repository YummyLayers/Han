<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 19.01.2016
 */

namespace Han\Core\Routing\Routes\PathRoutes;


use Han\Core\Routing\Routes\PathRoute;

class PathMatchRoute extends PathRoute {

    public function __construct($pattern){
        if(parent::__construct($pattern)){
            if(count($this->segments) == count($this->patternArr)){
                $this->validatePattern();
            }
        }
    }

    protected function run(){

        if($this->callback){
            $callback = $this->callback;

            if($this->arguments) $callback(...array_values($this->arguments));
            else $callback();
        }

        if($this->controllerName && $this->methodName){
            $this->callMethod($this->controllerName, $this->methodName, $this->arguments);
        }
    }
}