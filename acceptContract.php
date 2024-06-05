<?php

$pageTitle = "Hire Assistant";
	include_once('config/config.php');
	include_once('acceptContractProcess.php');
    require $root."templates/$theme/header.php";// template header page
	include $root."templates/$theme/acceptContractForm.php";   // Cuerpo de la página
	require $root."templates/$theme/footer.php";// template footer page

?>