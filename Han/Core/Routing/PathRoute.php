<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 13.01.2016
 */

namespace Han\Core\Routing;


use Closure;
use Exception;
use Han\Core\Interfaces\MiddlewareInterface;
use Han\Core\Request;

class PathRoute {

    private $isEqual = false;

    private $middlewareNames;
    private $arguments;

    private $callback;
    private $controllerName;
    private $methodName;

    public function __construct($pattern){
        if($pattern == '/' && empty(Request::getPath())){

            $this->isEqual = true;

        } else {

            $patternValid = false;
            $pathArr = Request::getPathArr();
            $patternArr = explode('/', $pattern);
            $argumentsArr = array();

            if(count($pathArr) == count($patternArr)){

                foreach($pathArr as $key => $pathPart){

                    if(substr($patternArr[ $key ], 0, 1) == '{' && substr($patternArr[ $key ], -1) == '}'){

                        if($pathPart){
                            $argumentsArr[] = $pathPart;
                            $patternValid = true;
                        }
                    } else {

                        if($pathPart == $patternArr[ $key ]){
                            $patternValid = true;
                        } else {
                            $patternValid = false;
                            break;
                        }
                    }
                }
            }

            $this->isEqual = $patternValid;

            $this->arguments = $argumentsArr;
        }
    }

    public function equal(){
        return $this->isEqual;
    }

    public function setCallback($callback){
        if($callback instanceof Closure){

            $this->callback = $callback;

            return $this;
        } else {
            throw new Exception("Callback parameter is not a Closure");
        }
    }

    public function setMethod($controllerName, $methodName){
        if(is_string($controllerName) && is_string($methodName)){
            $this->controllerName = $controllerName;
            $this->methodName = $methodName;

            return $this;
        } else {
            throw new Exception("Controller name or method name is not a string");
        }
    }

    public function setController($controllerName){
        if(is_string($controllerName)){
            $this->controllerName = $controllerName;

            return $this;
        } else {
            throw new Exception("Controller name is not a string");
        }
    }

    public function setMiddleware($middlewareNames){
        if(!is_array($middlewareNames) && is_string($middlewareNames)) $middlewareNames = array( $middlewareNames );

        $this->middlewareNames = $middlewareNames;

        return $this;
    }

    public function run(){

        if($this->isEqual){

            $middlewareNext = true;

            if(!$this->middlewareNames) foreach($this->middlewareNames as $middlewareName){
                $middleware = new $middlewareName();
                if($middleware instanceof MiddlewareInterface){
                    $middlewareNext = $middleware->check();
                }
            }

            if($middlewareNext){

                if($this->callback){
                    $callback = $this->callback;

                    if($this->arguments) $callback(...$this->arguments);
                    //call_user_func_array($callback, $this->arguments);
                    else $callback();
                }
                if($this->controllerName){
                    if($this->methodName){
                        $controllerName = $this->controllerName;
                        $controller = new $controllerName();
                        $methodName = $this->methodName;
                        //call_user_func_array(array($controller, $this->methodName), $this->arguments);
                        $controller->$methodName(...$this->arguments);
                    } else {

                    }
                }
            }
        }
    }
}