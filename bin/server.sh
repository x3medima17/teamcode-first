#!/bin/bash
function init {
	LIST=`pgrep python`
	IFS=' ' read -a arr <<< "${LIST}"
	for pid in "${arr[@]}"
	do
		echo $pid
		`kill -9 $pid`
	done
}
init
IN=`python server.py`&

CONTENT=`cat server.py`
while :
do
	sleep 1
	CURR=`cat server.py`
	if [ "$CONTENT" != "$CURR" ]; 
		then 
			init
			IN=`python server.py`&
			CONTENT=`cat server.py`

			echo "Restarted."
		fi;
done