<?php
    #SE RECIBE VALORES DE REGISTER USER FORM
        if(isset($_POST['root']))/*------------*/{ $root            = $_POST['root'];            }
        if(isset($_POST['folioCot']))/*--------*/{ $folioCot        = $_POST['folioCot'];        } 
        if(isset($_POST['nombre']))/*----------*/{ $nombre          = $_POST['nombre'];          } 
        if(isset($_POST['calle']))/*-----------*/{ $calle           = $_POST['calle'];           }
        if(isset($_POST['numero']))/*----------*/{ $numero          = $_POST['numero'];          }
        if(isset($_POST['colonia']))/*---------*/{ $colonia         = $_POST['colonia'];         } 
        if(isset($_POST['codigoPostal']))/*----*/{ $codigoPostal    = $_POST['codigoPostal'];    } 
        if(isset($_POST['estado']))/*----------*/{ $estado          = $_POST['estado'];          } 
        if(isset($_POST['municipio']))/*-------*/{ $municipio       = $_POST['municipio'];       } 
        if(isset($_POST['telefono']))/*--------*/{ $telefono        = $_POST['telefono'];        } 
        if(isset($_POST['email']))/*-----------*/{ $email           = $_POST['email'];           } 
        if(isset($_POST['rfc']))/*-------------*/{ $rfc             = $_POST['rfc'];             } 
        if(isset($_POST['direccionF']))/*------*/{ $direccionF      = $_POST['direccionF'];      } 
        if(isset($_POST['cpFiscal']))/*--------*/{ $cpFiscal        = $_POST['cpFiscal'];        } 
        if(isset($_POST['regimen']))/*---------*/{ $regimen         = $_POST['regimen'];         } 
        if(isset($_POST['cfdi']))/*------------*/{ $cfdi            = $_POST['cfdi'];            } 
        if(isset($_POST['kitNum']))/*----------*/{ $kitNum          = $_POST['kitNum'];          } 
        if(isset($_POST['kitMensualidad']))/*--*/{ $kitMensualidad  = $_POST['kitMensualidad'];  } 
        if(isset($_POST['acuerdoPago']))/*-----*/{ $acuerdoPago     = $_POST['acuerdoPago'];     } 
        if(isset($_POST['modalidad']))/*-------*/{ $modalidad       = $_POST['modalidad'];       } 
        if(isset($_POST['frecuenciaPago']))/*--*/{ $frecuenciaPago  = $_POST['frecuenciaPago'];  } 
        if(isset($_POST['fechaInicio']))/*-----*/{ $fechaInicio     = $_POST['fechaInicio'];     } 
        if(isset($_POST['metodoPago']))/*------*/{ $metodoPago      = $_POST['metodoPago'];      } 
        if(isset($_POST['contacto1']))/*-------*/{ $contacto1       = $_POST['contacto1'];       } 
        if(isset($_POST['telefono1']))/*-------*/{ $telefono1       = $_POST['telefono1'];       }
        if(isset($_POST['contacto2']))/*-------*/{ $contacto2       = $_POST['contacto2'];       }
        if(isset($_POST['telefono2']))/*-------*/{ $telefono2       = $_POST['telefono2'];       }
        if(isset($_POST['idAPI']))/*-----------*/{ $idAPI           = $_POST['idAPI'];           }
        if(isset($_POST['idPlan']))/*----------*/{ $idPlan          = $_POST['idPlan'];          }
        if(isset($_POST['tarjeta']))/*---------*/{ $idTarjeta       = $_POST['tarjeta'];         }
        if(isset($_POST['deviceSessionId']))/*-*/{ $deviceSessionId = $_POST['deviceSessionId']; }

    #DATOS DE TARJETA BANCARIA
        if(isset($_POST['nameTDC']))/*----------*/{ $nameTDC      = $_POST['nameTDC'];        }
        if(isset($_POST['cardNumber']))/*-------*/{ $cardNumber   = $_POST['cardNumber'];     }
        if(isset($_POST['expirationdate']))/*---*/{ $expiracion   = $_POST['expirationdate']; }
        if(isset($_POST['securitycode']))/*-----*/{ $securitycode = $_POST['securitycode'];   }
        if(isset($_POST['calleTDC']))/*---------*/{ $calleTDC     = $_POST['calleTDC'];       }
        if(isset($_POST['coloniaTDC']))/*-------*/{ $coloniaTDC   = $_POST['coloniaTDC'];     }
        if(isset($_POST['estadoTDC']))/*--------*/{ $estadoTDC    = $_POST['estadoTDC'];      }
        if(isset($_POST['municipioTDC']))/*-----*/{ $municipioTDC = $_POST['municipioTDC'];   }
        if(isset($_POST['cpTDC']))/*------------*/{ $cpTDC        = $_POST['cpTDC'];          }

    $direccion=$calle." ".$numero." ".$colonia." ".$codigoPostal." ".$estado." ".$municipio;

    #INSTANCIAMOS LA API OPENPAY#
    require($root.'resources/openpay/inicializa_api.php');
    # FUNCION PARA CREAR Y BUSCAR CUSTOMERS EN OPEN PAY #
    include_once($root.'resources/openpay/functions.php');
    # CARGA DE CONFIGURACION
    include $root."resources/PHPMailer/src/Exception.php";
	include $root."resources/PHPMailer/src/PHPMailer.php";
	include $root."resources/PHPMailer/src/SMTP.php";
    include_once($root.'config/config.php');
    include_once($root.'config/dbConf.php');
    require_once($root.'functions.php');
    
    $db=conexionPdo();
    $db2=conexion_pdo();

    $valuesCard=0;
    if(isset($_POST["idAPI"])   && 
       isset($_POST["idPlan"])  && 
       isset($_POST["tarjeta"]) && 
       isset($_POST["deviceSessionId"]))
    {
       #Se asigna variable cuando se reciben todos los datos de tarjeta
       $valuesCard=1;
       $consultaStr="SELECT * FROM kits_combos WHERE id_plan=?";
       $consulta=$db2->prepare($consultaStr);
       $consulta->execute([$idPlan]);
       $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
       $kit=$dataConsulta["nombre"];
       $costo=$dataConsulta["costo"];
    }

    #AGREGA CARGO Y SUSCRIPCION
    $cardNumber="";
    if($metodoPago==3 && $valuesCard==1)
    {
        $fallo = 0;
        //Funcion que realiza cargo unico por deposito de inicio de contrato
        $charge=addCharge($idTarjeta, $idAPI, $kit, $costo, $deviceSessionId);
        if (isset($charge[0])){  $idCharge=$charge[0];          }
        if (isset($charge[1])){  $descriptionCharge=$charge[1]; }
        //Se se realizo el cargo se procede a agregar suscripcion
        if($charge!=""){
            //Funcion que agrega nueva suscripcion
            $suscription=addSuscription($idPlan, $idTarjeta, $idAPI); 
            $cardNumber=$suscription[0];
            //Datos para generación de recibo de pago
            if (isset($suscription[1])){  $nameUser=$suscription[1];      }
            if (isset($suscription[2])){  $typeCard=$suscription[2];      }
            if (isset($suscription[3])){  $typeBrand=$suscription[3];     }
            if (isset($suscription[4])){  $idSuscripcion=$suscription[4]; }
        }else{
            $cardNumber="";
        }
    }

    #Consulta para verificar si existe algun usuario con el mismo email
    $consultaStr="SELECT * FROM usuarios WHERE username=?";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute([$email]);
    $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
    $resultado = $consulta->rowCount();

    #SI EXISTE USUARIO
    if ($resultado > 0) 
    {
        #Extraemos ID de USUARIO
        $idUsuario=$dataConsulta["id_usuario"];

        #Extraemos ID de CLIENTE
        $consultaStr="SELECT id_cliente, numero_cliente FROM clientes WHERE usuario=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$idUsuario]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        $idCliente=$dataConsulta["id_cliente"];
        $numCliente=$dataConsulta["numero_cliente"];

        #EXTRAE FOLIO DE CONTRATO INCREMENTA Y ALMACENA
        $consultaStr="SELECT numero FROM folios WHERE clave='ContratoP'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        $numContrato=$dataConsulta["numero"];
        $numContrato+=1;

        #ACTUALIZA FOLIO CONTRATO
        $consultaStr="UPDATE folios SET numero=? WHERE clave='ContratoP'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$numContrato]);

        #------- Actualizar DATOS en Tabla Precontratos ---------
        $consultaStr="UPDATE precontratos SET cliente= $idCliente, num_contrato=$numContrato, estatus=1, facturacion=0 WHERE folio_cotizacion='$folioCot'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
    } 
    else 
    {
        #CREA USUARIO
        $consultaStr="INSERT INTO usuarios VALUES ('','$email','1234','$email',0)";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();

        #EXTRAE ID DE USUARIO
        $consultaStr="SELECT id_usuario FROM usuarios WHERE email=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$email]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);

        $idUsuario=$dataConsulta["id_usuario"];

        #Extrae folio de Cliente, incrementa y lo almacena en variable
        $consultaStr="SELECT numero FROM folios WHERE clave='Cliente'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);

        $numCliente=$dataConsulta["numero"];
        $numCliente+=1;

        #---------- ACTUALIZA FOLIO DE CLIENTE -------------------------
        $consultaStr="UPDATE folios SET numero=? WHERE clave='Cliente'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$numCliente]);

        #-------CREACIÓN DE CLIENTE-------------
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
                '$rfc',
                '$nombre',
                '$direccionF',
                '$cpFiscal',
                '$email',
                '$regimen',
                '$cfdi',
                '99',
                '9979',
                '9979',
                '1',
                '1')";

        $consulta=$db->prepare($consultaStr);
        $consulta->execute();

        //------- OBTIENE ID DE CLIENTE ---------
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

        //------- ACTUALIZA DATOS EN TABLA PRECONTRATOS ---------
        $consultaStr="UPDATE precontratos SET cliente= $idCliente, num_contrato=$numContrato, estatus=1, facturacion=0 WHERE folio_cotizacion='$folioCot'";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute();
    }

    $db2=conexion_pdo();
    #Consulta para verificar el texto del tipo de kit
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

    $queryUserData->execute([$folioCot]);

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

     ////////////////// GENERAMOS RECIBO /////////////////////
     if($metodoPago==3 && $cardNumber!="")
     {
        require($root.'resources/cotizadores/cotizadoc/genera_recibo.php');
        #ENVIAR COMPROBANTE POR CORREO ELECTRONICO
        require($root.'sendMailTDC.php');
        require($root.'templates/acilQuote/paymentConfirmedForm.php');
     }
     else
     {
        require($root.'resources/cotizadores/cotizadoc/genera_datos_bancarios.php');
        #ENVIAR DATIOS BANCARIOS POR CORREO ELECTRONICO
        require($root.'sendMailDepTrans.php');
        require($root.'templates/acilQuote/paymentConfirmedForm.php');
     }
     
?>