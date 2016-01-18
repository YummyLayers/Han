<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 13.01.2016
 */

namespace Han\Core\Routing;


class Router {

    public static function match($pattern, $isDomain = false){
        if ($isDomain) {
            return new DomainRoute($pattern);
        } else {
            return new PathRoute($pattern);
        }

    }

    public static function group($pattern, $isDomain = false){
        if($isDomain){
            return new DomainRoute($pattern);
        } else {
            return new PathRoute($pattern);
        }

    }

}