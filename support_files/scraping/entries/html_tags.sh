#!/usr/bin/env bash

######################################################################
# @author      : mclds (mclds@protonmail.com)
# @file        : html_tags
# @created     : Thursday Feb 03, 2022 12:57:04 UTC
#
# @description : Inserts html tags in rss content files.
######################################################################


for d in */ ; do
    cd "$d"
    ls -la
    sed -e 's/\. /\.<br>/g' content.html > cont.html
    sed '1 s/./<p>&/' cont.html > con.html
    echo '</p>' >> con.html
    rm cont.html
    rm content.html
    mv con.html content.php
    cd '../'
done
