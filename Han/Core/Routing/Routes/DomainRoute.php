<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 13.01.2016
 */

namespace Han\Core\Routing\Routes;


use Han\Core\Request;
use Han\Core\Routing\Route;

class DomainRoute extends Route {

    public function __construct($pattern){
        parent::__construct($pattern);
        if($pattern == Request::getDomain()){
            $this->valid = true;
        }
    }

    protected function run(){
        $callback = $this->callback;
        $callback();
    }

}