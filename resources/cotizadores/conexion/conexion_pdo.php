<?php
    function conexion_pdo()
    {
        try 
        {
    		$db = @new PDO('mysql:host=localhost;dbname=acilsegu_arrendamiento', 'acilsegu_acil', 'AcilOnTime01',array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    		$db->query("SET NAMES utf8");
    	}
    	catch (PDOException $e) 
    	{
    		self::fatal(
    			"An error occurred while connecting to the database. ".
    			"The error reported by the server was: ".$e->getMessage()
    		);
    	}
    	return $db;
    }
?>