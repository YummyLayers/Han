<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.01.2016
 * Time: 21:05
 */

namespace Han\Core\Interfaces;


interface PathRouterInterface {

    function get($pattern, $callBack, array $middlewareNames = null);

    function post($pattern, $callBack, array $middlewareNames = null);

    function any($pattern, $callBack, array $middlewareNames = null);

}