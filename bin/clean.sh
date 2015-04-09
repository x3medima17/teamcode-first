#!/bin/bash
USER_ID=$1
SSID=$2
EXT=$3
SUBMISSION_ID=$4
#cd "tmp/"$SSID/
cp "tmp/"$SSID/file.$EXT ../upload/$USER_ID/$SUBMISSION_ID.$EXT

rm -rf "tmp/"$SSID

echo $USER_ID $SSID $EXT $SUBMISSION_ID
