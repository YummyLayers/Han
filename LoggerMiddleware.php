<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

use Han\Core\Interfaces\MiddlewareInterface;

class LoggerMiddleware implements MiddlewareInterface {

    public function check() {

        // write

        return TRUE;
    }
}