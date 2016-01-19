<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 13.01.2016
 */

namespace Han\Core\Routing\Routes;


use Han\Core\Interfaces\MiddlewareInterface;
use Han\Core\Request;
use Han\Core\Routing\Route;

class DomainRoute extends Route {

    public function __construct($pattern){
        $this->pattern = $pattern;
        if ($pattern == Request::getDomain()) {
            $this->valid = true;
        }
    }

    protected function run(){

        if($this->valid){

            $middlewareNext = true;

            if($this->middlewareNames) foreach($this->middlewareNames as $middlewareName){
                $middleware = new $middlewareName();
                if($middleware instanceof MiddlewareInterface){
                    $middlewareNext = $middleware->check();
                }
            }

            if($middlewareNext){
                $callback = $this->callback;
                $callback();
            }
        }
    }

}