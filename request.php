<?php

// Introducimos el token de nuestro BOT.
$botToken = "";
 
$website = "https://api.telegram.org/bot".$botToken;

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$modo = 0;
 
$chatId = $update["message"]["chat"]["id"];
$messageId = $update["message"]["message_id"];
$chatType = $update["message"]["chat"]["type"];
$userId = $update["message"]['from']['id'];
$firstname = $update["message"]['from']['username'];

if ($firstname=="") {
    $modo=1;
    $firstname = $update["message"]['from']['first_name'];
}
 
if ($modo == 0) {
    $firstname = "@".$firstname;
}
 
$message = $update["message"]["text"];
 
//$agg = json_encode($update, JSON_PRETTY_PRINT);

//Con explode tomamos el primer valor del mensaje, que será el comando.
$arr = explode(' ',trim($message));
$command = $arr[0];

$message = substr(strstr($message," "), 1);

switch ($command) {
    case '/ayuda': case '/ayuda@Ignasi_Bot':
        $response = "$firstname para usar el bot tan solo deberás poner el comando que desees en el chat del grupo o por privado y él te responderá."
            . "\n\nActualmente puedes hacer uso del /ayuda, /github, /examenes, /entregas y /viva."
            . "\n\nVersión 1.0 - Si tienes alguna sugerencia puedes escribirla a @IgnasiCR";
        sendMessage($chatId, $response);
    	deleteMessage($chatId, $messageId);
    break;
    case '/github': case '/github@Ignasi_Bot':
    	$response = "$firstname mi GitHub es <a href='https://github.com/IgnasiCR'>IgnasiCR</a>";
        sendMessage($chatId, $response);
    	deleteMessage($chatId, $messageId);
    break;
    case '/examenes': case '/examenes@Ignasi_Bot':
    	$response = "$firstname los exámenes próximos son: "
            . "\n\n* 12 Abril - FIS Tema 2.4"
            . "\n* 7 Mayo - AC Tema 3"
            . "\n* 28 Mayo - AC Tema 4";
    	sendMessage($chatId, $response);
    	deleteMessage($chatId, $messageId);
    break;
    case '/entregas': case '/entregas@Ignasi_Bot':
    	//$response = "¡Estás de suerte! Ahora mismo no hay entregas para el grupo grande.";
    	$response = "$firstname las entregas próximas son: "
            . "\n\n* <a href='https://pradogrado.ugr.es/moodle/mod/assign/view.php?id=154588'>14 Abril - FIS Problemas 2.3</a>";
        sendMessage($chatId, $response);
    	deleteMessage($chatId, $messageId);
    break;
    case '/viva': case '/viva@Ignasi_Bot':
    	$response = "¡VIVA ES****, DIGO LA ETSIIT!";
    	sendMessage($chatId, $response);
    	deleteMessage($chatId, $messageId);
    break;
    case 'hola': case 'Hola': case 'HOLA':
    	$response = "Pa' ti mi cola.";
    	sendMessage($chatId, $response);
    break;
    case 'pole': case 'Pole': case 'POLE':
    	$response = "¿$firstname que te crees qué estamos en Forocoches? Telita...";
    	sendMessage($chatId, $response);
    break;
    case 'catalunya': case 'Catalunya':
    	$response = "Bon cop de falç!";
    	sendMessage($chatId, $response);
    break;
    case 'Delegado': case 'Delegao': case 'delegado': case 'delegao':
    	$response = "¡¡DIMISIÓN!!";
    	sendMessage($chatId, $response);
    break;
    case 'Efe': case 'efe': case 'F': case 'f':
        $urlsticker = "https://ignasicr.es/bots/imgs/efe.webp";
        sendSticker($chatId, $urlsticker);
        deleteMessage($chatId, $messageId);
    break;
    default:
        $tamanio = count($arr);
        for($i = 0; $i <= $tamanio; $i++){
            $command2 = $arr[$i];
            switch ($command2){
                case 'ATC': case 'atc': case 'Atc':
                    $response = "¿Alguien dijo ATC? DEP";
                    $urlphoto = "https://ignasicr.es/bots/imgs/atc_perro.jpg";
                    sendPhoto($chatId, $urlphoto, $response);
                break;
                case 'bubo': case 'Bubo': case 'BUBO': case 'bubito': case 'Bubito':
                    $response = "Bubo, titiri titiri";
                    sendMessage($chatId, $response);
                break;
                case 'Cinco': case 'cinco': case '5':
                    $response = "¡Por el culo te la hinco!";
                    sendMessage($chatId, $response);
                break;
                case 'Ocho': case 'ocho': case '8':
                    $response = "¡Cómete un bizcocho!";
                    sendMessage($chatId, $response);
                break;
                case 'Trece': case 'trece': case '13':
                    $response = "¡Agarramela que me crece!";
                    sendMessage($chatId, $response);
                break;
            }
        }
    break;
 
}
 
function sendMessage($chatId, $response){
    $url = $GLOBALS[website].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response).'&disable_notification=true';
    file_get_contents($url);
}

function deleteMessage($chatId, $messageId){
   $url = $GLOBALS[website].'/deleteMessage?chat_id='.$chatId.'&message_id='.$messageId;
   file_get_contents($url);
}

function sendPhoto($chatId,$urlphoto,$response){
  if($response == ""){
    $url = $GLOBALS[website].'/sendPhoto?chat_id='.$chatId.'&photo='.$urlphoto.'&disable_notification=true';
  }else{
  	$url = $GLOBALS[website].'/sendPhoto?chat_id='.$chatId.'&photo='.$urlphoto.'&caption='.$response.'&disable_notification=true';
  }
  file_get_contents($url);
}

function sendSticker($chatId, $urlsticker){
  $url = $GLOBALS[website].'/sendSticker?chat_id='.$chatId.'&sticker='.$urlsticker.'&disable_notification=true';
  file_get_contents($url);
}

?>

