<?php

namespace think;

class GameBetting
{


    //用户下注接口 post请求解析 百家乐
    public static function bettingPostBJL($postData,$path){
        $url = config('telegram.bjl-betting-url').'/路径';
        // 初始化 cURL
        $ch = curl_init();

        // 转换为 JSON 字符串（如果需要）
        // $postData = json_encode($postData);

        // 设置 POST 请求的头部信息
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded', // 或者 application/json 如果你发送 JSON
            'Content-Length: ' . strlen(http_build_query($postData))
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // 或者直接使用 $postData 如果你发送 JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 发送请求并获取响应
        $response = curl_exec($ch);

        // 检查是否有错误发生
        if(curl_errno($ch)){
            traceLog(curl_error($ch),'bettingPostBJL');
        }

        // 关闭 cURL 资源
        curl_close($ch);

        // 处理响应
        return $response;
    }

    //龙虎斗下注
    public static function bettingPostLH($postData,$path){
        $url = config('telegram.lh-betting-url').$path;
        // 初始化 cURL
        $ch = curl_init();

        // 转换为 JSON 字符串（如果需要）
        // $postData = json_encode($postData);

        // 设置 POST 请求的头部信息
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded', // 或者 application/json 如果你发送 JSON
            'Content-Length: ' . strlen(http_build_query($postData))
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // 或者直接使用 $postData 如果你发送 JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 发送请求并获取响应
        $response = curl_exec($ch);

        // 检查是否有错误发生
        if(curl_errno($ch)){
            traceLog(curl_error($ch),'bettingPostLH');
        }

        // 关闭 cURL 资源
        curl_close($ch);

        // 处理响应
        echo $response;
    }

    //牛牛下注
    public static function bettingPostNN($postData,$path){
        $url = config('telegram.lh-betting-url').$path;
        // 初始化 cURL
        $ch = curl_init();

        // 转换为 JSON 字符串（如果需要）
        // $postData = json_encode($postData);

        // 设置 POST 请求的头部信息
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded', // 或者 application/json 如果你发送 JSON
            'Content-Length: ' . strlen(http_build_query($postData))
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // 或者直接使用 $postData 如果你发送 JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 发送请求并获取响应
        $response = curl_exec($ch);

        // 检查是否有错误发生
        if(curl_errno($ch)){
            traceLog(curl_error($ch),'bettingPostNN');
        }

        // 关闭 cURL 资源
        curl_close($ch);

        // 处理响应
        echo $response;
    }

    //三公下注
    public static function bettingPostThree($postData,$path){
        $url = config('telegram.three-betting-url').$path;
        // 初始化 cURL
        $ch = curl_init();

        // 转换为 JSON 字符串（如果需要）
        // $postData = json_encode($postData);

        // 设置 POST 请求的头部信息
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded', // 或者 application/json 如果你发送 JSON
            'Content-Length: ' . strlen(http_build_query($postData))
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // 或者直接使用 $postData 如果你发送 JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 发送请求并获取响应
        $response = curl_exec($ch);

        // 检查是否有错误发生
        if(curl_errno($ch)){
            traceLog(curl_error($ch),'bettingPostThree');
        }

        // 关闭 cURL 资源
        curl_close($ch);

        // 处理响应
        echo $response;
    }
}