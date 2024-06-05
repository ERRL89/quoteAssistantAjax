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
    telefono,
    correo,
    equipo,
    fecha_inicio,
    fecha_termino,
    cerradores.nombre AS nombre_cerrador,
    email
    FROM contratos 
    JOIN clientes ON contratos.cliente = clientes.id_cliente 
    JOIN colaboradores AS cerradores ON clientes.cerrador = cerradores.id_colaborador
    JOIN usuarios ON cerradores.usuario = usuarios.id_usuario
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
        $telefono = $data['telefono'];
        $email_cliente = $data['correo'];
        $equipo = $data['equipo'];
        $fecha_inicio = $data['fecha_inicio'];
        $fecha_termino = $data['fecha_termino'];
        $nombre_cerrador = $data['nombre_cerrador'];
        $email_cerrador = $data['email'];

        switch($modalidad)
        {
            case 1:
            {
                $tipo = 'LEASING';
                break;
            }
            case 2:
            {
                $tipo = 'VENTAS';
                break;
            }
        }

        require($root.'resources/PDFGenerator/genera_recibo.php');
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