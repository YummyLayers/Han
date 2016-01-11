<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

class AuthMiddleware implements \Han\Core\Interfaces\MiddlewareInterface {

    public function check() {
        return TRUE;
    }
}