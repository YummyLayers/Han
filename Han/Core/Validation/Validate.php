<?php
/**
 * IDE: PhpStorm.
 * License: The MIT License (MIT) - Copyright (c) 2016 YummyLayers
 * Date: 18.01.2016
 */

namespace Han\Core\Validation;


class Validate {

    private $name;
    private $value;

    private $required = false;

    private $error = false;
    private $errorTexts = array();

    public function __construct($name, $value = null){
        $this->name = $name;
        $this->value = $value;
    }

    public function required($errorText = null, $callback = null){

        $this->required = true;

        if(!$errorText) $errorText = $this->name . " is required";

        if(empty($this->value)) $this->setError($errorText, $callback);

        return $this;
    }


    public function string($errorText = null, $callback = null){

        if(!$errorText) $errorText = $this->name . " is not a string";

        if($this->isRequiredRule() && !is_string($this->value)) $this->setError($errorText, $callback);

        return $this;
    }

    public function int($errorText = null, $callback = null){

        if(!$errorText) $errorText = $this->name . " is not a integer";

        if($this->isRequiredRule() && !is_int($this->value)) $this->setError($errorText, $callback);

        return $this;
    }

    public function boolean($errorText = null, $callback = null){

        if(!$errorText) $errorText = $this->name . " is not a boolean";

        if($this->isRequiredRule() && !is_bool($this->value)) $this->setError($errorText, $callback);

        return $this;
    }


    public function max($max, $errorText = null, $callback = null){

        if(!$errorText) $errorText = $this->name . " should be less than " . $max;

        if($this->isRequiredRule()){
            if(is_int($this->value)){
                if($this->value > $max) $this->setError($errorText, $callback);
            } elseif(is_string($this->value)) {
                if(strlen($this->value) > $max) $this->setError($errorText, $callback);
            }
        }

        return $this;
    }

    public function min($min, $errorText = null, $callback = null){

        if(!$errorText) $errorText = $this->name . " should be more than " . $min;

        if($this->isRequiredRule()){
            if(is_int($this->value)){
                if($this->value < $min) $this->setError($errorText, $callback);
            } elseif(is_string($this->value)) {
                if(strlen($this->value) < $min) $this->setError($errorText, $callback);
            }
        }

        return $this;
    }


    public function hasError(){
        return $this->error;
    }

    public function getErrorText(){
        return $this->errorTexts[0];
    }

    public function getErrorTexts(){
        return $this->errorTexts;
    }

    private function setError($errorText, $callback = null){
        $this->error = true;
        $this->errorTexts[] = $errorText;
        if($callback instanceof \Closure) $callback();
    }

    private function isRequiredRule(){
        return ($this->required || !empty($this->value));
    }

}