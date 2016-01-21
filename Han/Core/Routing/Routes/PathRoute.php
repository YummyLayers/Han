<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 19.01.2016
 */

namespace Han\Core\Routing\Routes;


use Exception;
use Han\Core\Request;
use Han\Core\Routing\Route;

abstract class PathRoute extends Route {

    protected static $segmentCounter = 0;

    protected $controllerName;
    protected $methodName;

    protected $controllerArgs = array();

    protected $segments;
    protected $patternArr;

    protected $arguments = array();

    public function __construct($pattern){
        parent::__construct($pattern);

        $this->patternArr = explode('/', $this->pattern);
        $this->segments = Request::getSegments();

        if(self::$segmentCounter > 0){
            $this->segments = array_slice($this->segments, self::$segmentCounter);
        }

        if($this->pattern == '' && empty(Request::getPath())){
            $this->valid = true;

            return false;
        } else {
            return true;
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

    public function getSegment($key){
        if(is_string($key)) return $this->arguments[ $key ];
        else if(is_int($key)) return $this->segments[ $key ];
        else return false;
    }

    protected function callMethod($className, $methodName, array $args = null){
        $obj = new $className();
        if(!empty($args)) $obj->$methodName(...array_values($args));
        else $obj->$methodName();
    }

    protected function validatePattern(){
        foreach($this->patternArr as $key => $patternPart){
            if(
                $this->patternArr[ $key ][0] == '{'
                &&
                $this->patternArr[ $key ][ strlen($this->patternArr[ $key ]) - 1 ] == '}'
            ){
                if($patternPart){
                    $this->arguments[ substr($this->patternArr[ $key ], 1, -1) ] = $this->segments[ $key ];
                    $this->valid = true;
                }
            } else {
                if($patternPart == $this->segments[ $key ]){
                    $this->valid = true;
                } else {
                    $this->valid = false;
                    break;
                }
            }
        }
    }
}