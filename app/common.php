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