<?php
return [
    'one'               => [
        'bot-url'                           => 'https://api.telegram.org/botwebhook/', //发送消息到tg的接口地址
        //        'bot-binding-red-string-one'     => 'tables_',
        'bot-binding-bjl-start-photo-one'   => 'static/12.png',//百家乐开始投注图片
        'bot-binding-bjl-open-photo-one'    => 'static/12.png',//百家乐结束投注图片
        'bot-binding-nn-start-photo-one'    => 'static/12.png',
        'bot-binding-nn-open-photo-one'     => 'static/12.png',
        'bot-binding-lh-start-photo-one'    => 'static/12.png',
        'bot-binding-lh-open-photo-one'     => 'static/12.png',
        'bot-binding-three-start-photo-one' => 'static/12.png',
        'bot-binding-three-open-photo-one'  => 'static/12.png',
    ],
    'bjl_crowd'         => [ //群号=》台座
        '-1001' => 2,
    ],
    'nn_crowd'          => [ //群号=》台座
        '-1002' => 102,
    ],
    'lh_crowd'          => [ //群号=》台座
        '-1003' => 102,
    ],
    'three_crowd'       => [ //群号=》台座
        '-1004' => 102,
    ],
    'bjl-betting-url'   => 'https://heng_api_user.bigtelegram.com/',//下注地址
    'nn-betting-url'    => '',
    'lh-betting-url'    => '',
    'three-betting-url' => '',

];