<?php

declare (strict_types = 1);
namespace think\facade;
use think\Facade;
use think\TelegramBotBin;

class BotFacade extends Facade
{
    protected static function getFacadeClass()
    {
        return TelegramBotBin::class;
    }
}