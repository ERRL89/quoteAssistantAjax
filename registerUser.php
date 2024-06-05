<?php

$pageTitle = "Register User";
	include_once('config/config.php');
	include_once('config/dbConf.php');
	include_once('registerUserProcess.php');
    require $root."templates/$theme/header.php";// template header page

	if($fallo==0){
		include $root."templates/$theme/registerUserForm.php"; // Cuerpo de la página
	}
	else if($fallo==1){
		include $root."templates/$theme/registerUserFormError.php"; // Cuerpo de la página
	}
	
	require $root."templates/$theme/footer.php";// template footer page

?>