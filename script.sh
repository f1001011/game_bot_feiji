#!/bin/bash

# 定义你的工作目录和锁文件
WORK_DIR="/www/wwwroot/tg_bot.bigtelegram.com/geek_tg_feiji"
LOCKFILE="$WORK_DIR/geek_tg_feiji.lock"

# 尝试获取锁
if ! (set -o noclobber; exec 200>"$LOCKFILE") 2>/dev/null; then
    echo "Another instance is already running." >&2
    exit 1
fi

# 使用 trap 命令在脚本退出时删除锁文件
trap "rm -f -- '$LOCKFILE'; exit" SIGINT SIGTERM EXIT

# 现在可以安全地执行你的任务了
while true; do
    cd "$WORK_DIR"
    php think gamestartbetcmd
    sleep 3
    php think gameopencmd
    sleep 3
done