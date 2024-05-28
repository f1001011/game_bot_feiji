<?php

namespace app\command;
use think\console\Command;

define('REQUEST_ID',md5(rand(100000, 999999) . 'request_id' . time()));
class BaseCommand extends Command
{

}