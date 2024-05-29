<?php

$BOT_TOKEN = env('telegram.bot_key','7486843033:AAGX1CrQz1JDQRiixIe8-R_50_9Goms44pQ');//机器人key
return [
    'one'               => [
        'bot-url'     => "https://api.telegram.org/bot$BOT_TOKEN/", //绑定机器人地址
        'bot-binding-url-one'=>env('telegram.bot_binding_url','https://tg.bigtelegram.com/bot/webhook'),//绑定接口地址

        'bot-binding-red-string-one'     => 'tables_',
        'bot-binding-bjl-photo-one'  => 'static/fl.jpg',//百家乐欢迎光临图片
        'bot-binding-bjl-start-photo-one'   => 'static/fl.jpg',//百家乐开始投注图片
        'bot-binding-bjl-open-photo-one'    => 'static/fl.jpg',//百家乐结束投注图片
        'bot-binding-nn-start-photo-one'    => 'static/fl.jpg',
        'bot-binding-nn-open-photo-one'     => 'static/fl.jpg',
        'bot-binding-lh-start-photo-one'    => 'static/fl.jpg',
        'bot-binding-lh-open-photo-one'     => 'static/fl.jpg',
        'bot-binding-three-start-photo-one' => 'static/fl.jpg',
        'bot-binding-three-open-photo-one'  => 'static/fl.jpg',
    ],
    'bjl_crowd'         => [ //群号=》台座
        '-4271423211' => 1,
        '-123' => 2,
        '-23' => 20,
        '-42714231324211' => 21,
    ],
    'nn_crowd'          => [ //群号=》台座
        '-1002' => 12,
        '-10012' => 13,
        '-12002' => 14,
        '-120102' => 22,
    ],
    'lh_crowd'          => [ //群号=》台座
        '-10013' => 4,
        '-10023' => 6,
        '-10033' => 7,
    ],
    'three_crowd'       => [ //群号=》台座
        '-1004' => 18,
    ],
    'bjl-betting-url'   => 'https://heng_api_user.bigtelegram.com/',//下注地址
    'nn-betting-url'    => '',
    'lh-betting-url'    => '',
    'three-betting-url' => '',

];