<?php
	
	$folderBase = "quoteAssistant/";
    $theme = "acilQuote";
	$root = $_SERVER['DOCUMENT_ROOT'].'/'.$folderBase;
    $routeAcil="https://acil.mx/quoteAssistant/";
	
	// INFORMACIÓN PARA TEST //
    #BASE DE DATOS
    $host = "localhost";
    $dbname = "acilsegu_intranet";
    $userDB = "root";
    $passDB = "";
    #

    #DATOS PARA PHPMAIL
    $mailHost = "smtp.gmail.com";
    $mailUser = "acilpruebas@gmail.com";
    $mailPass = "gdogzbybgvgnwvsg";
    $mailSender = array("email" => "acilpruebas@gmail.com", "name" => "Notificaciones Intranet ACIL (Demo)");
    #
    // INFORMACIÓN PARA TEST //

    /*// INFORMACIÓN PARA PRODUCTIVO //
    #BASE DE DATOS
    $host = "localhost";
    $dbname = "acilsegu_arrendamiento";
    $user = "acilsegu_acil";
    $pass = "AcilOnTime01";
    #

    #DATOS PARA PHPMAIL
    $mailHost = "acil.mx";
    $mailUser = "info@acil.mx";
    $mailPass = "AcilSeguridad01@";
    $mailSender = array("email" => "info@acil.mx", "name" => "Acil Info");
    #
    // INFORMACIÓN PARA PRODUCTIVO //*/
	
?>