<?php

$pageTitle = "Form Contract";
	include_once('config/config.php');
	include_once('closeContractProcess.php');
    require $root."templates/$theme/header.php";// template header page
	include $root."templates/$theme/closeContractForm.php";   // Cuerpo de la página
	require $root."templates/$theme/footer.php";// template footer page

?>