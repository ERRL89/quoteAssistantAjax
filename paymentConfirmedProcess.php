<?php
    ///////// INSTANCIAMOS LA API OPENPAY////////
    require($root.'resources/openpay/inicializa_api.php');
    
    ///////// Carga funciones para crear, buscar customer ////////
    include_once($root.'resources/openpay/functions.php');
    
    $db=conexionPdo();
    $db2=conexion_pdo();

    $valuesCard=0;
    if (isset($_GET["idApi"]) && isset($_GET["idPlan"]) && isset($_GET["tarjeta"]) && isset($_GET["telefono"]) && isset($_GET["deviceSessionId"])){
        $id_api = $_GET['idApi'];
        $id_plan = $_GET['idPlan'];
        $tarjeta = $_GET['tarjeta'];
        $telefono = $_GET['telefono'];
        $deviceSessionId = $_GET['deviceSessionId'];
        
        //Se asigna variable cuando se reciben todos los datos de tarjeta
        $valuesCard=1;
        $consultaStr="SELECT * FROM kits_combos WHERE id_plan=?";
        $consulta=$db2->prepare($consultaStr);
        $consulta->execute([$id_plan]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        $kit=$dataConsulta["nombre"];
        $costo=$dataConsulta["costo"];
    }

    //RECIBE VARIABLES PARA CREACIÓN DE USUARIO, CLIENTE Y CONTRATO
        $metodoPago = $_GET['metodoPago'];
        $folioCotizacion = $_GET['numeroCotizacion'];
        $nombre = $_GET['nombre']; 
        $calle = $_GET['calle'];
        $numero = $_GET['numero'];
        $colonia = $_GET['colonia'];

        $codigoPostal = $_GET['codigoPostal'];
        $municipio = $_GET['municipio'];
        $estado = $_GET['estado'];

        $direccion=$calle." ".$numero." ".$colonia." ".$codigoPostal." ".$municipio." ".$estado;
        $telefono = $_GET['telefono']; 
        $email = $_GET['email'];
        $kitNum= $_GET["kitNum"];
        $kitMensualidad= $_GET["kitMensualidad"];
        $acuerdoPago= $_GET["acuerdoPago"];
        $modalidad= $_GET["modalidad"];
        $frecuenciaPago= $_GET["frecuenciaPago"];
        $fechaInicio= $_GET["fechaInicio"];
        $metodoPago= $_GET["metodoPago"];
        $persona= $_GET["persona"];
        $representanteLegal= $_GET["representanteLegal"];
        $escritura= $_GET["escritura"];
        $idUsuario= $_GET["idUsuario"];
        $contacto1= $_GET["contacto1"];
        $telefono1= $_GET["telefono1"];
        $contacto2= $_GET["contacto2"];
        $telefono2= $_GET["telefono2"];

    /*  IMPRIME VARIABLES PARA CREACIÓN DE USUARIO, CLIENTE Y CONTRATO
            echo "Numero de Cotizacion: ". $folioCotizacion."<br>";
            echo "Nombre: ".$nombre."<br>";
            echo "Representante Legal: ".$representanteLegal."<br>";
            echo "Escritura: ".$escritura."<br>";
            echo "Calle: ".$calle."<br>";
            echo "Numero: ".$numero."<br>";
            echo "Colonia: ".$colonia."<br>";
            echo "Telefono: ".$telefono."<br>";
            echo "Email: ".$email."<br>";
            echo "Tipo de Kit: ".$kitNum."<br>";
            echo "Precio Mensual: ".$kitMensualidad."<br>";
            echo "Acuerdo Pago: ".$acuerdoPago."<br>";
            echo "Modalidad: ".$modalidad."<br>";
            echo "Frecuencia de Pago: ".$frecuenciaPago."<br>";
            echo "Fecha de Inicio de Contrato: ".$fechaInicio."<br>";
            echo "Metodo de Pago: ".$metodoPago."<br>";
            echo "Tipo de Persona: ".$persona."<br>";
            echo "ID de Usuario: ".$idUsuario."<br>";
            echo "Contacto1: ".$contacto1."<br>";
            echo "Telefono1: ".$telefono1."<br>";
            echo "Contacto2: ".$contacto2."<br>";
            echo "Telefono2: ".$telefono2."<br>";
        */

    
    //Agrega suscripción en OpenPay
    $cardNumber="";
    if($metodoPago==3 && $valuesCard==1){
        $fallo = 0;
        //Funcion que realiza cargo unico por deposito de inicio de contrato
        $charge=addCharge($tarjeta, $id_api, $kit, $costo, $deviceSessionId);
        if (isset($charge[0])){  $idCharge=$charge[0]; }
        if (isset($charge[1])){  $descriptionCharge=$charge[1]; }
        //Se se realizo el cargo se procede a agregar suscripcion
        if($charge!=""){
            //Funcion que agrega nueva suscripcion
            $suscription=addSuscription($id_plan, $tarjeta, $id_api); 
            $cardNumber=$suscription[0];
            //Datos para generación de recibo de pago
            if (isset($suscription[1])){  $nameUser=$suscription[1]; }
            if (isset($suscription[2])){  $typeCard=$suscription[2]; }
            if (isset($suscription[3])){  $typeBrand=$suscription[3]; }
            if (isset($suscription[4])){  $idSuscripcion=$suscription[4]; }
        }else{
            $cardNumber="";
        }
    }

    //Consulta para verificar si existe algun usuario con el mismo email
    $consultaStr="SELECT * FROM usuarios WHERE username=?";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute([$email]);
    $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
    $resultado = $consulta->rowCount();

    if ($resultado > 0) {//SI EXISTE USUARIO

        //Extraemos ID de USUARIO
        $idUsuario=$dataConsulta["id_usuario"];

        //Extraemos ID de CLIENTE
        $consultaStr="SELECT id_cliente, numero_cliente FROM clientes WHERE usuario=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idUsuario]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);

        $idCliente=$dataConsulta["id_cliente"];
        $numCliente=$dataConsulta["numero_cliente"];

        //Extrae folio de ContratoP, incrementa y lo almacena en variable
        $consultaStr="SELECT numero FROM folios WHERE clave='ContratoP'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
 
        $numContrato=$dataConsulta["numero"];
        $numContrato+=1;

        //------------ACTUALIZA FOLIO CONTRATO--------------------------------------
        $consultaStr="UPDATE folios SET numero=? WHERE clave='ContratoP'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$numContrato]);

        //------- Actualizar DATOS en Tabla Precontratos ---------
        $consultaStr="UPDATE precontratos SET cliente= $idCliente, num_contrato=$numContrato, estatus=1, facturacion=0 WHERE folio_cotizacion='$folioCotizacion'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
    } 
    
    else {//NO EXISTE USUARIO
        //Crea ususario
        $consultaStr="INSERT INTO usuarios VALUES ('','$email','1234','$email',0)";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();

        //Extrae ID de Usuario
        $consultaStr="SELECT id_usuario FROM usuarios WHERE email=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$email]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);

        $idUsuario=$dataConsulta["id_usuario"];

        //Extrae folio de Cliente, incrementa y lo almacena en variable
        $consultaStr="SELECT numero FROM folios WHERE clave='Cliente'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);

        $numCliente=$dataConsulta["numero"];
        $numCliente+=1;

        //----------Actualiza Folio de Cliente-----------------------------------
        $consultaStr="UPDATE folios SET numero=? WHERE clave='Cliente'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$numCliente]);

        //-------CREACIÓN DE CLIENTE-------------
        $consultaStr=" INSERT INTO clientes (
            numero_cliente, 
            usuario, 
            nombre, 
            correo, 
            telefono, 
            saldo, 
            rfc, 
            razon_social, 
            direccion_fiscal, 
            codigo_postal, 
            correo_fiscal, 
            regimen_fiscal, 
            uso_cfdi, 
            forma_pago, 
            perfilador, 
            cerrador, 
            habilitado, 
            estatus) VALUES (
                '$numCliente',
                '$idUsuario',
                '$nombre',
                '$email',
                '$telefono',
                 0,
                'XAXX010101000',
                '$nombre',
                '$direccion',
                '06470',
                '$email',
                '616',
                'S01',
                '99',
                '9979',
                '9979',
                '1',
                '1')";

        $consulta=$db->prepare($consultaStr);
        $consulta->execute();

        //------- Obtener ID de Cliente ---------
        $consultaStr="SELECT id_cliente FROM clientes WHERE nombre='$nombre' AND `telefono`='$telefono'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);

        $idCliente=$dataConsulta["id_cliente"];

        //Extrae folios de ContratoP, incrementa y lo almacena en variable
        $consultaStr="SELECT numero FROM folios WHERE clave='ContratoP'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
 
        $numContrato=$dataConsulta["numero"];
        $numContrato+=1;

        //------------ACTUALIZA FOLIO CONTRATO--------------------------------------
        $consultaStr="UPDATE folios SET numero=? WHERE clave='ContratoP'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$numContrato]);

        //------- Actualizar DATOS en Tabla Precontratos ---------
        $consultaStr="UPDATE precontratos SET cliente= $idCliente, num_contrato=$numContrato, estatus=1, facturacion=0 WHERE folio_cotizacion='$folioCotizacion'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
    }

    $db2=conexion_pdo();
    //Consulta para verificar el texto del tipo de kit
    $consultaStr="SELECT nombre, costo FROM kits_combos WHERE id_kit=?";
    $consulta=$db2->prepare($consultaStr);
    $consulta->execute([$kitNum]);
    $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
    $kitTxt=$dataConsulta["nombre"];
    $kitCosto=$dataConsulta["costo"];

    $queryUserData = $db->prepare(
        "SELECT id_precontrato, usuarios.email, colaboradores.nombre, colaboradores.sucursal
        FROM precontratos
        JOIN clientes ON clientes.id_cliente = precontratos.cliente
        JOIN colaboradores ON clientes.cerrador = colaboradores.id_colaborador
        JOIN usuarios ON colaboradores.usuario = usuarios.id_usuario
        WHERE folio_cotizacion = ?"
    );

    $queryUserData->execute([$folioCotizacion]);

    $dataUser = $queryUserData->fetch(PDO::FETCH_ASSOC);
    $id_precontrato = $dataUser['id_precontrato'];
    $nombre_cerrador = $dataUser['nombre'];
    $correo_cerrador = $dataUser['email'];
    $sucursal = $dataUser['sucursal'];
    $email_cliente = $email;
    
     ////////////////// GENERAMOS CONTRATO /////////////////////
     require($root.'resources/PDFGenerator/SendToTrato.php');

     #GUARDA INFORMACION INICIAL EN DOCS VERIDAS
     $consultaStr="INSERT INTO docs_veridas (clave, tipo, estatus) VALUES (?,?,?)";
     $consulta=$db->prepare($consultaStr);
     $consulta->execute([$numContrato,3,0]);

     #EXTRAEMOS ID_DOC PARA CONSTRUIR BOTON DE FIRMA TU CONTRATO EN EMAIL
     $consultaStr="SELECT id_doc FROM docs_veridas WHERE clave=?";
     $consulta=$db->prepare($consultaStr);
     $consulta->execute([$numContrato]);
     $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
     $idDoc=$dataConsulta["id_doc"];

     #ENVIO DE EMAIL A SOCIO PARA FIRMA DE CONTRATO
     require($root.'sendMailSignContract.php');

     #ENVIO DE EMAIL PARA FIRMA DE CONTRATO

     ////////////////// GENERAMOS RECIBO /////////////////////
     //Se envia recibo de pago y se envia correo con mensaje de agradecimiento de acuerdo a metodo de pago con TDC
     if($metodoPago==3 && $cardNumber!=""){
        require($root.'resources/cotizadores/cotizadoc/genera_recibo.php');
        //ENVIAR COMPROBANTE POR CORREO ELECTRONICO
        require($root.'sendMailTDC.php');
     }else{
        require($root.'resources/cotizadores/cotizadoc/genera_datos_bancarios.php');
        //ENVIAR COMPROBANTE POR CORREO ELECTRONICO
        require($root.'sendMailDepTrans.php');
     }
     
?>