<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 13.01.2016
 */

namespace Han\Core\Routing;


use Han\Core\Routing\Routes\DomainRoute;
use Han\Core\Routing\Routes\PathRoutes\PathGroupRoute;
use Han\Core\Routing\Routes\PathRoutes\PathMatchRoute;

class Router {

    public static function match($pattern){
        return new PathMatchRoute($pattern);
    }

    public static function group($pattern){
        return new PathGroupRoute($pattern);
    }

    public static function groupByDomain($pattern){
        return new DomainRoute($pattern);
    }

}