#!/bin/bash

cd /www/wwwroot/tg_bot.bigtelegram.com/geek_tg_feiji
while true; do
    php think  gamestartbetcmd
    sleep 3
    php think  gameopencmd
    sleep 3
done