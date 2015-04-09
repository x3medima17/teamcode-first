#!/bin/bash
TMP=$1
TIMELIMIT=$2
MEMORY=$3
FILE=$4
cd $TMP
#echo $TMP

ulimit -v $MEMORY
timeout $TIMELIMIT ./$FILE
