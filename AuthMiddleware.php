<?php

/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.01.2016
 * Time: 22:35
 */
class AuthMiddleware implements \Han\Core\Interfaces\MiddlewareInterface {

    public function check() {
        return TRUE;
    }
}