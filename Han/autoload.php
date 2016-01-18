<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 08.01.2016
 */

include 'Core/Validation/ValidationHelpers.php';

spl_autoload_register( function( $class ) {

    $prefix = 'Han';

    $base_dir = __DIR__ . '/';

    $len = strlen( $prefix );
    if ( strncmp( $prefix, $class, $len ) !== 0 ) {
        return;
    }

    $relative_class = substr( $class, $len );

    $file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

    if ( file_exists( $file ) ) {
        include $file;
    }

});