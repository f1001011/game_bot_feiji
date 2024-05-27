<?php

namespace app\model;

use app\common\CacheKey;
use think\facade\Cache;

class LotteryJoinModel extends BaseModel
{
    public $table = 'lottery_join';

    const STATUS_HAVE = 0;//刚创建的，还在准备，没发出去的红包
    const STATUS_START = 1;//红包领取中
    const STATUS_END = 2;//状态结束
    const STATUS_END_ALL = 5;//全部状态结束
    const RED_TYPE_FL = 0;//福利
    const RED_TYPE_DX = 1;//定向
    const RED_TYPE_JL = 2;//接龙
    const RED_TYPE_DL = 3;//地雷

    const IS_STATUS_START_JL = 0;//接龙开始状态
    const IS_STATUS_JL = 1;//接龙中状态
    const IS__STATUS_END_JL = 2;//接龙结束状态

    public function setUpdate($map = [], $data = [])
    {
        //$data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        if (empty($data)){
            $this->update($data);
        }
        return $this->where($map)->update($data);
    }




}
