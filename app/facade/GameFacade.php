<?php

namespace app\facade;
use app\facade\bin\GameBetting;
use app\facade\bin\TelegramBotBin;
use think\Facade;
class GameFacade extends Facade
{
    protected static function getFacadeClass()
    {
        return GameBetting::class;
    }
}