#!/bin/bash
while : ;do
hour=`date "+%H%M"`
if [ $hour -lt 930 ];then
        echo "xiuxile"
	sleep 200
elif [ $hour -gt 1501 ];then
        echo "xiuxile"
	sleep 200
else
        php70 /home/living/wwwroot/jubi.yuxuantech.com/yii stock/compare 2>/dev/null &
	sleep 5
fi
done

