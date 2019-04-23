<?php

include_once 'funciones.php';
include_once 'conexion.php';
include_once 'variables.php';
include_once 'almacen.php';
include_once 'estados.php';
include_once 'informar.php';

// CON EL EXPLODE TOMAMOS EL PRIMER VALOR DEL MENSAJE ASÍ VEMOS SI ESTÁ USANDO EL COMANDO O NO.
$arr = explode(' ',trim($message));
$command = $arr[0];

$message = substr(strstr($message," "), 1);

switch ($command) {

      // SISTEMA PARA MOSTRAR LA HORA DEL SERVIDOR.

    case '/hora': case 'hora@Ignasi_Bot':

    shell_exec('sh bash/hora2.sh '.$chatId.' '.$firstname.'');
    deleteMessage($chatId, $messageId);
    break;

      // SISTEMA PARA ENVIAR UN MENSAJE A TRAVÉS DEL BOT AL GRUPO GENERAL.

    case '/enviarMensaje': case '/enviarMensaje@Ignasi_Bot':

    if($userId==444137662){ // La ID es la del Administrador.
      $response = "De acuerdo, $firstname. A continuación deberás darme el mensaje que quieres enviar por el grupo:";
      $consulta="UPDATE usuario SET estado='11' WHERE id='$userId';";
      mysqli_query($conexion, $consulta);
      sendDeleteMessage($chatId, $messageId, $response, FALSE);
      mysqli_close($conexion);
    }else{
      $response = "¿A dónde vas $firstname? ¿Te creías que tu podrías hacerlo?";
      sendDeleteMessage($chatId, $messageId, $response, FALSE);
    }
    break;

      // SISTEMA PARA CONSEGUIR EL ID DEL CHAT

    case '/obtenerGid': case '/obtenerGid@Ignasi_Bot':

    $response = "$firstname el ID del chat es el: $chatId";
    deleteMessage($chatId, $messageId);
    sendMessage($userId, $response, FALSE);
    break;

      // SISTEMA PARA CONSEGUIR EL ID PROPIO

    case '/obtenerUid': case '/obtenerUid@Ignasi_Bot':

    $response = "$firstname tu ID es el: $userId";
    deleteMessage($chatId, $messageId);
    sendMessage($userId, $response, FALSE);
    break;

      // SISTEMA PARA AÑADIR NUEVOS EXÁMENES EN LA BASE DE DATOS.

    case '/añadirExamen': case '/añadirExamen@Ignasi_Bot':

    if($userId==444137662){ // La ID es la del Administrador.
      $response = "De acuerdo, $firstname. A continuación deberás ir dándome información la cuál añadiré a la base de datos. Empecemos por el nombre.";
      $consulta="UPDATE usuario SET estado='2' WHERE id='$userId';";
      mysqli_query($conexion, $consulta);
      sendDeleteMessage($chatId, $messageId, $response, FALSE);
      mysqli_close($conexion);
    }else{
      $response = "¿A dónde vas $firstname? ¿Te creías que tu podrías hacerlo?";
      sendDeleteMessage($chatId, $messageId, $response, FALSE);
    }
    break;

    // SISTEM PARA ELIMINAR EXÁMENES DE LA BASE DE DATOS.

    case '/eliminarExamen': case '/eliminarExamen@Ignasi_Bot':

      if($userId==444137662){
        $consulta="SELECT * FROM `examen` ORDER BY `fecha` ASC;";
        $datos = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($datos)>0){
          $response = "$firstname los exámenes que se encuentran en la base de datos son los siguientes: \n";

          while($fila=mysqli_fetch_array($datos,MYSQLI_ASSOC)){
            $response .= "\n* [$fila[id]] $fila[fecha] - $fila[asignatura] $fila[temas]";
          }

          $response .= "\n\nDime el identificador del examen que quieres eliminar de la misma.";

          $consulta="UPDATE usuario SET estado='5' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          sendDeleteMessage($chatId, $messageId, $response, TRUE);
          mysqli_close($conexion);

        }else{
          $response = "¡$firstname ahora mismo no hay exámenes en la base de datos!";
        }
      }else{
        $response ="¿A dónde vas $firstname? ¿Te creías que tu podrías hacerlo?";
        sendDeleteMessage($chatId, $messageId, $response, FALSE);
      }
    break;

    // SISTEMA PARA AÑADIR NUEVAS ENTREGAS EN LA BASE DE DATOS.

  case '/añadirEntrega': case '/añadirEntrega@Ignasi_Bot':

  if($userId==444137662){ // La ID es la del Administrador.
    $response = "De acuerdo, $firstname. A continuación deberás ir dándome información la cuál añadiré a la base de datos. Empecemos por el nombre.";
    $consulta="UPDATE usuario SET estado='6' WHERE id='$userId';";
    mysqli_query($conexion, $consulta);
    sendDeleteMessage($chatId, $messageId, $response, FALSE);
    mysqli_close($conexion);
  }else{
    $response = "¿A dónde vas $firstname? ¿Te creías que tu podrías hacerlo?";
    sendDeleteMessage($chatId, $messageId, $response, FALSE);
  }
  break;

  // SISTEM PARA ELIMINAR ENTREGAS DE LA BASE DE DATOS.

  case '/eliminarEntrega': case '/eliminarEntrega@Ignasi_Bot':

    if($userId==444137662){
      $consulta="SELECT * FROM `entregas` ORDER BY `fecha` ASC;";
      $datos = mysqli_query($conexion, $consulta);

      if(mysqli_num_rows($datos)>0){
        $response = "$firstname las entregas que se encuentran en la base de datos son las siguientes: \n";

        while($fila=mysqli_fetch_array($datos,MYSQLI_ASSOC)){
          $response .= "\n* [$fila[id]] <a href='$fila[enlace]'>$fila[fecha] - $fila[asignatura] $fila[descripcion]</a>";
        }

        $response .= "\n\nDime el identificador de la entrega que quieres eliminar de la misma.";

        $consulta="UPDATE usuario SET estado='10' WHERE id='$userId';";
        mysqli_query($conexion, $consulta);

        sendDeleteMessage($chatId, $messageId, $response, FALSE);
        mysqli_close($conexion);

      }else{
        $response = "¡$firstname ahora mismo no hay entregas en la base de datos!";
      }
    }else{
      $response ="¿A dónde vas $firstname? ¿Te creías que tu podrías hacerlo?";
      sendDeleteMessage($chatId, $messageId, $response, FALSE);
    }
  break;

      // SISTEMA PARA ENVIAR MENSAJES O REGISTRAR AL USUARIO EN EL SISTEMA.

    case '/mimensaje': case '/mimensaje@Ignasi_Bot':

        $consulta="SELECT * FROM `usuario` WHERE id='$usuario';";
	      $datos=mysqli_query($conexion,$consulta);

      	if(mysqli_num_rows($datos)>0){
                  $fila=mysqli_fetch_array($datos,MYSQLI_ASSOC);

                  if($fila['mensaje']!=NULL){
                         $response = "$firstname dice: ".$fila['mensaje'];
                         sendDeleteMessage($chatId, $messageId, $response, FALSE);
                  }else{
                         $response = "$firstname no tienes ningún mensaje asignado a su cuenta, el próximo mensaje envíado será el almacenado.";
                         $consulta="UPDATE usuario SET estado='1' WHERE id='$userId';";
                         mysqli_query($conexion, $consulta);
                         deleteMessage($chatId, $messageId);
                         sendMessage($userId, $messageId, $response, FALSE);
                  }
      	}else{
                  $consulta="INSERT INTO `usuario` (id, nombre, estado) VALUES ('$userId', '$firstname', '1');";
                  mysqli_query($conexion, $consulta);

                  $response = "$firstname no tienes ningún mensaje asignado a su cuenta, el próximo mensaje envíado será el almacenado.";
                  deleteMessage($chatId, $messageId);
                  sendMessage($userId, $messageId, $response, FALSE);
                  mysqli_close($conexion);
              }
    break;

      // SISTEMA PARA MODIFICAR MENSAJES O REGISTRAR AL USUARIO EN EL SISTEMA.

    case '/modificarmimensaje': case '/modificarmimensaje@Ignasi_Bot':
    if($chatType=='private'){
        $consulta="SELECT * FROM `usuario` WHERE id='$usuario';";
	      $datos=mysqli_query($conexion,$consulta);

      	if(mysqli_num_rows($datos)>0){
                  $fila=mysqli_fetch_array($datos,MYSQLI_ASSOC);

                  if($fila['mensaje']!=NULL){
                         $response = "$firstname su mensaje será modificado, lo próximo que mandes será utilizado como tu nuevo mensaje.";
                         $consulta="UPDATE usuario SET estado='1',mensaje='NULL' WHERE id='$userId';";
                         mysqli_query($conexion, $consulta);
                         sendDeleteMessage($chatId, $messageId, $response, FALSE);
                  }else{
                         $response = "$firstname no tienes ningún mensaje asignado a tu cuenta, utiliza el comando /mimensaje para crearlo.";
                         sendDeleteMessage($chatId, $messageId, $response, FALSE);
                  }
      	}else{
                  $consulta="INSERT INTO `usuario` (id, nombre) VALUES ('$userId', '$firstname');";
                  mysqli_query($conexion, $consulta);

                  $response = "$firstname no tienes ningún mensaje asignado a tu cuenta, utiliza el comando /mimensaje para crearlo.";
                  sendDeleteMessage($chatId, $messageId, $response, FALSE);
                  mysqli_close($conexion);
              }
    }else{
      $response = "$firstname esta función solo está permitida en un chat privado conmigo.";
      sendDeleteMessage($chatId, $messageId, $response, FALSE);
    }
    break;

      // COMANDO PARA PEDIR AYUDA ACERCA DE LOS COMANDOS DEL BOT.

    case '/ayuda': case '/ayuda@Ignasi_Bot':
        $response = "$firstname para usar el bot tan solo deberás poner el comando que desees en el chat del grupo o por privado y él te responderá."
            . "\n\nActualmente puedes hacer uso del /ayuda, /github, /examenes, /entregas, /enlaces, /horario, /mimensaje, /modificarmimensaje, /cuentaalgo y /viva."
            . "\n\nVersión 3.0 - Si tienes alguna sugerencia puedes escribirla a @IgnasiCR";
        sendDeleteMessage($chatId, $messageId, $response, FALSE);
    break;

      // COMANDO PARA MOSTRAR EL GITHUB DEL CREADOR.

    case '/github': case '/github@Ignasi_Bot':
    	$response = "$firstname mi GitHub es <a href='https://github.com/IgnasiCR'>IgnasiCR</a>";
      sendDeleteMessage($chatId, $messageId, $response, FALSE);
    break;

      // COMANDO PARA MOSTRAR EN PANTALLA LOS ENLACES MÁS IMPORTANTES Y NECESARIOS.

    case '/enlaces': case '/enlaces@Ignasi_Bot':
        $response = "$firstname aquí tienes los enlaces más importantes y necesarios:"
            . "\n\n <b>Webs:</b>"
            . "\n\n* <a href='https://deiit.ugr.es/'>Web DEIIT</a>"
            . "\n\n* <a href='https://deiit.ugr.es/BDExamenes/search.html'>BDExamenes DEIIT</a>"
            . "\n\n* <a href='https://bit.ly/2In7pay'>Guias Docentes GII</a>"
            . "\n\n <b>Canales Telegram</b>"
            . "\n\n* <a href='t.me/DEIITInforma'>DEIIT Informa</a>";
        sendDeleteMessage($chatId, $messageId, $response, TRUE);
    break;

      // SISTEMA PARA MOSTRAR POR PANTALLA LOS EXAMENES PRÓXIMOS.

    case '/examenes': case '/examenes@Ignasi_Bot':
      $consulta="SELECT * FROM `examen` ORDER BY `fecha` ASC;";
      $datos = mysqli_query($conexion, $consulta);

      if(mysqli_num_rows($datos)>0){
        $response = "$firstname los exámenes próximos son: \n";

        while($fila=mysqli_fetch_array($datos,MYSQLI_ASSOC)){
          $response .= "\n* $fila[fecha] - $fila[asignatura] $fila[temas]";
        }
      }else{
        $response = "¡$firstname estás de suerte! Ahora mismo no hay exámenes para el grupo grande.";
      }

      sendDeleteMessage($chatId, $messageId, $response, FALSE);
      mysqli_close($conexion);
    break;

      // SISTEMA PARA MOSTRAR POR PANTALLA LAS ENTREGAS PRÓXIMAS

    case '/entregas': case '/entregas@Ignasi_Bot':
      $consulta="SELECT * FROM `entregas` ORDER BY `fecha` ASC;";
      $datos = mysqli_query($conexion, $consulta);

      if(mysqli_num_rows($datos)>0){
        $response = "$firstname las entregas próximas son: \n";

        while($fila=mysqli_fetch_array($datos,MYSQLI_ASSOC)){
          $response .= "\n* <a href='$fila[enlace]'>$fila[fecha] - $fila[asignatura] $fila[descripcion]</a>";
        }
      }else{
        $response = "¡$firstname estás de suerte! Ahora mismo no hay entregas para el grupo grande.";
      }
      sendDeleteMessage($chatId, $messageId, $response, TRUE);
      mysqli_close($conexion);
    break;

      // COMANDO PARA LEVANTAR A LA ETSIIT.

    case '/viva': case '/viva@Ignasi_Bot':
    	$response = "¡VIVA ES****, DIGO LA ETSIIT! 📢";
    	sendDeleteMessage($chatId, $messageId, $response, FALSE);
    break;

      // COMANDO PARA OFRECER EL HORARIO DEL GRUPO.

    case '/horario': case '/horario@Ignasi_Bot':
        $response = "Horario 2ºC GII";
        $urlphoto = "https://ignasicr.es/bots/imgs/horario_2grupo.png";
        sendPhoto($chatId, $urlphoto, $response);
        deleteMessage($chatId, $messageId);
    break;

      // SISTEMA PARA QUE EL BOT CUENTE ALGO ALEATORIO

      case '/cuentaalgo': case '/cuentaalgo@Ignasi_Bot':

        $numeroAleatorio = random_int(0, 10);
        $consulta="SELECT * FROM `datosInteresantes` WHERE id='$numeroAleatorio';";
        $datos=mysqli_query($conexion,$consulta);
        $fila=mysqli_fetch_array($datos,MYSQLI_ASSOC);

        $response = "$fila[dato]";
        sendDeleteMessage($chatId, $messageId, $response, FALSE);
      break;

      // PALABRAS CLAVE PARA MENSAJES GRACIOSOS

    case 'pole': case 'Pole': case 'POLE':
    	$response = "¿$firstname que te crees qué estamos en Forocoches? Telita...";
    	sendMessage($chatId, $response, FALSE);
    break;
    case 'Delegado': case 'Delegao': case 'delegado': case 'delegao':
    	$response = "¡¡DIMISIÓN!!";
    	sendMessage($chatId, $response, FALSE);
    break;
    case 'Efe': case 'efe': case 'F': case 'f':
        $urlsticker = "https://ignasicr.es/bots/imgs/efe.webp";
        sendSticker($chatId, $urlsticker);
        deleteMessage($chatId, $messageId);
    break;

      // PALABRAS CLAVE EN CUALQUIER LUGAR DE UN MENSAJE PARA MENSAJES GRACIOSOS

    default:
        $tamanio = count($arr);
        for($i = 0; $i <= $tamanio; $i++){
            $command2 = $arr[$i];
            switch ($command2){
                case 'ATC': case 'atc': case 'Atc':
                    $response = "¿Alguien dijo ATC? DEP";
                    $urlphoto = "https://ignasicr.es/bots/imgs/atc_perro.jpg";
                    sendPhoto($chatId, $urlphoto, $response);
                    exit;
                break;
                case 'bubo': case 'Bubo': case 'BUBO': case 'bubito': case 'Bubito': case 'bubo,': case 'BUBO,': case 'Bubo,':
                    $response = "Bubo, titiri titiri 🦉🎶";
                    sendMessage($chatId, $response, FALSE);
                    exit;
                break;
                case 'Cinco': case 'cinco': case '5':
                    $response = "¡Por el culo te la hinco!";
                    sendMessage($chatId, $response, FALSE);
                    exit;
                break;
                case 'Ocho': case 'ocho': case '8':
                    $response = "¡Cómete un bizcocho!";
                    sendMessage($chatId, $response, FALSE);
                    exit;
                break;
                case 'Trece': case 'trece': case '13':
                    $response = "¡Agarramela que me crece!";
                    sendMessage($chatId, $response, FALSE);
                    exit;
                break;
                case 'catalunya': case 'Catalunya':
                	$response = "Bon cop de falç! 🎶";
                	sendMessage($chatId, $response, FALSE);
                  exit;
                break;
                case 'hola': case 'Hola': case 'HOLA': case '¡hola': case '¡HOLA': case '¡Hola!': case 'Hola!': case 'hola!':
                	$response = "Pa' ti mi cola.";
                	sendMessage($chatId, $response, FALSE);
                  exit;
                break;
                case 'Oki': case 'oki': case 'OKI':
                  $response = "Oki, oki.";
                  sendMessage($chatId, $response, FALSE);
                  exit;
                break;
            }
        }
    break;
}
?>
