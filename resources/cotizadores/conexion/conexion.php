<?php
    //// Inicio conexion y verifica si funciona la conexion 
    
    $con = mysqli_connect('localhost', 'root', '','acilsegu_arrendamiento');
    
    // CONEXION HOSPEDANDO
    //$con = mysqli_connect('localhost', 'acilsegu_acil', 'AcilOnTime01','acilsegu_arrendamiento');
    // CONEXION HOSPEDANDO
    $con->query("SET NAMES utf8"); 
    
    // Revisando conexión
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL -- Error:" . mysqli_connect_error();
      exit();
    }
    //// Fin de conexion 
    

?>