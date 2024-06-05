<?php
	/////// Variables de configuración ///////
	include_once('../../config/config.php');
    include_once($root.'config/dbConf.php');
    $db = conexionPdo();
    /////// Variables de configuración ///////

    // VARIABLES NECESARIAS PARA EL DOCUMENTO //
    $id_contrato = "";
    $garantia = "";
    $fecha_actual = date('Y-m-d');
    $atencion = "";
    // VARIABLES NECESARIAS PARA EL DOCUMENTO //

    if(isset($_GET["contrato"]))
    {
        $id_contrato = $_GET["contrato"];
    }

    $queryString = "SELECT 
    id_contrato,
    id_cliente,
    numero_contrato,
    numero_cliente,
    nombre_comercial,
    direccion,
    modalidad,
    clientes.nombre,
    razon_social,
    equipo,
    fecha_inicio,
    fecha_termino,
    cerradores.nombre AS nombre_cerrador
    FROM contratos 
    JOIN clientes ON contratos.cliente = clientes.id_cliente 
    JOIN colaboradores AS cerradores ON clientes.cerrador = cerradores.id_colaborador
    WHERE id_contrato = ?";
    $options = array($id_contrato);
    $query = $db->prepare($queryString);
    $query -> execute($options);
    if($query->rowCount() != 0)
    {
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $numero_contrato = $data['numero_contrato'];
        $numero_cliente = $data['numero_cliente'];
        $nombre_comercial = $data['nombre_comercial'];
        $direccion = $data['direccion'];
        $modalidad = $data['modalidad'];
        $nombre = $data['nombre'];
        $razon_social = $data['razon_social'];
        $equipo = $data['equipo'];
        $fecha_inicio = $data['fecha_inicio'];
        $fecha_termino = $data['fecha_termino'];
        $nombre_cerrador = $data['nombre_cerrador'];

        $tipos_contrato = "";
        $queryStringTipos = "
        SELECT 
        id_tipo,
        nombre
        FROM asignaciones_tipo_contrato 
        JOIN tipos_contrato ON asignaciones_tipo_contrato.tipo_contrato = tipos_contrato.id_tipo 
        WHERE contrato = ?";
        $options = array($id_contrato);
        $queryTipos = $db->prepare($queryStringTipos);
        $queryTipos -> execute($options);
        if($queryTipos->rowCount() != 0)
        {
            while($dataTipos = $queryTipos->fetch(PDO::FETCH_ASSOC))
            {
                $nombre_tipo = $dataTipos['nombre'];

                if($tipos_contrato != "")
                {
                    $tipos_contrato .= ", $nombre_tipo";
                }
                else
                {
                    $tipos_contrato = $nombre_tipo;
                }
            }

        }

        if(strlen($equipo) < 300)
        {
            $equipo = nl2br($equipo);
        }
        
        //$tipo = $data['tipo']; // MODALIDAD
        //$fecha_contrato = $data['fecha_contrato']; // fecha inicio
        //$fin_contrato = $data['fin_contrato'];
        //$tabla = $data['tabla']; // MODALIDAD
        //$type = $modality;

        /*echo "
        $numero_contrato<br>
        $numero_cliente<br>
        $nombre_comercial<br>
        $direccion<br>
        $modalidad<br>
        $nombre<br>
        $razon_social<br>
        $equipo<br>
        $fecha_inicio<br>
        $fecha_termino<br>";*/
        
        require($root.'resources/PDFGenerator/genera_memoria.php');
    }
    else
    {
        $pageTitle = "Error";
        $titleMain = "";
        $messageError = "Acceso denegado<br>¿Buscabas algo?"; 

        include($root."templates/$theme/header.php");
        include($root."templates/$theme/title.php");

        include($root."templates/$theme/errorPage.php");  
        include($root."templates/$theme/footer.php");
    }
?>