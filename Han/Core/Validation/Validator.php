<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 17.01.2016
 */

namespace Han\Core\Validation;


class Validator {

    /**
     * @var Validate[]
     */
    private $validators = array();

    function make($name, $value = null){

        $validate = new Validate($name, $value);

        $this->validators[ $name ] = $validate;

        return $validate;
    }

    function makeByArray(array $date, array $patterns){

        foreach($patterns as $name => $pattern){

            $methodsWithArgs = explode('|', $pattern);
            $validator = $this->make($name, $date[ $name ]);

            if($methodsWithArgs) foreach($methodsWithArgs as $methodWithArgs){

                if(!empty($methodWithArgs)){

                    $methodAndArgs = explode(':', $methodWithArgs);
                    $methodName = $methodAndArgs[0];

                    if(method_exists($validator, $methodName)){
                        if($methodAndArgs[1]){
                            $args = explode(',', $methodAndArgs[1]);

                            $validator->$methodName(...$args);
                        } else {
                            $validator->$methodName();
                        }
                    }
                }
            }
        }
    }

    function hasError(){

        foreach($this->validators as $v){
            if($v->hasError()) return true;
        }

        return false;
    }

    public function getErrorText(){
        foreach($this->validators as $v){
            if($v->getErrorText()) return $v->getErrorText();
        }

        return null;
    }

    public function getErrorTexts(){

        $errorTexts = array();

        foreach($this->validators as $v){
            foreach($v->getErrorTexts() as $errorText){
                $errorTexts[] = $errorText;
            }
        }

        return $errorTexts;
    }

    public function get($name){
        return $this->validators[ $name ];
    }
}