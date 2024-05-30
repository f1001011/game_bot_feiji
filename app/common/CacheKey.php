<?php
namespace app\common;
class CacheKey{


    const  REDIS_RED_ID_CREATE_SENG_INFO = 'bot_telegram:table_send_info:%s';
    const  BOT_TELEGRAM_TABLE_SEND_INFO = 'bot_telegram:table_send_info';//储存用户开始投注记录,队列，先进入数据在 上面 LPUSH 插入，。json格式数据，保存开始记录信息{table_id,game_type,start_time}
    const  BOT_TELEGRAM_TABLE_SEND_INFO_ON = 'bot_telegram:table_send_info_on';//保存使用 时候发生错误的 redis
    const  BOT_TELEGRAM_TABLE_OPEN_INFO = 'bot_telegram:table_open_info';//储存用户开牌投注记录，LPUSH 插入 。。json格式数据 保存开牌信息  {id（table_id）,game_type,open_pai,win}
    const  BOT_TELEGRAM_TABLE_OPEN_INFO_ON = 'bot_telegram:table_open_info_on';

    const  BOT_TELEGRAM_CACHE_END = 'bot_telegram:cache_end:%s';//防止脚本重复执行
    const  REDIS_RED_ID_CREATE_SENG_INFO_TTL = 36000;

    const TTL = 5*60;//计划任务key






}


