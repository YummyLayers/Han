<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 19.01.2016
 */

namespace Han\Core\Routing\Routes\PathRoutes;


use Exception;
use Han\Core\Interfaces\MiddlewareInterface;
use Han\Core\Request;
use Han\Core\Routing\Routes\PathRoute;

class PathGroupRoute extends PathRoute {

    private $nextSegment = false;

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

            if(count($this->pathArr) > count($this->patternArr)){

                foreach($this->patternArr as $key => $patternPart){
                    if($patternPart == $this->pathArr[ $key ]){
                        $pathValid = true;
                    } else {
                        $pathValid = false;
                        break;
                    }
                }
                if($pathValid){
                    $this->nextSegment = count($this->patternArr);
                }
            }

            $this->valid = $pathValid;

            $this->arguments = $argumentsArr;
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

                if($this->controllerName){

                    if($this->methodName){

                        self::$segmentCounter += $this->nextSegment;

                        $this->callMethod($this->controllerName, $this->methodName, $this->arguments);

                        self::$segmentCounter -= $this->nextSegment;

                    } else {

                        // TODO: check Controller instanseof Controller

                        self::$segmentCounter += $this->nextSegment + 1;

                        if(count($this->pathArr) > count($this->patternArr) + 1){
                            $this->controllerArgs = array_slice($this->pathArr, $this->nextSegment + 1);
                        } else {
                            $this->controllerArgs = null;
                        }

                        $this->callMethod(
                            $this->controllerName,
                            Request::getPathArr()[ $this->nextSegment ] . 'Action',
                            $this->controllerArgs
                        );

                        self::$segmentCounter -= $this->nextSegment + 1;
                    }

                }

                if($this->callback){
                    self::$segmentCounter += $this->nextSegment;

                    $callback = $this->callback;

                    if($this->arguments) $callback(...$this->arguments);
                    else $callback();

                    self::$segmentCounter -= $this->nextSegment;
                }
            }
        }
    }
}