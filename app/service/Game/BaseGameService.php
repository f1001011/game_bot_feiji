<?php

namespace app\service\Game;

use app\common\CacheKey;
use app\service\BaseService;
use app\traits\RedBotTrait;
use app\traits\TelegramTrait;

class BaseGameService extends BaseService
{
    use RedBotTrait;
    use TelegramTrait;
    public function commandAnalysis($command){

        if (substr_count($command, '/') <=0) {
            //不符合 下注字符串类型
            return [];
        }
        $array = []; //存放本次下注的所有数据  [[zy,100],['ll','100']]
        //判断是否是一次性下注多个

        if (substr_count($command, ' ') > 0) {
            $arrayOne = explode(' ', $command);

            //[’zy/100‘，’xy/100‘]
            foreach ($arrayOne as $key => $value) {
                //判断是否存在某个字符串  [[zy,100],['ll','100']]
                $o = [];
                $o = explode('/', $value);

                //判断 解析出来的是否符合规矩
                if (!isset($o[0]) || !isset($o[1]) || $o[1] <= 0) {
                    //不符合规矩，结束。
                    return [];
                }
                //符合规矩。存入 下注订单数据

                $array[] = $o;
            }

        } else {
            $o = [];
            $o = explode('/', $command); //判断 解析出来的是否符合规矩
            if (!isset($o[0]) || !isset($o[1]) || $o[1] <= 0) {
                //不符合规矩，结束。
                return [];
            }
            $array[] = $o;
        }

        return $array;
    }

    public function getToken($tgId){
        //获取 token 存入 redis
        //发送tgID 获取用户 token
        //
    }


    //发送台座开始下注信息
    public function startSend($urlsWithData)
    {
        //1 组装数据 把 json 数组取出来，用作redis 删除指定值

        //2 调用 接口发送信息
        $redisKey = CacheKey::BOT_TELEGRAM_TABLE_SEND_INFO;
        //发起数据请求发送到tg
        // 需要发送的 URL 和对应的 POST 数据

        // 初始化cURL多句柄
        $multiHandle = curl_multi_init();
        $curlHandles = []; // 存储cURL句柄的数组

        // 为每个URL创建cURL句柄并添加到多句柄中
        foreach ($urlsWithData as $urlData) {
            $ch = curl_init($urlData['url']);

            // 设置POST请求和POST数据
            curl_setopt($ch, CURLOPT_POST, true);
            $postFields = [];
            foreach ($urlData['data'] as $key => $value) {
                if ($value instanceof \CURLFile) {
                    // 对于文件，直接添加
                    $postFields[$key] = $value;
                } else {
                    // 对于非文件数据，确保它们是字符串
                    $postFields[$key] = (string)$value;
                }
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

            // 设置其他选项（可选）
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 返回响应内容而不是直接输出

            // 将句柄添加到多句柄中
            curl_multi_add_handle($multiHandle, $ch);

            // 存储句柄以便稍后使用
            $curlHandles[] = $ch;
        }

        // 执行多句柄请求
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
        } while ($running > 0);

        // 获取并处理每个请求的响应
        foreach ($curlHandles as $key => $ch) {
            $response = curl_multi_getcontent($ch);
            $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            // 在这里处理你的响应，例如打印、存储等
            echo "Response for $url: \n" . $response . "\n\n";
            traceLog(['url'=>$url,'$response'=>$response],'redis---curls---');
            // 清理句柄
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        // 关闭多句柄
        curl_multi_close($multiHandle);

    }

    //发送台座开始下注信息
    public function openEndSend($urlsWithData)
    {
        //1 组装数据 把 json 数组取出来，用作redis 删除指定值

        //2 调用 接口发送信息
        $redisKey = CacheKey::BOT_TELEGRAM_TABLE_SEND_INFO;
        //发起数据请求发送到tg
        // 需要发送的 URL 和对应的 POST 数据

        // 初始化cURL多句柄
        $multiHandle = curl_multi_init();
        $curlHandles = []; // 存储cURL句柄的数组

        // 为每个URL创建cURL句柄并添加到多句柄中
        foreach ($urlsWithData as $urlData) {
            $ch = curl_init($urlData['url']);

            // 设置POST请求和POST数据
            curl_setopt($ch, CURLOPT_POST, true);
            $postFields = [];
            foreach ($urlData['data'] as $key => $value) {
                if ($value instanceof \CURLFile) {
                    // 对于文件，直接添加
                    $postFields[$key] = $value;
                } else {
                    // 对于非文件数据，确保它们是字符串
                    $postFields[$key] = (string)$value;
                }
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

            // 设置其他选项（可选）
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 返回响应内容而不是直接输出

            // 将句柄添加到多句柄中
            curl_multi_add_handle($multiHandle, $ch);

            // 存储句柄以便稍后使用
            $curlHandles[] = $ch;
        }

        // 执行多句柄请求
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
        } while ($running > 0);

        // 获取并处理每个请求的响应
        foreach ($curlHandles as $key => $ch) {
            $response = curl_multi_getcontent($ch);
            $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            // 在这里处理你的响应，例如打印、存储等
            echo "Response for $url: \n" . $response . "\n\n";
            traceLog(['url'=>$url,'$response'=>$response],'redis---curls---');
            // 清理句柄
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        // 关闭多句柄
        curl_multi_close($multiHandle);

    }


}