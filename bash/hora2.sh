#!/bin/bash

CHATID="$1" # IDENTIFICADOR DEL GRUPO Y/O USUARIO.
USERNAME="$2"
KEY="" # TOKEN DEL BOT.
URL="https://api.telegram.org/bot$KEY/sendMessage"

    hora=$(date +%T)
    MSG="$USERNAME son las $hora"
    curl -s --max-time 10 -d "chat_id=$CHATID&disable_web_page_preview=1&text=$MSG" $URL
