<?php

namespace app\middleware;

use app\traits\LogTrait;
use think\facade\Log;

class LogMiddleware
{
    use LogTrait;
    public function handle($request, \Closure $next)
    {
        //请求调用开始日志
        $this->log([$request->param()],'http_start');
        return $next($request);
    }

    public function end($request, \think\Response $response)
    {
        $this->log([$request->param(),$response],'http_end');
        // 回调行为
    }
}