<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 18.01.2016
 */

function Validate($name, $value = null){
    return new \Han\Core\Validation\Validate($name, $value);
}

function ValidateByArray(array $date, array $patterns){
    $validator = new \Han\Core\Validation\Validator;
    $validator->makeByArray($date, $patterns);

    return $validator;
}