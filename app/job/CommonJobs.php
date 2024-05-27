<?php

namespace app\job;

use app\common\JobKey;
use think\queue\Job;

class CommonJobs
{
    protected $job;

    public function fire(Job $job, $data)
    {
        $this->job = $job;
        // 执行邮件发送的逻辑
        // 这里简单模拟发送邮件
        $name = $data['command_name'];
        // 假设的邮件发送函数
        $this->send($name);
        // 如果邮件发送成功，则删除任务
        $job->delete();
        traceLog($name . ' 执行END');
        // 也可以记录日志等
    }

    private function send($name)
    {
        if (!isset($name)) {
            return true;
        }
        traceLog($name . ' 开始执行任务---' . $name . '---START');
        //判断需要执行的命令
        switch ($name) {//
            case JobKey::BJL_OPEN:
                break;

            case JobKey::BJL_START:
                    //百家乐开始信息
                break;
            case JobKey::NN_OPEN:

                break;
            case JobKey::NN_START:

                break;
            case JobKey::LH_OPEN:

                break;
            case JobKey::LH_START:

                break;
            case JobKey::THREE_OPEN:
                break;
            case JobKey::THREE_START:
                break;
        }
        traceLog($name . ' 结束执行任务---' . $name . '---END');
        return true;
    }

    // 如果任务执行失败，返回false，该任务会重新入队
    // 如果返回null，该任务会被删除
    public function failed($data)
    {
        // 记录失败日志等
        // ...
    }
}