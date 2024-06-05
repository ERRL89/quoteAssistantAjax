<?php

$pageTitle = "Payment Confirmed";
	include_once('config/config.php');
	include_once('config/dbConf.php');
	include_once('functions.php');

	include $root."resources/PHPMailer/src/Exception.php";
	include $root."resources/PHPMailer/src/PHPMailer.php";
	include $root."resources/PHPMailer/src/SMTP.php";
	
	include_once('paymentConfirmedProcess.php');
    require $root."templates/$theme/header.php";// template header page
	include $root."templates/$theme/paymentConfirmedForm.php";   // Cuerpo de la página
	require $root."templates/$theme/footer.php";// template footer page

?>