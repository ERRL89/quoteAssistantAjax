<?php
    session_start();
    if(isset($_SESSION['usuario']))
    {
        header("location: cotizador_kit.php");
        die();
    }
    else
    {
        header("location: ../login.php");
                die();
    }
    
    ?>