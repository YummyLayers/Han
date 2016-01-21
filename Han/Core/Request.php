<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

namespace Han\Core;


use Han\Core\Interfaces\RequestInterface;

class Request implements RequestInterface {

    const GET = "GET";
    const POST = "POST";

    /**
     * Getting URL path
     * @return string - URL path
     */
    public static function getPath() {
        $url = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        if($url[ strlen($url) - 1 ] == '/') $url = substr($url, 0, strlen($url) - 1);

        return substr($url, 1, strlen($url) - 1);
    }
    /**
     * Getting parts of URL path
     * @return array of parts of URL path
     */
    public static function getSegments(){
        return explode('/', self::getPath());
    }

    public static function getSegment($index){
        return explode('/', self::getPath())[ $index ];
    }

    public static function getDomain(){
        return $_SERVER['HTTP_HOST'];
    }

    public static function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getSession() {
        // TODO: Implement getSession() method.
    }

    public static function getSessionValue( $key ) {
        // TODO: Implement getSessionValue() method.
    }

    public static function getHeaders() {
        // TODO: Implement getHeaders() method.
    }

    public static function getHeader( $headerName ) {
        // TODO: Implement getHeader() method.
    }

    public static function getCookies() {
        // TODO: Implement getCookies() method.
    }

    public static function getCookie( $cookieName ) {
        // TODO: Implement getCookie() method.
    }

    public static function isAjax() {
        // TODO: Implement isAjax() method.
    }
}