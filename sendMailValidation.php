<?php
    $consultaStr="SELECT email, nombre 
    FROM usuarios JOIN colaboradores ON usuarios.id_usuario = colaboradores.usuario
    WHERE puesto = 1 AND colaboradores.estatus = 1";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute();
   
    $recipients = array();
    while($dataUser = $consulta->fetch(PDO::FETCH_ASSOC))
    {
        $email_colaborador = $dataUser['email'];
        $nombre_colaborador = $dataUser['nombre'];
        $dataUserMail = array("email" => "{$email_colaborador}", "name" => "{$nombre_colaborador}");
        array_push($recipients, $dataUserMail);
    }

    #ENVIO DE CORREO
    ##SE DEFINEN VARIABLES
    //$recipients = array(array("email" => "{$emailDestino}", "name" => "{$nombreDestino}"));
    $mailSubject = "Contrato para Validación (#{$numContrato})";
    $mailPath = $root.'templates/acilQuote/email/mailSendValidation.php';
    $mailData = array(
        array("var_name" => "nombre", "var_val" => "{$nombre}"),
        array("var_name" => "numContrato", "var_val" => "{$numContrato}") 
    );

    ##SE EJECUTA FUNCIÓN
    sendEmail($recipients, $mailSender, $mailSubject, $mailPath, $mailData, $mailHost, $mailUser, $mailPass);

?>
