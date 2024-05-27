<?php
// +----------------------------------------------------------------------
// | 控制台配置
// +----------------------------------------------------------------------
return [
    // 指令定义
    'commands' => [
        'gamestartbetcmd'=>\app\command\GameStartBetCmd::class,
        'gameopencmd'=>\app\command\GameOpenCmd::class,
    ],
];
