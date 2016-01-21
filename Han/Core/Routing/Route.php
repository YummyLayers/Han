<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 19.01.2016
 */

namespace Han\Core\Routing;


use Closure;
use Han\Core\Interfaces\MiddlewareInterface;
use Han\Core\Request;

abstract class Route {

    protected $pattern;
    protected $valid = false;
    protected $callback;
    protected $middlewareNames = array();
    protected $httpMethods = array();

    public function __construct($pattern){

        if($pattern[0] == '/'){
            if($pattern == "/") $pattern = "";
            else $pattern = substr($pattern, 1);
        }

        $this->pattern = $pattern;
    }

    abstract protected function run();

    public function isValid(){
        return $this->valid;
    }

    public function setCallback(Closure $callback){
        $this->callback = $callback;

        return $this;
    }

    public function setMiddleware($middlewareNames){
        if(!is_array($middlewareNames) && is_string($middlewareNames)) $middlewareNames = array( $middlewareNames );

        $this->middlewareNames = $middlewareNames;

        return $this;
    }

    public function via($httpMethods){
        if(!is_array($httpMethods) && is_string($httpMethods)) $httpMethods = array( $httpMethods );

        $this->httpMethods = $httpMethods;

        return $this;
    }

    protected function checkMiddleware(){
        $middlewareNext = true;

        if($this->middlewareNames) foreach($this->middlewareNames as $middlewareName){
            $middleware = new $middlewareName();
            if($middleware instanceof MiddlewareInterface){
                $middlewareNext = $middleware->check();
            }
        }

        return $middlewareNext;
    }

    function __destruct(){
        if($this->valid){
            if(empty($this->httpMethods) || in_array(Request::getMethod(), $this->httpMethods)){
                if($this->checkMiddleware()){
                    $this->run();
                }
            }
        }
    }

}