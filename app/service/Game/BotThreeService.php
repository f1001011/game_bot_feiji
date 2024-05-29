<?php

namespace app\service\Game;


use app\facade\BotFacade;
use app\facade\GameFacade;
use app\model\GameModel;

class BotThreeService extends BaseGameService
{

    //下注
    public function Betting(string $command, string $crowd, array $tgUser)
    {

        // zy/100&xy/100&hy/100
        //判断下注中是否有 逗号和 / 符号
        //解析 !strpos($command, '&') ||
        $array = $this->commandAnalysis($command); //[[zy,100],['ll','100']]

        if (empty($array)) {
            return [];//不符合规矩
        }

        //便利组装下注信息
        $tgID = $tgUser['id'];
        $post = [];
        foreach ($array as $key => $value) {
            $res = [];
            //1 获取下注台座
            $tableId = 0;
            //3 获取下注比例 ID

            if (!isset(GameModel::THREE_ODDS[$value[0]])) {
                //判断 赔率ID 是否存在，不存在直接 退出
                return false;
            }
            $res['rate_id'] = GameModel::THREE_ODDS[$value[0]];//查询游戏配率ID

            //4 组装下注信息
            $res['money'] = abs($value[1]);
            $post['bet'][] = $res;
        }

        $tableId = GameModel::getInstance()->getTableId($crowd, 'three');
        if (empty($tableId)) {
            return false;//台座ID不存在
        }
        $post['table_id'] = $tableId;
        $post['tg_id'] = $tgID;
        //2 获取下注游戏类型 //固定下注类型
        $post['game_type'] = GameModel::THREE_ODDS;

        $request = betPostData($post);
        $res = GameFacade::bettingPostTHREE($request, '/tg/user_bet_order');
        //判断返回数据是否正常   //处理接口返回数据
        if (empty($res)) {
            traceLog($res, '下注请求失败--');
            //tguser -- 下注失败--原因
            BotFacade::sendMessage($crowd, $tgUser['username'] . ' 下注失败');
            return false;
        }

        //解析json
        //tguser -- 下注成功--原因
        $this->analysisBetResponse($res, $crowd, $tgUser);

        return true;
    }
    //结束发送消息

    public function endSend(){
        //
    }
    //开牌发发送消息
    public function openSend(){

    }
}