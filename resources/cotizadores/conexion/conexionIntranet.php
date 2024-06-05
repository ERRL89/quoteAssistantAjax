<?php
    //// Inicio conexion y verifica si funciona la conexion 
    
    $conIntranet = mysqli_connect('localhost', 'acilsegu_acil', 'AcilOnTime01','acilsegu_intranet');
    $conIntranet->query("SET NAMES utf8"); 
    
    // Revisando conexión
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL -- Error:" . mysqli_connect_error();
      exit();
    }
    //// Fin de conexion 
    

?>