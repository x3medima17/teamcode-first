#!/bin/bash
SSID=$1
EXT=$2
cd tmp/$SSID
if [ "$EXT" == "pas" ]; then
	REZ=`fpc -Xs file.pas`
fi
if [ "$EXT" == "c" ]; then
	REZ=`g++ -Wall -O2 -static -o file file.c`
fi
if [ "$EXT" == "cpp" ]; then
	REZ=`g++ -Wall -O2 -static -o file file.cpp`
fi

if [ -f file ]; then
	REZ="0"
else
	REZ="1"
fi;
echo $REZ