#!/usr/bin/env sh

######################################################################
# @author      : mclds (mclds@protonmail.com)
# @file        : apagar
# @created     : Thursday Feb 03, 2022 13:33:24 UTC
#
# @description : Converts a html file into php and erases a file. 
######################################################################


for d in */ ; do
    cd "$d"
    ls -la
    rm content.html
    mv con.html content.php
    cd '../'
done
