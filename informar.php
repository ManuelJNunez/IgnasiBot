<?php

include_once 'informarClase.php';
$idClase = -1001152952278;

if($userId == 444137662 && $informarClase == TRUE){

  switch($message){

    case 'si': case 'Si':

    $escritura='<?php $informarClase=FALSE; ?>';
    $file= fopen("informarClase.php","w");
    fwrite($file, $escritura);
    fclose($file);

    $hora = shell_exec('sh bash/hora3.sh');

    switch($diaSemana){

      case 'Monday':
        $message="$hora\n 15:30-16:30 -> FIS(C1) / FBD(C2) / AC (C3)\n 16:30-17:30 -> FIS(C1) / ALG(C2) / AC(C3)\n 17:30-18:30 -> ALG\n 18:30-19:30 -> AC";
        sendMessage($idClase, $message, FALSE);
      break;

      case 'Tuesday':
      $message="$hora\n 15:30-16:30 -> FBD(C1) / FIS(C2) / ALG (C3)\n 16:30-17:30 -> ALG(C1) / FIS(C2) / FBD(C3)\n 17:30-18:30 -> AC\n 18:30-19:30 -> FBD";
      sendMessage($idClase, $message, FALSE);
      break;

      case 'Wednesday':
      $message="$hora\n 15:30-16:30 -> IA(C1) / AC(C2) / FBD (C3)\n 16:30-17:30 -> IA(C1) / AC(C2) / FBD(C3)\n 17:30-18:30 -> IA\n 18:30-19:30 -> IA";
      sendMessage($idClase, $message, FALSE);
      break;

      case 'Thursday':
      $message="$hora\n 15:30-16:30 -> FBD(C1) / IA(C2) / FIS (C3)\n 16:30-17:30 -> FBD(C1) / IA(C2) / FIS(C3)\n 17:30-18:30 -> ALG\n 18:30-19:30 -> ALG";
      sendMessage($idClase, $message, FALSE);
      break;

      case 'Friday':
      $message="$hora\n 15:30-16:30 -> AC(C1) / FBD(C2) / IA (C3)\n 16:30-17:30 -> AC(C1) / FBD(C2) / IA(C3)\n 17:30-18:30 -> FIS\n 18:30-19:30 -> FIS";
      sendMessage($idClase, $message, FALSE);
      break;

    }
    break;

    case 'No': case 'no':

    $escritura='<?php $informarClase=FALSE; ?>';
    $file= fopen("informarClase.php","w");
    fwrite($file, $escritura);
    fclose($file);

    $message = "De acuerdo $firstname, no enviaré el mensaje.";
    sendMessage($chatId, $message, FALSE);
    break;

  }

}

 ?>
