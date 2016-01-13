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

class DomainRoute {

    private $isEqual = false;
    private $callback;
    private $middlewareNames;

    public function __construct($pattern){
        if ($pattern == Request::getDomain()) {
            $this->isEqual = true;
        }
    }

    public function equal(){
        return $this->isEqual;
    }

    public function setCallback($callback){
        if ($callback instanceof Closure) {

            $this->callback = $callback;

            return $this;
        } else {
            throw new Exception("Callback parameter is not a Closure");
        }
    }

    public function setMiddleware($middlewareNames){
        if (!is_array($middlewareNames) && is_string($middlewareNames)) $middlewareNames = array( $middlewareNames );

        $this->middlewareNames = $middlewareNames;

        return $this;
    }

    public function run(){

        $middlewareNext = true;

        foreach ($this->middlewareNames as $middlewareName) {
            $middleware = new $middlewareName();
            if ($middleware instanceof MiddlewareInterface) {
                $middlewareNext = $middleware->check();
            }
        }

        if ($middlewareNext) {
            $callback = $this->callback;
            $callback();
        }
    }

}