<?php

namespace app\service\Game;

use app\service\BaseService;
use app\traits\RedBotTrait;
use app\traits\TelegramTrait;

class BaseGameService extends BaseService
{
    use RedBotTrait;
    use TelegramTrait;
    public function commandAnalysis($command){

        if (substr_count($command, '/') <=0) {
            //不符合 下注字符串类型
            return [];
        }
        $array = []; //存放本次下注的所有数据  [[zy,100],['ll','100']]
        //判断是否是一次性下注多个

        if (substr_count($command, ' ') > 0) {
            $arrayOne = explode(' ', $command);

            //[’zy/100‘，’xy/100‘]
            foreach ($arrayOne as $key => $value) {
                //判断是否存在某个字符串  [[zy,100],['ll','100']]
                $o = [];
                $o = explode('/', $value);

                //判断 解析出来的是否符合规矩
                if (!isset($o[0]) || !isset($o[1]) || $o[1] <= 0) {
                    //不符合规矩，结束。
                    return [];
                }
                //符合规矩。存入 下注订单数据
                $array[] = $o;
            }

        } else {
            $o = [];
            $o = explode('/', $command); //判断 解析出来的是否符合规矩
            if (!isset($o[0]) || !isset($o[1]) || $o[1] <= 0) {
                //不符合规矩，结束。
                return [];
            }
            $array[] = $o;
        }

        return $array;
    }

    public function getToken($tgId){
        //获取 token 存入 redis
        //发送tgID 获取用户 token
        //
    }


}