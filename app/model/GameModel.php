<?php

namespace app\model;

class GameModel extends BaseModel
{
    public $table = 'ntp_dianji_game_type';
    const NN_TYPE    = 6;
    const LH_TYPE    = 2;
    const BJL_TYPE   = 3;
    const THREE_TYPE = 8;

    //游戏赔率对应数据库
    const LH_ODDS = [
        'l'  => 20,//龙
        'h'  => 21,//虎
        'he' => 22,//和
    ];

    const BJL_ODDS = [
        'xd'  => 2,//闲对
        'xyl' => 3,//新运6
        'zd'  => 4,//庄对
        'x'   => 6,//闲
        'h'   => 7,//和
        'z'   => 8,//庄
    ];

    const NN_ODDS = [
        'pbxo' => 35,//平倍闲3
        'fbxo' => 34,//翻倍闲3
        'pbxt' => 33,//平倍闲2
        'fbxt' => 32,//翻倍闲2
        'pbxs' => 31,//平倍闲1
        'fbxs' => 30,//翻倍闲1
        'co'   => 36,//超牛闲1
        'ct'   => 37,//超牛闲2
        'cs'   => 38,//超牛闲3
    ];

    const THREE_ODDS = [
        'fbo' => 40,//三公翻倍闲1
        'pbo' => 41,//三公平倍闲1
        'fbt' => 42,//三公翻倍闲2
        'pbt' => 43,//三公平倍闲2
        'fbs' => 44,//三公翻倍闲3
        'pbs' => 45,//三公平倍闲3
        'co'  => 46,//三公超级闲1
        'ct'  => 47,//三公超级闲2
        'cs'  => 48,//三公超级闲3
    ];

    //通过 飞机群号获取台座ID
    public function getTableId(string $crowd = '', string $gameName = '')
    {
        //组装配置文件名称
        $name = $gameName.'_crowd';
        $name = 'telegram.'.$name;
        //获取配置文件
        $arrayCrowd = config($name);


        if (empty($arrayCrowd) || !isset($arrayCrowd[$crowd])) {
            return [];
        }

        return $arrayCrowd[$crowd];
    }
}