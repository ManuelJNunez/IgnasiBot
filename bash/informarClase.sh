#!/bin/bash

USERID="444137662" # IDENTIFICADOR DEL GRUPO Y/O USUARIO.
KEY="" # TOKEN DEL BOT.
URL="https://api.telegram.org/bot$KEY/sendMessage"

FECHA=$(date +%A)

CODIGO='<?php $informarClase=TRUE; $diaSemana='"$FECHA"'; ?>'
echo $CODIGO > ../informarClase.php

MSG="¡Falta media hora para ir a clase! ¿Quieres informar al Grupo C? Di 'Si' o 'No'."
curl -s --max-time 10 -d "chat_id=$USERID&disable_web_page_preview=1&text=$MSG" $URL
