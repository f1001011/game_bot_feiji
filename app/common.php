<?php
// 应用公共文件

function success(array $data = [], $message = 'message', int $code = 200)
{
    echo json_encode(['data' => $data, 'message' => $message, 'code' => $code]);
    die;
}

function fail(array $data = [], $message = 'message', int $code = 500)
{
    echo json_encode(['data' => $data, 'message' => $message, 'code' => $code]);
    die;
}

function language(string $name = '')
{
    return lang($name);
}

function traceLog($message, $lv = '')
{
    trace($message, $lv . '-RESPONSE_ID:' . REQUEST_ID);
}


//生成token
function token($length = 10)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    $randomBytes      = random_bytes($length);

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[ord($randomBytes[$i]) % $charactersLength];
    }

    return $randomString;
}

function tgPostgSign($data = [], $secret = 'ab50831ca94d0f97ff679495abfae0f7')
{
    //升序排列
    ksort($data);
    $queryString = urldecode(http_build_query($data));

    if (!empty($secret)) {
        $queryString = $queryString . '&secret=' . $secret;
    }
    $md5 = md5($queryString);
    return strtolower($md5);
}

function betPostData($data){
    //组装下注数据请求
    $bet = json_encode($data['bet']);
    //base64
    $bet = base64_encode($bet);
    $data['bet'] = $bet;
    $data['sign'] = tgPostgSign($data);
    return $data;
}


function curlArray($urlsWithData){
    // 需要发送的 URL 和对应的 POST 数据
    $urlsWithData = [
        ['url' =>'http://example.com/api2','data'=> ['param1' => 'value1', 'param2' => 'value2']],
        ['url' =>'http://example.com/api2','data'=> ['param1' => 'value1', 'param2' => 'value2']],
        // ... 其他 URL 和数据
    ];

    // 初始化 cURL 多句柄
    $multiHandle = curl_multi_init();

    // 初始化每个请求的 cURL 句柄并添加到多句柄
    $curlHandles = [];
    foreach ($urlsWithData as $k => $postData) {
        $ch = curl_init($postData['url']);
        // 设置 cURL 选项
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData['data']));

        // 将 cURL 句柄添加到多句柄
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
    foreach ($curlHandles as $ch) {
        $response = curl_multi_getcontent($ch);
        // 在这里处理你的响应，例如打印、存储等
        echo "Response for {$url}: \n{$response}\n\n"; // 注意：这里 $url 并不是直接可用的，你需要维护它和你 cURL 句柄的对应关系

        // 清理句柄
        curl_multi_remove_handle($multiHandle, $ch);
        curl_close($ch);
    }

    // 关闭多句柄
    curl_multi_close($multiHandle);
}