<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

namespace Han\Core\Routing;


use Han\Core\Interfaces\PathRouterInterface;
use Han\Core\Request;

class PathRouter implements PathRouterInterface {

    function get( $pattern, $callBack, array $middlewareNames = NULL ) {
        if(Request::getMethod() == Request::GET) $this->any($pattern, $callBack, $middlewareNames);
    }

    function post( $pattern, $callBack, array $middlewareNames = NULL ) {
        if(Request::getMethod() == Request::POST) $this->any($pattern, $callBack, $middlewareNames);
    }

    function any( $pattern, $callBack, array $middlewareNames = NULL ) {

        if ( $pattern == '/' ) {
            if ( empty( Request::getPath() ) )
                $this->execute($callBack);

            return;
        }

        $patternValid = FALSE;
        $pathArr = Request::getPathArr();
        $patternArr = explode( '/', $pattern );
        $argumentsArr = array();

        //echo count($pathArr) .'=='. count($patternArr);

        if ( count( $pathArr ) == count( $patternArr ) ) {

            foreach ( $pathArr as $key => $pathPart ) {

                if ( substr( $patternArr[ $key ], 0, 1 ) == '{' && substr( $patternArr[ $key ], -1 ) == '}' ) {

                    if ( $pathPart ) {
                        $argumentsArr[] = $pathPart;
                        $patternValid = TRUE;
                    }
                } else {

                    if ( $pathPart == $patternArr[ $key ] ) {
                        $patternValid = TRUE;
                    } else {
                        $patternValid = FALSE;
                    }
                }
            }
        }

        if ( $patternValid ) {

            $this->execute($callBack, $argumentsArr);

            return;
        }

    }

    private function execute( $callBack, $argumentsArr = null ){

        if( is_string($callBack) ){

            $obj = new $callBack();

            $method = "index"."Action";

            $obj->$method();

        }else{

            if($argumentsArr) call_user_func_array( $callBack, $argumentsArr );
            else $callBack();

        }
    }
}