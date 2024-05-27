<?php

namespace app\traits;

use app\common\CacheKey;
use app\facade\BotFacade;
use app\model\GameModel;
use app\model\LotteryJoinModel;
use app\model\LotteryJoinUserModel;
use app\model\UserModel;
use think\facade\Cache;

trait RedBotTrait
{

    //获取游戏类型的红包
    protected function verifySetSend($gameType, $isOpen = false)
    {
        switch ($gameType) {
            case GameModel::BJL_TYPE:
                $photo = 'bjl';
                break;
            case GameModel::NN_TYPE:
                $photo = 'nn';
                break;
            case GameModel::LH_TYPE:
                $photo = 'lh';
                break;
            case GameModel::THREE_TYPE:
                $photo = 'three';
                break;
            default:
                $photo = 'bjl';;
        }
        //是开牌还是结束停止下注
        $open = 'start';
        if ($isOpen){
            $open = 'open';
        }

        $photoUrl = public_path() . config("telegram.one.bot-binding-{$photo}-{$open}-photo-one");
        if (!file_exists($photoUrl)) {
            return fail([], '红包图片不存在');
        }

        return [$photoUrl];
    }

    public function getCrowdPhoto($crowdId=''){
        //获取群图片
        $photoUrl = public_path() . config("telegram.one.bot-binding-bjl-photo-one");
        return $photoUrl;
    }

}