<?php
    #SE RECIBE VALORES DE CLOSE CONTRACT FORM
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
    if(isset($_POST['deviceSessionId']))/**/ { $deviceSessionId = $_POST['deviceSessionId']; }

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
    
    if(isset($calleTDC) && isset($coloniaTDC)){ $direccionTDC=$calleTDC." ".$coloniaTDC; }
   

    $fallo = 0;

    #CONFIGURACIONES DB Y RUTAS
    require($root.'config/config.php');
    require($root.'config/dbConf.php');

    # INSTANCIAMOS API DE OPEN PAY#
    require($root.'resources/openpay/inicializa_api.php');

    function insertPrecontrato($insert)
    {
        global $db, $folioCot, $nombre, $calle, $numero, $colonia, $telefono, $email, $kitNum, $kitMensualidad, $contacto1, $telefono1, $contacto2, $telefono2, $metodoPago, $idAPI, $nombreKitDB, $id_plan, $metodoPagoTxt;

        $db=conexionPdo();

        if($insert==1)
        {
            #INSERT DE PRECONTRATO
            $consultaStr="INSERT INTO precontratos (id_precontrato, folio_cotizacion, nombre, calle, numero, colonia, telefono, email, numero_kit, mensualidad, contacto1, telefono1, contacto2, telefono2, metodo_pago, id_api) VALUES (
                '',
                '$folioCot',
                '$nombre',
                '$calle',
                '$numero',
                '$colonia',
                '$telefono',
                '$email',
                '$kitNum',
                '$kitMensualidad',
                '$contacto1',
                '$telefono1',
                '$contacto2',
                '$telefono2',
                '$metodoPago',
                '$idAPI')";

            $consulta=$db->prepare($consultaStr);
            $consulta->execute();
        }
        #EXTRAE NUM DE FOLIO E ID DE PRECONTRATO PARA MOSTRAR A USUARIO
        $consultaStr="SELECT * FROM precontratos WHERE folio_cotizacion=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$folioCot]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);

            $idPreContratoDB= $dataConsulta["id_precontrato"];
            $folioCotDB=      $dataConsulta["folio_cotizacion"];
            $nombreDB=        $dataConsulta["nombre"];
            $calleDB=         $dataConsulta["calle"];
            $numeroDB=        $dataConsulta["numero"];
            $coloniaDB=       $dataConsulta["colonia"];
            $telefonoDB=      $dataConsulta["telefono"];
            $emailDB=         $dataConsulta["email"];
            $numeroKitDB=     $dataConsulta["numero_kit"];
            $mensualidadDB=   $dataConsulta["mensualidad"];
            $contacto1DB=     $dataConsulta["contacto1"];
            $telefono1DB=     $dataConsulta["telefono1"];
            $contacto2DB=     $dataConsulta["contacto2"];
            $telefono2DB=     $dataConsulta["telefono2"];
            $metodoPagoDB=    $dataConsulta["metodo_pago"];
            $idAPI=           $dataConsulta["id_api"];

        if($metodoPagoDB==1)      { $metodoPagoTxt="Transferencia Electrónica"; }
        else if($metodoPagoDB==2) { $metodoPagoTxt="Depósito Bancario";         }
        else if($metodoPagoDB==3) { $metodoPagoTxt="Tarjeta de Crédito/Débito"; }

        #EXTRAE NOMBRE DEL PAQUETE DE ACUERDO AL NUM DE KIT
        $db2=conexion_pdo();
        $consultaStr="SELECT * FROM kits_combos WHERE id_kit=?";
        $consulta=$db2->prepare($consultaStr);
        $consulta->execute([$numeroKitDB]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        $nombreKitDB=$dataConsulta["nombre"];
        $id_plan=$dataConsulta["id_plan"];

        $dataUser = array(
            "idPreContratoDB"   => $idPreContratoDB,
            "folioCotizacionDB" => $folioCotDB,
            "nombreDB"          => $nombreDB,
            "calleDB"           => $calleDB,
            "numeroDB"          => $numeroDB,
            "coloniaDB"         => $coloniaDB,
            "telefonoDB"        => $telefonoDB,
            "emailDB"           => $emailDB,
            "numeroKitDB"       => $numeroKitDB,
            "mensualidadDB"     => $mensualidadDB,
            "contacto1DB"       => $contacto1DB,
            "telefono1DB"       => $telefono1DB,
            "contacto2DB"       => $contacto2DB,
            "telefono2DB"       => $telefono2DB,
            "metodoPagoDB"      => $metodoPagoDB,
            "idAPI"             => $idAPI,
            "nombreKitDB"       => $nombreKitDB,
            "id_plan"           => $id_plan
        );
            return $dataUser;
    }

    # CARGA FUNCIONES PARA CREAR Y BUSCAR CUSTOMER #
    include_once($root.'resources/openpay/functions.php');
    $db=conexionPdo();
    #Consulta para obtener ultimo registro capturado y evitar duplicidad a la recarga
    $consultaStr="SELECT * FROM precontratos ORDER BY id_precontrato DESC LIMIT 1";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute();
    if($consulta->rowCount() != 0)
    {
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        #Extrae el ultimo dato de numero de cotizacion registrado
        $folCotizacionValidation=$dataConsulta["folio_cotizacion"];
        #Extrae el ultimo dato de numero de cotizacion registrado
        $id_api_user=$dataConsulta["id_api"];
    }
    else
    {
        $folCotizacionValidation = "";
    }

    $id_api="";
    
    #Consulta para insertar nuevo usuario
    #Compara el ultimo registrado contra el que se desea ingresar
    if($folioCot!= $folCotizacionValidation)
    {
        #CARGA API PARA GENERAR SOLO SI ES PAGO CON TARJETA "id_customer"
        if($metodoPago==3)
        {
            #Revisa el listado de usuarios registrados en Open Pay "1"-> Existe, "0"-> No existe
            $id_api=searchUser2($email);

            #ID API del Customer encontrado
            if (isset($id_api[1]))
            {
                 $idAPI=$id_api[1]; 
                 $userRegister=1;
            }
            else
            {
                $userRegister=0;
            }

            #Si no se detecto el correo electronico se procede a generar nuevo customer en openpay
            if($userRegister==0)
            {
                #funcion que agrega nuevo cliente y genera su $id_api
                $id_api=addNewCustomer($nameTDC, $email, $telefono, $direccionTDC, $cpTDC, $estadoTDC, $municipioTDC);
                $addNewCustomer=$id_api[0]; //True o false

                if (isset($id_api[1])){ $idAPI=$id_api[1]; }//ID API del Customer creado
               
                if($addNewCustomer==true)
                {
                    #Funcion que inserta customer a tabla precontrato y extrae num_kit e id_plan
                    $dataUserPrecontract=insertPrecontrato(1);
                    #Funcion que agrega nueva tarjeta a customer -- $id_api=id del cliente
                    $addCard=addCardCustomer($cardNumber, $expiracion, $nameTDC, $securitycode, $calleTDC, $coloniaTDC, $cpTDC, $estadoTDC, $municipioTDC, $idAPI);
                    $tarjeta=$addCard[0];
                    if (isset($addCard[1])){ $id_tarjeta=$addCard[1]; }
                    #Valida si existe fallo evaluando los codigo de error -> $tarjeta retorno $codigoError
                    if($tarjeta==3001 || $tarjeta==3002 || $tarjeta==3003 || $tarjeta==3004 || $tarjeta==3005)
                    {
                        $fallo=1;
                        $codigoError=$tarjeta;
                    }
                }
                else
                { 
                    #Funcion que inserta customer a tabla precontrato y extrae num_kit e id_plan
                    $dataUserPrecontract=insertPrecontrato(1);
                }
            }
            #Si existe el correo electronico se procede verificar tarjetas registradas
            else if($userRegister==1)
            {
                $dataUserPrecontract=insertPrecontrato(1);
                #Revisa si el customer tiene tarjetas registradas y elimina las que tiene
                verifyDeleteCards($idAPI);
                #Funcion que agrega nueva tarjeta a customer -- $id_api=id del cliente
                $addCard=addCardCustomer($cardNumber, $expiracion, $nameTDC, $securitycode, $calleTDC, $coloniaTDC, $cpTDC, $estadoTDC, $municipioTDC, $idAPI);
                $tarjeta=$addCard[0];
                if (isset($addCard[1])){ $id_tarjeta=$addCard[1]; }
                #Valida si existe fallo evaluando los codigo de error -> $tarjeta retorno $codigoError
                if($tarjeta==3001 || $tarjeta==3002 || $tarjeta==3003 || $tarjeta==3004 || $tarjeta==3005)
                {
                    $fallo=1;
                    $codigoError=$tarjeta;
                }   
            }   
        }
        else
        {
            $dataUserPrecontract=insertPrecontrato(1);
        }
    }

    #Extrae los datos en caso de que se recargue la pagina, muestra en base al numero de cotizacion
    if($folioCot==$folCotizacionValidation)
    {
        $dataUserPrecontract=insertPrecontrato(0);
    }

?>
