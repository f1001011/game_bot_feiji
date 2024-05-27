<?php

namespace app\model;

use app\common\CacheKey;
use think\facade\Cache;

class CommandLogModel extends BaseModel
{
    public $table = 'tg_command_log';



    //获取用户信息时候保存到redis


    public function incOrDec($id, $int)
    {
        if ($int > 0) {
            return $this->where('id', $id)->inc('balance', $int)->update();
        }
        return $this->where('id', $id)->dec('balance', $int)->update();
    }

    public function dec($id, $int)
    {
        return $this->where('id', $id)->dec('balance', $int)->update();
    }

    //$decBalance 用户余额需要减少多少，用户冻结多少金额
    public function userFreezeRedBalance($id,$decBalance,$freezeBalance){
        //用户领取红包，冻结金额操作
    }
}
