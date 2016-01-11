<?php
use Han\Core\Interfaces\MiddlewareInterface;

/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.01.2016
 * Time: 22:07
 */
class LoggerMiddleware implements MiddlewareInterface {

    public function check() {

        // write

        return TRUE;
    }
}