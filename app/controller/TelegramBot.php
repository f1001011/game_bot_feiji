<?php

namespace app\controller;

use app\facade\BotFacade;
use app\service\BotCrowdListService;

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
        $request = json_decode($request, true);

        //判断是否是新消息。机器人加入房间消息
        $this->botCrowd($request);

        //判断是否是系统命令,是的话直接弹出菜单

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
            return ;
        }
        //BotRedSendService::getInstance()->send($message['chat']['id']);
    }

}