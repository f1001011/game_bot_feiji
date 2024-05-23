<?php

declare (strict_types = 1);
namespace think\facade;
use think\GameBetting;

class GameFacade extends Facade
{
    protected static function getFacadeClass()
    {
        return GameBetting::class;
    }
}