<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 19.01.2016
 */

namespace Han\Core\Routing\Routes\PathRoutes;


use Han\Core\Interfaces\MiddlewareInterface;
use Han\Core\Request;
use Han\Core\Routing\Routes\PathRoute;

class PathMatchRoute extends PathRoute {

    public function __construct($pattern){
        $this->pattern = $pattern;

        if($pattern == '/' && empty(Request::getPath())){

            $this->valid = true;

        } else {

            $pathValid = false;
            $this->pathArr = Request::getPathArr();
            $this->patternArr = explode('/', $pattern);
            $argumentsArr = array();

            if(self::$segmentCounter > 0){
                $this->pathArr = array_slice($this->pathArr, self::$segmentCounter);
            }


            if(count($this->pathArr) == count($this->patternArr)){

                foreach($this->pathArr as $key => $pathPart){
                    if(substr($this->patternArr[ $key ], 0, 1) == '{' && substr($this->patternArr[ $key ], -1) == '}'){

                        if($pathPart){
                            $argumentsArr[] = $pathPart;
                            $pathValid = true;
                        }
                    } else {

                        if($pathPart == $this->patternArr[ $key ]){
                            $pathValid = true;
                        } else {
                            $pathValid = false;
                            break;
                        }
                    }
                }

            }

            $this->valid = $pathValid;

            $this->arguments = $argumentsArr;
        }
    }

    protected function run(){
        if($this->valid){

            $middlewareNext = true;

            if(is_array($this->middlewareNames)) foreach($this->middlewareNames as $middlewareName){
                $middleware = new $middlewareName();
                if($middleware instanceof MiddlewareInterface){
                    $middlewareNext = $middleware->check();
                }
            }

            if($middlewareNext){

                if($this->callback){
                    $callback = $this->callback;

                    if($this->arguments) $callback(...$this->arguments);
                    else $callback();
                }

                if($this->controllerName && $this->methodName){
                    $this->callMethod($this->controllerName, $this->methodName, $this->arguments);
                }
            }
        }
    }
}