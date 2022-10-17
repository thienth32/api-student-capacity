#!/bin/bash

compiler=$1
file=$2
output=$3

START=$(date +%s.%4N)

if $compiler $file > $output
then

END=$(date +%s.%4N)
runtime=$(echo "$END - $START" | bc)
echo $runtime

else
echo false
fi
