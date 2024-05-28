<?php

namespace app\traits;

//飞机配置
use app\common\CacheKey;
use app\facade\BotFacade;
use app\model\LotteryJoinUserModel;
use app\model\UserModel;
use think\Exception;
use think\facade\Cache;

trait TelegramTrait
{
    //获取主菜单
    public function sendRrdBotRoot(string $param = '', string $crowd = '')
    {
//        $string = "获取本局结果"; //$param 唯一标识
//
//        $one = [
//            [
//                ['text' => $string, 'callback_data' => 'tables_'. $param],
//            ],
//        ];
//        return array_merge($one, $this->menu());
        return $this->menu();
    }


    //主动发送 群红包消息
    public function sendRrdBot(string $crowd = '')
    {
        //合并两个数组
        return $this->menu();
    }


    protected function menu()
    {
        return [
            [
                ['text' => '百家乐一群', 'url' => "https://t.me/red_app_test_bot"],
                ['text' => '百家乐二群', 'url' => 'https://t.me/red_app_test_bot'],
                ['text' => '百家乐三群', 'url' => 'https://t.me/red_app_test_bot'],
            ],
            [
                ['text' => '开牌记录', 'callback_data' => 'openLog'],
                ['text' => '下注记录', 'callback_data' => 'betLog'],
                ['text' => '更多游戏', 'url' => 'https://t.me/red_app_test_bot'],
            ],
        ];
    }

    
    protected function analysisBetResponse($json,$crowdId,$tgUser){
         $data = json_decode($json,true);
        
        if ($data['code'] == 200){
            BotFacade::sendMessage($crowdId,$tgUser['username'].' 下注成功');
            return true;
        }
//    //返回错误信息
    botFacade::sendMessage($crowdId,$tgUser['username'].'下注失败'."\n".$data['message']);
    return true;
    }
}
