<?php

namespace app\service\Game;


use app\common\CacheKey;
use app\facade\BotFacade;
use app\model\GameModel;
use app\facade\GameFacade;
use think\facade\Cache;

class BotBjlService extends BaseGameService
{
    /**
     * @param $money /下注金额
     * @param $gameType / 下注游戏类型
     * @param string $type /下注游戏
     * @param string $rateId /下注ID /赔率ID
     */
    public function Betting(string $command,string $crowd,array $tgUser)
    {

        // zy/100&xy/100&hy/100
        //判断下注中是否有 逗号和 / 符号
        //解析 !strpos($command, '&') ||
        $array = $this->commandAnalysis($command); //[[zy,100],['ll','100']]

        if (empty($array)){
            return [];//不符合规矩
        }

        //便利组装下注信息
        $tgID = $tgUser['id'];
        $post = [];
        foreach ($array as $key=>$value){
            $res = [];
            //1 获取下注台座
            $tableId = 0;

            //3 获取下注比例 ID

            if (!isset(GameModel::BJL_ODDS[$value[0]])){
                //判断 赔率ID 是否存在，不存在直接 退出
                return false;
            }
            $res['rate_id'] = GameModel::BJL_ODDS[$value[0]];//查询游戏配率ID

            //4 组装下注信息
            $res['money'] = $value[1];
            $post['bet'][] = $res;
        }
        
        $tableId = GameModel::getInstance()->getTableId($crowd,'bjl');
        if (empty($tableId)){
            return false;//台座ID不存在
        }
        $post['table_id'] = $tableId;
        $post['tg_id'] = $tgID;
         //2 获取下注游戏类型 //固定下注类型
         $post['game_type'] = GameModel::BJL_TYPE;
           
        $request = betPostData($post);
        $res = GameFacade::bettingPostBJL($request,'/tg/user_bet_order');
        //判断返回数据是否正常   //处理接口返回数据
        if (empty($res)){
            traceLog($res,'下注请求失败--');
            //tguser -- 下注失败--原因
            $this->sendMessage($crowd,$tgUser['username'].' 下注失败');
            return false;
        }
        
        //解析json
        //tguser -- 下注成功--原因
        $this->analysisBetResponse($res,$crowd,$tgUser);
     
        return true;
    }

    //结束发送消息

    public function endSend()
    {
        //结束投注发送消息到结束投注
    }

    //开牌发发送消息
    public function openSend()
    {
        //开牌发送开牌信息
        //发送开奖盈亏
    }


    //发送台座开始下注信息
    public function startSend($urlsWithData){
        //1 组装数据 把 json 数组取出来，用作redis 删除指定值

        //2 调用 接口发送信息
        $redisKey = CacheKey::BOT_TELEGRAM_TABLE_SEND_INFO;
        //发起数据请求发送到tg
        // 需要发送的 URL 和对应的 POST 数据

        // 初始化 cURL 多句柄
        $multiHandle = curl_multi_init();

        // 用于跟踪句柄和 URL 的关联数组
        $curlHandles = [];

        // 初始化每个请求的 cURL 句柄并添加到多句柄
        foreach ($urlsWithData as $requests) {
            $ch = curl_init($requests['url']);
            // 设置 cURL 选项
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requests['data']));
            // 将 cURL 句柄和 URL 添加到跟踪数组中
            $curlHandles[$ch] = ['url' => $requests['url'], 'response' => null];
            // 将 cURL 句柄添加到多句柄
            curl_multi_add_handle($multiHandle, $ch);
        }

        // 执行多句柄请求
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
        } while ($running > 0);

        // 获取并处理每个请求的响应
        foreach ($curlHandles as $ch => $info) {
            $responses        = curl_multi_getcontent($ch);
            $info['response'] = $responses; // 将响应存储到跟踪数组中

            // 在这里处理你的响应。例如打印、存储等，
            //echo "Response for {$info['url']}: \n{$responses}\n\n";
            traceLog([$info,$responses]);
            //成功删除指定的 redis信息   获取指定的url
            //Cache::LREM($redisKey, 0, $value);

            // 清理句柄
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
            // 可以选择从 $curlHandles 数组中移除已处理的句柄和信息
            unset($curlHandles[$ch]);
        }
        // 关闭多句柄
        curl_multi_close($multiHandle);

    }
}