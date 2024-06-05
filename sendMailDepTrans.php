<?php
    //CREA ARRAY PARA RECIPIENTS
    $recipients = array();   
    $nombreCliente = $nombre;
    $emailCliente =  $email;
    $dataUserMail = array("email" => "{$emailCliente}", "name" => "{$nombreCliente}");
    array_push($recipients, $dataUserMail);

    #ENVIO DE CORREO
    ##SE DEFINEN VARIABLES
    //$recipients = array(array("email" => "{$emailDestino}", "name" => "{$nombreDestino}"));
    $numContrato64 = base64_encode($numContrato);
    $mailSubject = "Datos Bancarios para Déposito/Transferencia";
    $mailPath = $root.'templates/acilQuote/email/mailDatosBancarios.php';
    $mailData = array(
        array("var_name" => "nombre", "var_val" => "{$nombre}"),
        array("var_name" => "numContrato64", "var_val" => "{$numContrato64}")
    );

    $routeDatosBancarios=$root."docs/digitalContracts/".$numContrato."/datos_bancarios_".$numContrato.".pdf";
    $attachments=array($routeDatosBancarios);

    ##SE EJECUTA FUNCIÓN
    sendEmail($recipients, $mailSender, $mailSubject, $mailPath, $mailData, $mailHost, $mailUser, $mailPass, $attachments);

?>