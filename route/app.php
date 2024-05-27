<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


Route::group('api', function () {
    Route::rule('/','Index/index');
    Route::rule('/edit','Index/edit');
    Route::rule('/add','Index/add');
});//->middleware(\app\middleware\TokenMiddleware::class);

Route::group('api', function () {

});




 Route::rule('/bot/webhook','TelegramBot/webhook'); //机器人 回调消息地址
 Route::rule('/bot/setWebhook','TelegramBot/setWebhook'); //机器人 绑定回调地址
 Route::rule('/bot/getWebhookInfo','TelegramBot/getWebhookInfo'); //机器人 获取绑定信息
 Route::rule('/bot/setDelete','TelegramBot/setDelete'); //机器人 删除绑定信息