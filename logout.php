<?php
    session_start();
    session_destroy();
    // Variables para que funcione el header
    $pageTitle = "Cierre de sesión exitoso";
    $messageSuccess = "Cierre de sesión exitoso";
    // archivos que se deben importar
    include_once('config/config.php');
    require $root . "templates/$theme/header.php";// template header page
    require $root . "templates/$theme/successPage.php";// template error page
    require $root . "templates/$theme/footer.php";// template footer page
    header("refresh:3;url=login.php");
?>