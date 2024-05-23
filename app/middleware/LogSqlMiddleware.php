<?php
namespace app\middleware;

use app\traits\LogTrait;
use Closure;
use think\facade\Db;
use think\facade\Log;

class LogSqlMiddleware
{
    use LogTrait;
    public function handle($request, Closure $next)
    {
        Db::listen(function ($sql, $time, $explain)use ($request) {
            // 记录SQL语句、执行时间和解释信息到日志
            $log = [
                'title'=>'SQL记录:',
              'sql' => $sql,
                'time' => $time,
                'explain' => $explain,
                'request_id'=>$request->request_id,
            ];
            $this->log($log,'mysql记录日志');
        });
        $response = $next($request);

        // 执行后可进行的操作
        return $response;
    }
}