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
    $mailSubject = "Comprobante de Pago (#{$numContrato})";
    $mailPath = $root.'templates/acilQuote/email/mailNewContract.php';
    $mailData = array(
        array("var_name" => "nombre", "var_val" => "{$nombre}")
    );

    $routeRecibo=$root."docs/digitalContracts/".$numContrato."/comprobante_pago_".$numContrato.".pdf";
    $attachments=array($routeRecibo);

    ##SE EJECUTA FUNCIÓN
    sendEmail($recipients, $mailSender, $mailSubject, $mailPath, $mailData, $mailHost, $mailUser, $mailPass, $attachments);

?>