<?php
    //IMPORTACIÓN DE RECURSOS
	include_once('config/config.php');
	include_once('config/dbConf.php');
    include_once ("./areas/menu.php");
    $db = conexionPdo();
    
    session_start();
    if(!isset($_SESSION['partnerId'])) //SI NO DETECTA UNA SESIÓN
    {
        // RECIBIMOS LOS DATOS DE ACCESO
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        // DESINFECTAMOS LA ENTRADA PARA EVITAR INYECCIÓN SQL
        $user= filter_var($user, FILTER_SANITIZE_EMAIL);
        $pass= filter_var($pass, FILTER_SANITIZE_SPECIAL_CHARS);

        //VERIFICACIÓN DE USUARIO
        $query = $db->prepare("SELECT * FROM usuarios WHERE username = ? AND pass = BINARY ?");
        $query -> execute(array($user,$pass));
        
        if($query->rowCount() != 0) // SI ENCUENTRA UN RESULTADO
        {
			$data = $query->fetch(PDO::FETCH_ASSOC);

            //SE EXTRAEN ESTOS DATOS DE USUARIO
			$userId = $data['id_usuario'];
			$userEmail = $data['email'];

            //SE PREPARA LA SIGUIENTE CONSULTA PARA DATOS ADICIONALES
            $query_partner = $db->prepare(
                "SELECT colaboradores.*, puestos.nombre as nombre_puesto
                FROM colaboradores
                INNER JOIN puestos ON colaboradores.puesto = puestos.id_puesto 
                WHERE usuario = ?"
            );
        }
        else //SI NO ENCUENTRA UN RESULTADO
        {
            $pageTitle = "error";
            $messageError = "Datos no válidos";
            $rootError = 'login.php';//ruta ya definida con la carpeta area, solo sirve cuando menu es 1.

            require($root.'templates/'.$theme.'/header.php');
            require($root.'templates/'.$theme.'/errorPage.php');
            require($root.'templates/'.$theme.'/footer.php');
            header("refresh:3;url=./");
            die();

        }
    }
    else //SI DETECTA UNA SESIÓN
    {
        //SE EXTRAEN ESTOS DATOS DE USUARIO DE LA SESIÓN EXISTENTE
        $userId = $_SESSION['userId'];
        $userEmail = $_SESSION['userEmail'];

        //SE PREPARA LA SIGUIENTE CONSULTA PARA DATOS ADICIONALES
        $query_partner = $db->prepare(
            "SELECT colaboradores.*, puestos.nombre as nombre_puesto
            FROM colaboradores
            INNER JOIN puestos ON colaboradores.puesto = puestos.id_puesto 
            WHERE usuario = ?"
        );
    }

    //SE EJECUTA LA CONSULTA PREPARADA
    $query_partner->execute(array($userId));
    $dataPartner = $query_partner->fetch(PDO::FETCH_ASSOC);

    //ASIGNACIÓN DE VARIABLES
    $partnerId = $dataPartner['id_colaborador'];
    $partnerName = $dataPartner['nombre'];
    $partnerAreaId = $dataPartner['puesto'];
    $partnerAreaName = $dataPartner['nombre_puesto'];
    $partnerRoleName = $dataPartner['rango'];
    $partnerIdBranch = $dataPartner['sucursal'];
    $partnerMenu = loadMenu($partnerAreaId);
    $folderArea = loadSession($userId, $userEmail, $partnerMenu, $partnerId, $partnerName, $partnerAreaId, $partnerAreaName, $partnerRoleName,$partnerIdBranch);
    $dashboardPage = "/".$folderBase."areas/".$folderArea;
    $_SESSION['rootArea'] = $dashboardPage;

    //REDIRECCIÓN A PÁGINA CORRESPONDIENTE
    header("Location:".$dashboardPage);
    die();
    
    //FUNCION QUE CARGA VARIABLES DE SESIÓN
    function loadSession($userId, $userEmail, $partnerMenu, $partnerId, $partnerName, $partnerAreaId, $partnerAreaName, $partnerRoleName, $partnerIdBranch) 
    {
        $_SESSION['userId'] = $userId;
        $_SESSION['userEmail'] = $userEmail;
        $_SESSION['partnerMenu'] = $partnerMenu;
        $_SESSION['partnerId'] = $partnerId ;
        $_SESSION['partnerName'] = $partnerName;
        $_SESSION['partnerAreaId'] = $partnerAreaId;
        $_SESSION['partnerAreaName'] = $partnerAreaName;
        $_SESSION['partnerRoleName'] = $partnerRoleName;
        $_SESSION['partnerIdBranch'] = $partnerIdBranch;

        $folderArea = "";
        switch($partnerAreaId)
        {
            case 1:{ $folderArea = "management/"; break; } // ADMINISTRACIÓN //
            case 2:{ $folderArea = "people/"; break; }         // RECURSOS HUMANOS //
            case 3:{ $folderArea = "logistics/"; break; }  // LOGÍSTICA //
            case 4:{ $folderArea = "support/"; break; }  // SOPORTE //
            case 5:{ $folderArea = "salesManager/"; break; }  // LIDER COMERCIAL //
            case 6:{ $folderArea = "sales/"; break; }  // CERRADORES (VENTAS) //
            case 7:{ $folderArea = "hubleader/"; break; }  // DIRECTOR DE SUCURSAL //
            case 8:{ $folderArea = "ceo/"; break; }  // DIRECCIÓN //
            case 9:{ $folderArea = "billing/"; break; }    // TESORERÍA // 
            case 10:{ $folderArea = "kam/"; break; }    // PROJECT MANAGER // 
            case 11:{ $folderArea = "operationManagement/"; break; }    // DIRECTOR DE OPERACIONES // 
            case 12:{ $folderArea = "warehouse/"; break; }    // ALMACEN // 
            case 13:{ $folderArea = "networker/"; break; }    // PERFILADORES // 
            case 14:{ $folderArea = "qa/"; break; }    // CONTROL DE CALIDAD // 
            case 15:{ $folderArea = "design/"; break; }    // DISEÑO GRAFICO // 
            case 16:{ $folderArea = "acquisitions/"; break; }    // COMPRAS // 
            case 17:{ $folderArea = "marketing/"; break; }    // MARKETING //
            case 18:{ $folderArea = "assistant/"; break; }    // ASISTENTE DE CEO //
            case 19:{ $folderArea = "surveillance/"; break; }    // MONITOREO //
            default:{ break; }
        }

        $_SESSION['folderArea'] = $folderArea;
        return $folderArea;
    }
?>