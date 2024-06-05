<?php
$imageLogo = "logoacilblanco.png";
$pageTitle = "Login";
	include_once('config/config.php');
    require $root . "templates/$theme/header.php";// template header page
	include $root."templates/$theme/onLoad.php";
	include $root."templates/$theme/login.php";
	require $root . "templates/$theme/footer.php";// template footer page
?>