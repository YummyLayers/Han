<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

namespace Han\Core\Interfaces;


interface PathRouterInterface {

    function get($pattern, $callBack, array $middlewareNames = null);

    function post($pattern, $callBack, array $middlewareNames = null);

    function any($pattern, $callBack, array $middlewareNames = null);

}