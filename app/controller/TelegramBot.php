<?php

namespace app\controller;

use app\facade\BotFacade;
use app\service\BotCrowdListService;
use app\service\BotSendService;
use app\service\Game\BotBjlService;

class TelegramBot extends BaseApiController
{
    public function setWebhook()
    {
        BotFacade::setWebhookPost();
        success();
    }

    public function getChats()
    {
        $data = BotFacade::getChats();
        if (!$data) {
            fail();
        }
        success(json_decode($data, true));
    }

    //获取绑定的地址
    public function getWebhookInfo()
    {
        $data = BotFacade::getWebhookPostInfo();
        if (!$data) {
            fail();
        }
        success(json_decode($data, true));
    }

    public function setDelete()
    {
        //删除机器人绑定域名信息
        $data = BotFacade::setWebhookDeletePost();
        success();
    }

    //telegram消息回调
    public function webhook()
    {
        //用户领取红包
        //需要发送 红包id查询红包数据
        $request = file_get_contents('php://input');
        traceLog($request, '------start-----');
        $request = json_decode($request, true);

        //判断是否是新消息。机器人加入房间消息
        $this->botCrowd($request);

        //判断是否是系统命令,是的话直接弹出菜单
        $this->systemCommand($request);
        //判断是否新用户加入群中,是的话绑定用户到群 建立数据库 用户加入房间数据库




        if (empty($request) || empty($request['callback_query']['message'])) {
            // 消息体错误
            traceLog($request, 'red-webhook-error');
            fail();
        }

        //响应成功
        //获取群ID
        $data = $request['callback_query'];
        $messageId = $data['message']['message_id'];//消息ID
        $crowd = $data['message']['chat']['id'];//群ID
        $command = $data['data'];//输入命令
        $tgId = $data['from']['id'];//用户的tgId
        traceLog(['message_id' => $messageId, 'crowd' => $crowd, 'command' => $command,], 'red-webhook-data');
        //1 判断输入的命令/
        //获取群号判断是 那个游戏
        if ($crowd == '百家乐群号'){
         //调用百家乐游戏下注
        }

        if ($crowd == '龙湖斗群号'){

        }
        if ($crowd == '三公'){

        }
        if ($crowd == '牛牛'){

        }


        //如果是接龙红包
        success();
    }



    //机器人加入新房间
    protected function botCrowd($request)
    {
        //判断是否是新消息。机器人加入房间消息
        if (!empty($request['message']['new_chat_member']) && $request['message']['new_chat_member']['is_bot']) {
            //机器人加入房间信息
            $message = $request['message'];

            $data = [
                'title' => $message['chat']['title'],
                'crowd_id' => $message['chat']['id'],
                'first_name' => $message['new_chat_member']['first_name'],
                'botname' => $message['new_chat_member']['username'],
                'user_id' => $message['from']['id'],
                'username' => $message['from']['username'],
                'del' => 0,
            ];

            BotCrowdListService::getInstance()->botCrowdBind($data);
            return true;
        }
        //判断是否是新消息。机器人被踢出房间消息
        if (!empty($request['my_chat_member']) && $request['my_chat_member']['old_chat_member']['user']['is_bot']) {
            $message = $request['my_chat_member'];

            $data = [
                'crowd_id' => $message['chat']['id'],
                'botname' => $message['new_chat_member']['user']['username'],
            ];
            //修改这个条件
            BotCrowdListService::getInstance()->botCrowdEdit($data);
            return true;
        }
        return true;
    }

    //判断是否是系统命令
    public function systemCommand($request){

        if (empty($request) || empty($request['message']['text'])) {
            // 消息体错误
            return;
        }
        //如果是系统命令
        $message = $request['message'];
        if (empty($message['chat']['id'])){
            return;
        }
        $command = $request['message']['text'];
        $chat = $message['chat'];
        $from = $message['from'];
        if ($command == '/start'){
            BotSendService::getInstance()->send($chat['id']);
            return;
        }

        //判断是否是下注信息格式 /zd/100 xd/100
        traceLog([
            'message_id' => $message['message_id'],
            'crowd' => $chat['id'],
            'command' => $command,
            'tg_id' => $from['id'],
            ],
            'command-webhook-data');

        //先判断 命令是否正确，开始第一位 /zd/100 xd/100，字符串出现的次数始终是单数
        $commandCount = substr_count($command, '/');
        if ($commandCount % 2 != 1) {
            //表示发送的数据不对
            BotFacade::sendMessage($chat['id'],"用户{$from['username']}发送的数据 {$command} 格式错误");
            return;
        }
        //判断是否是下注信息格式 /zd/100 xd/100
        //去除第一个 /
        $command = substr($command, 1);
        $bjl_crowd = config('telegram.bjl_crowd');
        //如果是百家乐群 //调用百家乐游戏下注
        if ($chat['id'] == isset($bjl_crowd[$chat['id']])){
            BotBjlService::getInstance()->Betting($command,$chat['id'],$from);
            return;
        }


        $nn_crowd = config('telegram.nn_crowd');
        if ($chat['id'] == isset($nn_crowd[$chat['id']])){

        }

        $three_crowd = config('telegram.three_crowd');
        if ($chat['id'] == isset($three_crowd[$chat['id']])){

        }

        $lh_crowd = config('telegram.lh_crowd');
        if ($chat['id'] == isset($lh_crowd[$chat['id']])){

        }

    }

}