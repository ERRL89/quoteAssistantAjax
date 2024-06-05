<?php
    //Envia correo de bienvenidan al socio o socios
    //CREA ARRAY PARA RECIPIENTS
    $recipients = array();   
    $nombreUsuario = $nombre;
    $emailUsuario =  $email;
    $dataUserMail = array("email" => "{$emailUsuario}", "name" => "{$nombreUsuario}");
    array_push($recipients, $dataUserMail);

    #ENVIO DE CORREO
    ##SE DEFINEN VARIABLES
    //$recipients = array(array("email" => "{$emailDestino}", "name" => "{$nombreDestino}"));
    $mailSubject = "¡Firma tu contrato ahora!";
    $mailPath = $root.'templates/acilQuote/email/mailSignContract.php';
    $mailData = array(
        array("var_name" => "nombre", "var_val" => "{$nombre}"),
        array("var_name" => "idDoc", "var_val" => "{$idDoc}")
    );
    ##SE EJECUTA FUNCIÓN
    sendEmail($recipients, $mailSender, $mailSubject, $mailPath, $mailData, $mailHost, $mailUser, $mailPass);
?>
    