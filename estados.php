<?php

// SISTEMA DE ESTADOS DEL USUARIO PARA SABER QUE SE VA A HACER CON SU PRÓXIMO MENSAJE.

$usuario=mysqli_real_escape_string($conexion,$userId);
$consulta="SELECT * FROM `usuario` WHERE id='$usuario';";
$datos=mysqli_query($conexion,$consulta);

    if(mysqli_num_rows($datos)>0){
        $fila=mysqli_fetch_array($datos,MYSQLI_ASSOC);

        if($fila['estado']==1){

            // CÓDIGO PARA AÑADIR EL MENSAJE EN LA BASE DE DATOS.

            $consulta="UPDATE usuario SET mensaje='$message', estado='0' WHERE id='$userId';";
            mysqli_query($conexion, $consulta);

            $response = "$firstname mensaje actualizado en su cuenta. La próxima vez que utilice el comando te contestaré con el mismo.";
            deleteMessage($chatId, $messageId);
            sendMessage($userId, $messageId, $response, FALSE);

            mysqli_close($conexion);
        }else if($fila['estado']==2){

          // CÓDIGO PARA AÑADIR EL NUEVO EXAMEN SOLO CON SU NOMBRE, Y ALMACENAMOS EN EL ALMACÉN EL IDENTIFICADOR.

          $consulta="INSERT INTO examen (asignatura) VALUES ('$message');";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='3' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $consulta="SELECT * from examen order by id DESC LIMIT 1";
          $datos2 = mysqli_query($conexion, $consulta);
          $fila=mysqli_fetch_array($datos2,MYSQLI_ASSOC);

          $idUtilizada = $fila['id'];

          $escritura='<?php $idAUtilizar='.$idUtilizada.'; ?>';
          $file= fopen("almacen.php","w");
          fwrite($file, $escritura);
          fclose($file);

          $response ="$firstname ahora me tendrás que dar los temas que van a caer en el examen.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);
        }else if($fila['estado']==3){

          // CÓDIGO PARA AÑADIR LOS TEMAS DEL EXAMEN AÑADIDO ANTERIORMENTE.

          $consulta="UPDATE examen SET temas = '$message' WHERE id='$idAUtilizar';";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='4' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $response ="$firstname ahora me tendrás que dar la fecha en la que tendrá el lugar el examen.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);
        }else if($fila['estado']==4){

          // CÓDIGO PARA AÑADIR LA FECHA DEL EXAMEN AÑADIDO ANTERIORMENTE.

          $consulta="UPDATE examen SET fecha = '$message' WHERE id='$idAUtilizar';";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='0' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $response ="$firstname examen añadido con éxito en la base de datos.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);
        }else if($fila['estado']==5){

          // CÓDIGO PARA ELIMINAR UN EXAMEN QUE SE ENCUENTRA EN LA BASE DE DATOS.

          $consulta="DELETE FROM examen WHERE id='$message'";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='0' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $response = "$firstname examen eliminado con éxito de la base de datos.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);
        }else if($fila['estado']==6){

          // CÓDIGO PARA AÑADIR LA NUEVA ENTREGA SOLO CON SU NOMBRE, Y ALMACENAMOS EN EL ALMACEN EL IDENTIFICADOR

          $consulta="INSERT INTO entregas (asignatura) VALUES ('$message');";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='7' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $consulta="SELECT * from entregas order by id DESC LIMIT 1";
          $datos2 = mysqli_query($conexion, $consulta);
          $fila=mysqli_fetch_array($datos2,MYSQLI_ASSOC);

          $idUtilizada = $fila['id'];

          $escritura='<?php $idAUtilizar='.$idUtilizada.'; ?>';
          $file= fopen("almacen.php","w");
          fwrite($file, $escritura);
          fclose($file);

          $response ="$firstname ahora me tendrás que dar la descripción de la entrega.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);
        }else if($fila['estado']==7){

          // CÓDIGO PARA AÑADIR LA DESCRIPCIÓN DE LA ENTREGA AÑADIDA ANTERIORMENTE

          $consulta="UPDATE entregas SET descripcion = '$message' WHERE id='$idAUtilizar';";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='8' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $response ="$firstname ahora me tendrás que dar la fecha en la que finalizará el plazo de entrega.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);
        }else if($fila['estado']==8){

          // CÓDIGO PARA AÑADIR LA FECHA DE LA ENTREGA AÑADIDA ANTERIORMENTE

          $consulta="UPDATE entregas SET fecha = '$message' WHERE id='$idAUtilizar';";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='9' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $response ="$firstname ahora me tendrás que dar el enlace para acceder directamente a la entrega.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);
        }else if($fila['estado']==9){

          // CÓDIGO PARA AÑADIR EL ENLACE DE LA ENTREGA AÑADIDA ANTERIORMENTE

          $consulta="UPDATE entregas SET enlace = '$message' WHERE id='$idAUtilizar';";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='0' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $response ="$firstname entrega añadida con éxito en la base de datos.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);

        }else if($fila['estado']==10){

          // CÓDIGO PARA ELIMINAR UN EXAMEN QUE SE ENCUENTRA EN LA BASE DE DATOS.

          $consulta="DELETE FROM entregas WHERE id='$message'";
          mysqli_query($conexion, $consulta);
          $consulta="UPDATE usuario SET estado='0' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $response = "$firstname entrega eliminada con éxito de la base de datos.";
          sendDeleteMessage($chatId, $messageId, $response, FALSE);
          mysqli_close($conexion);

        }else if($fila['estado']==11){

          // CÓDIGO PARA ENVIAR UN MENSAJE A TRAVÉS DEL BOT AL GRUPO GENERAL.

          $consulta="UPDATE usuario SET estado='0' WHERE id='$userId';";
          mysqli_query($conexion, $consulta);

          $response = "$firstname mensaje enviado satisfactoriamente.";
          sendMessage($chatId, $response, FALSE);
          $response = "$message";
          sendMessage(-1001152952278, $response, FALSE);
          mysqli_close($conexion);

        }
    }

 ?>
