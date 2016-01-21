<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 19.01.2016
 */

namespace Han\Core\Routing\Routes\PathRoutes;


use Exception;
use Han\Core\Request;
use Han\Core\Routing\Routes\PathRoute;

class PathGroupRoute extends PathRoute {

    private $nextSegment = false;

    public function __construct($pattern){
        if(parent::__construct($pattern)){
            if(count($this->segments) >= count($this->patternArr)){
                $this->validatePattern();

                if($this->valid){
                    $this->nextSegment = count($this->patternArr);
                }
            }
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

        if($this->controllerName){

            if($this->methodName){

                self::$segmentCounter += $this->nextSegment;

                $this->callMethod($this->controllerName, $this->methodName, $this->arguments);

                self::$segmentCounter -= $this->nextSegment;

            } else {

                // TODO: check Controller instanseof Controller

                self::$segmentCounter += $this->nextSegment + 1;

                if(count($this->segments) > count($this->patternArr) + 1){
                    $this->controllerArgs = array_slice($this->segments, $this->nextSegment + 1);
                } else {
                    $this->controllerArgs = null;
                }

                $this->callMethod(
                    $this->controllerName,
                    Request::getSegments()[ $this->nextSegment ] . 'Action',
                    $this->controllerArgs
                );

                self::$segmentCounter -= $this->nextSegment + 1;
            }

        }

        if($this->callback){
            self::$segmentCounter += $this->nextSegment;

            $callback = $this->callback;

            if($this->arguments) $callback(...array_values($this->arguments));
            else $callback();

            self::$segmentCounter -= $this->nextSegment;
        }
    }
}