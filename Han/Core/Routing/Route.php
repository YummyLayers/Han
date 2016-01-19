<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 19.01.2016
 */

namespace Han\Core\Routing;


use Closure;
use Exception;

abstract class Route {

    protected $pattern;
    protected $valid = false;
    protected $callback;
    protected $middlewareNames;

    abstract public function __construct($pattern);

    abstract protected function run();

    public function isValid(){
        return $this->valid;
    }

    public function setCallback($callback){
        if($callback instanceof Closure){

            $this->callback = $callback;

            return $this;
        } else {
            throw new Exception("Callback parameter is not a Closure");
        }
    }

    public function setMiddleware($middlewareNames){
        if(!is_array($middlewareNames) && is_string($middlewareNames)) $middlewareNames = array( $middlewareNames );

        $this->middlewareNames = $middlewareNames;

        return $this;
    }

    function __destruct(){
        $this->run();
    }

}