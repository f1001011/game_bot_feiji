<?php

namespace app\service;

class BaseService
{
    protected static $_instance;
    public static function getInstance()
    {
        $localClass = new static();
        if ($localClass::$_instance instanceof $localClass) {
            return $localClass::$_instance;
        } else {
            $localClass::$_instance = new static();
            return self::$_instance;
        }
    }

}