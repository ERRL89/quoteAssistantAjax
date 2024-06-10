<?php
    include_once('config/config.php');
    include_once('config/dbConf.php');
    $db=conexionPdo();

//Recibimos numero de contrato
    if(isset($_POST['numContrato'])){ $numContrato=$_POST['numContrato']; }
    
//Recibimos COMPROBANTE DE PAGO cargado desde formulario, se guarda en carpeta correspondiente y se le asigna nombre
    if(isset($_FILES['pago']) && !empty($_FILES['pago']['name'])) {    
        $comprobantePago = $_FILES['pago'];

        $rutaDestino = $root."docs/digitalContracts/".$numContrato."/".$comprobantePago['name'];

        if(move_uploaded_file($comprobantePago['tmp_name'], $rutaDestino)) {
            $nombreArchivo = "comprobante_pago_".$numContrato.".pdf";
            $rutaNuevoNombre = $root."docs/digitalContracts/".$numContrato."/".$nombreArchivo; 
            if (rename($rutaDestino, $rutaNuevoNombre)) {
                $archivoCargado=1;
            }else{
                $archivoCargado=0;
            }
        }else{
            $archivoCargado=0;
        } 
    }

    if($archivoCargado==1)
    {
        $messageSuccess="Información actualizada correctamente";
        include $root."templates/acilQuote/successPage.php";
        echo "<br>";
    }

    else if($archivoCargado==0)
    {
        $messageError="Error al actualizar información";
        include $root."templates/acilQuote/errorPage.php";
        echo "<br>";
    }

?>