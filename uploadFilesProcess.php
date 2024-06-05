<?php
    include_once('config/config.php');
    include_once('config/dbConf.php');
    $db=conexionPdo();

//Recibimos numero de contrato
    if(isset($_POST['numContrato'])){ $numContrato=$_POST['numContrato']; }
    
//Recibimos COMPROBANTE DE DOMICILIO cargado desde formulario, se guarda en carpeta correspondiente y se le asigna nombre
    if(isset($_FILES['domicilio']) && !empty($_FILES['domicilio']['name'])) {
        $comprobanteDomicilio = $_FILES['domicilio'];

        $rutaDestino = $root."docs/digitalContracts/".$numContrato."/".$comprobanteDomicilio['name'];

            if(move_uploaded_file($comprobanteDomicilio['tmp_name'], $rutaDestino)) {
                $nombreArchivo = "comprobante_domicilio_".$numContrato.".pdf";
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

//Recibimos CONSTANCIA DE SITUACION FISCAL cargada desde formulario, se guarda en carpeta correspondiente y se le asigna nombre
    if(isset($_FILES['constanciaFiscal']) && !empty($_FILES['constanciaFiscal']['name'])) {
       
        $constanciaFiscal = $_FILES['constanciaFiscal'];

        $rutaDestino = $root."docs/digitalContracts/".$numContrato."/".$constanciaFiscal['name'];

        if(move_uploaded_file($constanciaFiscal['tmp_name'], $rutaDestino)) {
            $nombreArchivo = "constancia_situacion_fiscal_".$numContrato.".pdf";
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

//Recibimos datos fiscales para actualizacion
    if(isset($_POST['rfc']) && isset($_POST['direccion']) && isset($_POST['cp']) && isset($_POST['regimenFiscal']) && isset($_POST['usoCFDI']) && isset($_POST['cliente'])) {

        $rfc=$_POST['rfc'];
        $direccion=$_POST['direccion'];
        $cp=$_POST['cp'];
        $regimenFiscal=$_POST['regimenFiscal'];
        $usoCFDI=$_POST['usoCFDI'];
        $cliente=$_POST['cliente'];

        //Solo si se cambio el RFC se actualizan datos
        if($rfc!="XAXX010101000"){
            $consultaStr="UPDATE clientes SET rfc=?, direccion_fiscal=?, codigo_postal=?, regimen_fiscal=?, uso_cfdi=? WHERE id_cliente=?";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$rfc, $direccion, $cp, $regimenFiscal, $usoCFDI, $cliente]);
            $archivoCargado=1;
        }
    }


    if($archivoCargado==1)
    {
        $messageSuccess="Información actualizada correctamente";
        include $root."templates/acil/successPage.php";
        echo "<br>";
    }

    else if($archivoCargado==0)
    {
        $messageError="Error al actualizar información";
        include $root."templates/acil/errorPage.php";
        echo "<br>";
    }

?>