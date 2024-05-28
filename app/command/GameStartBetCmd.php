<?php
declare (strict_types=1);

namespace app\command;

use app\common\CacheKey;
use app\model\GameModel;
use app\service\Game\BotBjlService;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Cache;

class GameStartBetCmd extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('gamestartbetcmd')
            ->setDescription('the gamestartbetcmd command');
    }

    protected function execute(Input $input, Output $output)
    {   
        $redisKey = CacheKey::BOT_TELEGRAM_TABLE_SEND_INFO;
        $num      = Cache::LLEN($redisKey);
        //   $array['xue_number']= 12;
        //     $array['pu_number']= 3;
        //     $array['countdown_time']= 45;
        //     $array['table_id']= 2;
        //      $array['start_time']= 1716772851;
        //       $array['game_type']= 3;
        //     Cache::RPUSH($redisKey,json_encode($array));
        //     die;
            
        if ($num <= 0) {
            $output->writeln('gamestartbetcmd  ---目前没有开是信息---');
            return false;
        }
        $endNum = -1;
        if ($num > 10){
            $endNum = 10;
        }
        //1 循环查询开牌信息
        $list = Cache::LRANGE($redisKey, 0, $endNum);
         
        $redisKeyOn = CacheKey::BOT_TELEGRAM_TABLE_SEND_INFO_ON;
        //组装开牌信息
        $urls = []; //['url'=>['参数']
        $menu = BotBjlService::getInstance()->sendRrdBot();
        $url  = config('telegram.one.bot-url').'sendPhoto';

        foreach ($list as $key => $value) {
            //解析
            $array = [];
            $array = json_decode($value, true);
            Cache::LREM($redisKey, 0, $value);
            if (empty($array)) {
                //Cache::LREM($redisKey, 0, $value);
                continue;
            }

            $crowdId = '';
            //1 获取发送到的 tg群  台座ID换 群ID
            //获取图片地址
            list($photoPath) = BotBjlService::getInstance()->verifySetSend($array['game_type']);
           
            switch ($array['game_type']) {
                case GameModel::BJL_TYPE://百家乐
                    $bjl_crowd = config('telegram.bjl_crowd');
                 
                    $crowdId   = array_search($array['table_id'], $bjl_crowd);
                
                    if (!$crowdId) {
                        //不存在保存信息到其他key，并删除本次数据中的值
                        Cache::LPUSH($redisKeyOn, $value);
                        Cache::LREM($redisKey, 0, $value);

                    } else {
                        //存在是 组装需要发送的 台座信息   百家乐台桌：1 开始投注。。靴/铺：12/2
                        $urls[] = $this->requestData($url, $crowdId, $photoPath, $menu, $value, $array, '百家乐');
                    }
                    break;
                case GameModel::LH_TYPE://龙虎斗
                    $lh_crowd = config('telegram.lh_crowd');
                    $crowdId  = array_search($array['table_id'], $lh_crowd);
                    if (!$crowdId) {
                        //不存在保存信息到其他key，并删除本次数据中的值
                        Cache::LPUSH($redisKeyOn, $value);
                        Cache::LREM($redisKey, 0, $value);

                    } else {
                        //存在是 组装需要发送的 台座信息   龙虎斗台桌：1 开始投注。。靴/铺：12/2
                        $urls[] = $this->requestData($url, $crowdId, $photoPath, $menu, $value, $array, '龙虎斗');

                    }
                    break;
                case GameModel::NN_TYPE://牛牛
                    $nn_crowd = config('telegram.nn_crowd');
                    $crowdId  = array_search($array['table_id'], $nn_crowd);
                    if (!$crowdId) {
                        //不存在保存信息到其他key，并删除本次数据中的值
                        Cache::LPUSH($redisKeyOn, $value);
                        Cache::LREM($redisKey, 0, $value);

                    } else {
                        //存在是 组装需要发送的 台座信息   牛牛台桌：1 开始投注。。靴/铺：12/2
                        $urls[] = $this->requestData($url, $crowdId, $photoPath, $menu, $value, $array, '牛牛');
                    }
                    break;
                case GameModel::THREE_TYPE://三公
                    $three_crowd = config('telegram.three_crowd');
                    $crowdId     = array_search($array['table_id'], $three_crowd);
                    if (!$crowdId) {
                        //不存在保存信息到其他key，并删除本次数据中的值
                        Cache::LPUSH($redisKeyOn, $value);
                        Cache::LREM($redisKey, 0, $value);

                    } else {
                        //存在是 组装需要发送的 台座信息   百家乐台桌：1 开始投注。。靴/铺：12/2
                        $urls[] = $this->requestData($url, $crowdId, $photoPath, $menu, $value, $array, '三公');
                    }
                    break;
            }

        }
        //调用发送信息
       
        BotBjlService::getInstance()->startSend($urls);

        // 指令输出
        $output->writeln('gamestartbetcmd');
    }

    public function requestData($url, $crowdId, $photoPath, $menu, $value, $array, $name = '百家乐')
    {
        return [
            'url'        => $url,
            'data'       => [
                'chat_id'      => $crowdId,
                'photo'        => new \CURLFile($photoPath),
                'caption'      => "{$name}台桌：" . $array['table_id'] . ' 开始投注' . PHP_EOL
                    . '靴/铺：' . $array['xue_number'] . '/' . $array['pu_number'] . PHP_EOL,
                'reply_markup' => json_encode(['inline_keyboard' => $menu]),
            ],
            'redis_json' => $value
        ];
    }
}
