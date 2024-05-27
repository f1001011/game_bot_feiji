<?php

namespace app\service;

use app\facade\BotFacade;
use app\model\LotteryJoinModel;
use app\model\LotteryJoinUserModel;
use app\model\UserModel;
use app\traits\RedBotTrait;
use app\traits\TelegramTrait;

class BotSendService extends BaseService
{
    use TelegramTrait;
    use RedBotTrait;

    public function send($crowd, $messageId = 0)
    {
        $list = $this->sendRrdBot($crowd);
        if ($messageId > 0) {
            BotFacade::editMessageText($crowd, $messageId, language('title'), $list);
        } else {
            BotFacade::sendPhoto($crowd, $this->getCrowdPhoto($crowd), language('title'), $list);
        }
        return true;
    }
}