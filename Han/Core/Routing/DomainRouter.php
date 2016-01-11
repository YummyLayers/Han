<?php

/**
 * Created by PhpStorm.
 * User: -m-ousy--
 * Date: 08.01.2016
 * Time: 19:22
 */

namespace Han\Core\Routing;

use Han\Core\Interfaces\MiddlewareInterface;
use Han\Core\Request;


class DomainRouter {

    public function route( $domain, $callBack, array $middlewareNames = NULL ) {
        if ( $domain == Request::getDomain() ) {

            $middlewareNext = TRUE;

            if ( $middlewareNames ) foreach ( $middlewareNames as $middlewareName ) {

                $middleware = new $middlewareName();
                if ( $middleware instanceof MiddlewareInterface ) {
                    $middlewareNext = $middleware->check();
                }
            }

            if ( $middlewareNext ) $callBack();
        }
    }

}