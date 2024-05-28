<?php
declare (strict_types = 1);

namespace app\command;

use app\common\CacheKey;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Cache;

class GameOpenCmd extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('gameopencmd')
            ->setDescription('the gameopencmd command');
    }

    protected function execute(Input $input, Output $output)
    {

        $redisKey = CacheKey::BOT_TELEGRAM_TABLE_OPEN_INFO;
        $num = Cache::LLEN($redisKey);
        if ($num <=0 ){
            $output->writeln('gameopencmd  ---目前没有开始台座信息---');
            return false;
        }
        //1 接收到开牌信息
        $list = Cache::LRANGE($redisKey,0,-1);
      
        //2 循环查询 开牌信息
        foreach ($list as $key=>$value){
                //解析
            $array = [];
            $array = json_decode($value, true);
            if (empty($array)) {
                Cache::LREM($redisKey, 0, $value);
                continue;
            }
            dump($array);die;

        }

        //3 发送tg消息,通知可以 下注


        // 指令输出
        $output->writeln('gameopencmd');
    }
}
