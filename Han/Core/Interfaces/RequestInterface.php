<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

namespace Han\Core\Interfaces;


interface RequestInterface {

    public static function getDomain();

    public static function getPath();

    public static function getMethod();

    public static function getSession();

    public static function getSessionValue($key);

    public static function getHeaders();

    public static function getHeader($headerName);

    public static function getCookies();

    public static function getCookie($cookieName);

    public static function isAjax();

}