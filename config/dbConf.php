<?php
    function conexionPdo()
    {   
        $host = $GLOBALS['host'];
        $dbname = $GLOBALS['dbname'];
        $userDB = $GLOBALS['userDB'];
        $passDB = $GLOBALS['passDB'];

        try 
        {
            $db = @new PDO("mysql:host=$host;dbname=$dbname", "$userDB", "$passDB",array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
            $db->query("SET NAMES utf8");
        } 
        catch (PDOException $e)
        {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    	return $db;
    }

    function conexion_pdo()
    {   
        $host = "localhost";
        $dbname = "acilsegu_arrendamiento";
        $userDB = "root";
        $passDB = "";

        try 
        {
            $db = @new PDO("mysql:host=$host;dbname=$dbname", "$userDB", "$passDB",array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
            $db->query("SET NAMES utf8");
        } 
        catch (PDOException $e)
        {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    	return $db;
    }
?>