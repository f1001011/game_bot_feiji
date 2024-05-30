配置多语言，中间件，验证器


需要执行 2个命令
            如果用sh执行计划任务添加 /bin/bash /www/wwwroot/tg_bot.bigtelegram.com/geek_tg_feiji/script.sh
                php think  gamestartbetcmd  牌局开始信号
                php think  gameopencmd      牌局开牌信号
                可加入 牌局结束信息（未写）

发送命令标准：
                GameModel 模型下 LH_ODDS 赔率的 配置字母 /l/100  表示龙虎  龙赢 100元

配置文件 env 
                配置储存信息， 机器人 key ，机器人绑定地址


config/telegram
                配置 发送到tg 的图片信息。
                配置 tg群号对应的台座 ID
                配置 每个游戏的下注地址