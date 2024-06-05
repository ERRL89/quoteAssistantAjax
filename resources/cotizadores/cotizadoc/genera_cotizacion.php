<?php
    /////////////////// AJUSTES INICIALES ///////////////////
    header("Cache-Control: no-cache, must-revalidate");
    setlocale(LC_TIME,"spanish");
    /////////////////// AJUSTES INICIALES ///////////////////
    
    /////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////
    use setasign\Fpdi;
    require_once('tcpdf/tcpdf.php');
    require_once('fpdi/autoload.php');
    /////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////
    
    /////////////////// VARIABLES INICIALES ///////////////////
    session_start();
    /*if(!isset($_SESSION['usuario']))
    {
        header("location: /intranet/");
        die();
    }*/
    include '../conexion/conexion.php';
    $usuario=$_SESSION['usuario'];
    $cargo=$_SESSION['cargo'];
    $nb=$_SESSION['nombre'];
    $nivel=$_SESSION['nivel'];
    $fecha_actual = date('Y-m-d');
    $dia = date('d');
    $mes = date('m');
    $anio = date('y');
    $hora = date('G');
    $minuto = date('i');
    $segundo = date('s');
    $folio_cotizacion = $usuario.$anio.$mes.$dia.$hora.$minuto.$segundo;
    /////////////////// VARIABLES INICIALES ///////////////////

    ///////////////// FUNCIÓN PARA CONVERTIR FECHA EN TEXTO /////////////////
    function fechaCastellano ($fecha) 
    {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        return $numeroDia." de ".$nombreMes." de ".$anio;
    }
    ///////////////// FUNCIÓN PARA CONVERTIR FECHA EN TEXTO /////////////////
    
    /////////////////// OPERACIONES PARA OBTENER EL CONTENIDO DEL PDF ///////////////////
    
    $complementos = false;
    $subtotal_complemento = 0;
    if($usuario == "" || $usuario == "")
    {
        $superior=$_SESSION['superior'];
        $consulta_usuario = mysqli_query($con, "SELECT * FROM usuarios JOIN vendedores ON usuarios.id_cliente = vendedores.id_cliente WHERE usuarios.id_cliente = '$superior'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
        $datos_usuario = mysqli_fetch_assoc($consulta_usuario);
        $nombre_usuario = $datos_usuario["nombre"];;
        $correo_usuario = $datos_usuario["user"];
    }
    else
    {
        $consulta_usuario = mysqli_query($con, "SELECT * FROM usuarios WHERE id_cliente = '$usuario'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
        $datos_usuario = mysqli_fetch_assoc($consulta_usuario);
        $nombre_usuario = $nb;
        $correo_usuario = $datos_usuario["user"];
    }
    
    // EXTRACCIÓN DEL FORMULARIO
    $producto=$_POST['producto'];
    $direccion=$_POST['direccion'];
    $nombre_cliente=$_POST['nombre'];
    $esquema=$_POST['esquema'];
    // EXTRACCIÓN DEL FORMULARIO
    
    switch($esquema)
    {
        case 1: // LEASING
            $condicion_pago = "MENSUAL";
            $condicion_amarillo = "LEASING";
            break;
        case 2: // VENTA
            $condicion_pago = "VENTA";
            $condicion_amarillo = "VENTA";
            break;
        default: // SIN DEFINIR
            $condicion_pago = "SIN DEFINIR";
            $condicion_amarillo = "N/A";
            break;
    }
    
    switch($producto)
    {
        case 1: // LEASING
        {
            $cotizacion_producto = "KIT BÁSICO";
            $cantidad_producto=1;
            $clave_kit = $_POST['kit'];
            $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_kit'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
            $lista_productos = mysqli_fetch_assoc($consulta_productos);
            $nombre_producto = $lista_productos["nombre"];
            $descripcion_producto = $lista_productos["descripcion"];
            switch($esquema)
            {
                case 1:
                    $precio = $lista_productos["precio_renta"];
                    break;
                case 2:
                    $precio = $lista_productos["precio_venta"];
                    break;
            }
            $importe_producto = $precio * $cantidad_producto;
            
            $precio_txt = number_format($precio, 2, '.', ',');
            if(is_null($precio_txt))
            {
                $precio_txt = "No disponible";
            }
            else
            {
                $precio_txt = "$ $precio_txt";
            }
            
            $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
            if(is_null($importe_producto_txt))
            {
                $importe_producto_txt = "No disponible";
            }
            else
            {
                $importe_producto_txt = "$ $importe_producto_txt";
            }
            break;
        }
        case 2: // VENTA
        {
            $condicion_pago = "VENTA";
            $condicion_amarillo = "VENTA";
            break;
        }
        case 3: // ALARMA VECINAL
        {
            $cotizacion_producto = "ALARMAS VECINALES";
            $cantidad_producto=$_POST['cantidad_alarmas'];
            $cantidad_controles=$_POST['cantidad_controles'];
            
            $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE categoria = 'alarma_vecinal' AND tipo = 'base'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
            $lista_productos = mysqli_fetch_assoc($consulta_productos);
            $nombre_producto = $lista_productos["nombre"];
            $descripcion_producto = $lista_productos["descripcion"];
            switch($esquema)
            {
                case 1:
                    $precio = $lista_productos["precio_renta"];
                    break;
                case 2:
                    $precio = $lista_productos["precio_venta"];
                    break;
            }
            $importe_producto = $precio * $cantidad_producto;
            
            $precio_txt = number_format($precio, 2, '.', ',');
            if(is_null($precio_txt))
            {
                $precio_txt = "No disponible";
            }
            else
            {
                $precio_txt = "$ $precio_txt";
            }
            
            $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
            if(is_null($importe_producto_txt))
            {
                $importe_producto_txt = "No disponible";
            }
            else
            {
                $importe_producto_txt = "$ $importe_producto_txt";
            }
            
            if($cantidad_controles > 0 && $esquema == 2)
            {
                $complementos = true;
                $cantidad_art_comp = 1;
                $cantidad_complemento = $cantidad_controles;
                $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE categoria = 'alarma_vecinal' AND tipo = 'extra'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
                $lista_productos = mysqli_fetch_assoc($consulta_productos);
                $nombre_complemento = $lista_productos["nombre"];
                $descripcion_complemento = $lista_productos["descripcion"];
                switch($esquema)
                {
                    case 1:
                        $precio_complemento = $lista_productos["precio_renta"];
                        break;
                    case 2:
                        $precio_complemento = $lista_productos["precio_venta"];
                        break;
                }
                $importe_complemento = $precio_complemento * $cantidad_complemento;
                
                $precio_complemento_txt = number_format($precio_complemento, 2, '.', ',');
                if(is_null($precio_complemento_txt))
                {
                    $precio_complemento_txt = "No disponible";
                }
                else
                {
                    $precio_complemento_txt = "$ $precio_complemento_txt";
                }
                
                $importe_complemento_txt = number_format($importe_complemento, 2, '.', ',');
                if(is_null($importe_complemento_txt))
                {
                    $importe_complemento_txt = "No disponible";
                }
                else
                {
                    $importe_complemento_txt = "$ $importe_complemento_txt";
                }
            }
            break;
        }
        case 4: // CONTROL DE ASISTENCIA
        {
            $cotizacion_producto = "CONTROL DE ASISTENCIA";
            $cantidad_producto=$_POST['cantidad_asistencias'];
            $tipo_asistencia=$_POST['tipo_asistencia'];
            switch($tipo_asistencia)
            {
                case "local":
                    $control_asistencia = "2099";
                    break;
                case "nube":
                    $control_asistencia = "2100";
                    break;
            }
            
            $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$control_asistencia'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
            $lista_productos = mysqli_fetch_assoc($consulta_productos);
            $nombre_producto = $lista_productos["nombre"];
            $descripcion_producto = $lista_productos["descripcion"];
            switch($esquema)
            {
                case 1:
                    $precio = $lista_productos["precio_renta"];
                    break;
                case 2:
                    $precio = $lista_productos["precio_venta"];
                    break;
            }
            $importe_producto = $precio * $cantidad_producto;
            
            $precio_txt = number_format($precio, 2, '.', ',');
            if(is_null($precio_txt))
            {
                $precio_txt = "No disponible";
            }
            else
            {
                $precio_txt = "$ $precio_txt";
            }
            
            $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
            if(is_null($importe_producto_txt))
            {
                $importe_producto_txt = "No disponible";
            }
            else
            {
                $importe_producto_txt = "$ $importe_producto_txt";
            }
            break;
        }
        case 5: // CONTROL DE ACCESO
        {
            $cotizacion_producto = "CONTROL DE ACCESO";
            $cantidad_producto=$_POST['cantidad_accesos'];
            $tipo_acceso=$_POST['tipo_acceso'];
            
            switch($tipo_acceso)
            {
                case "peatonal":
                    $tipo_peatonal = $_POST['tipo_peatonal'];
                    switch($tipo_peatonal)
                    {
                        case "flap":
                            $clave_control = 2128;
                            break;
                        case "swing":
                            $clave_control = 2129;
                            break;
                        case "torniquete":
                            $clave_control = 2128; // CLAVE PROVISIONAL (NO EXISTE)
                            break;
                    }
                    break;
                case "vehicular":
                    $tipo_barrera = $_POST['tipo_barrera'];
                    $medida_barrera = $_POST['medida_barrera'];
                    switch($tipo_barrera)
                    {
                        case "telescopica":
                            switch($medida_barrera)
                            {
                                case 3:
                                    $clave_control = 2101;
                                    break;
                                case 4:
                                    $clave_control = 2102;
                                    break;
                                case 6:
                                    $clave_control = 2103;
                                    break;
                            }
                            break;
                        case "articular":
                            switch($medida_barrera)
                            {
                                case 3:
                                    $clave_control = 2104;
                                    break;
                                case 4:
                                    $clave_control = 2105;
                                    break;
                            }
                            break;
                    }
                    /*
                    $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_control'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
                    $lista_productos = mysqli_fetch_assoc($consulta_productos);
                    $nombre_producto = $lista_productos["nombre"];
                    $descripcion_producto = $lista_productos["descripcion"];
                    switch($esquema)
                    {
                        case 1:
                            $precio = $lista_productos["precio_renta"];
                            break;
                        case 2:
                            $precio = $lista_productos["precio_venta"];
                            break;
                    }
                    */
                    break;
                case "puerta":
                    $tipo_puerta = $_POST['tipo_puerta'];
                    switch($tipo_puerta)
                    {
                        case "huella":
                            $clave_control = 2084;
                            break;
                        case "facial":
                            $clave_control = 2087;
                            break;
                    }
                    /*
                    $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_control'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
                    $lista_productos = mysqli_fetch_assoc($consulta_productos);
                    $nombre_producto = $lista_productos["nombre"];
                    $descripcion_producto = $lista_productos["descripcion"];
                    switch($esquema)
                    {
                        case 1:
                            $precio = $lista_productos["precio_renta"];
                            break;
                        case 2:
                            $precio = $lista_productos["precio_venta"];
                            break;
                    }
                    */
                    break;
            }
            $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_control'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
            $lista_productos = mysqli_fetch_assoc($consulta_productos);
            $nombre_producto = $lista_productos["nombre"];
            $descripcion_producto = $lista_productos["descripcion"];
            switch($esquema)
            {
                case 1:
                    $precio = $lista_productos["precio_renta"];
                    break;
                case 2:
                    $precio = $lista_productos["precio_venta"];
                    break;
            }
            $importe_producto = $precio * $cantidad_producto;
                            
            $precio_txt = number_format($precio, 2, '.', ',');
            if(is_null($precio_txt))
            {
                $precio_txt = "No disponible";
            }
            else
            {
                $precio_txt = "$ $precio_txt";
            }
            
            $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
            if(is_null($importe_producto_txt))
            {
                $importe_producto_txt = "No disponible";
            }
            else
            {
                $importe_producto_txt = "$ $importe_producto_txt";
            }
            break;
        }
        case 6: // VIDEOPORTERO E INTERFON
        {
            $cotizacion_producto = "VIDEO PORTERO / INTERFON";
            $cantidad_producto= "1";
            $tipo_producto=$_POST['tipo_portero'];
            
            switch($tipo_producto)
            {
                case "videoportero":
                    $tipo_videoportero = $_POST['tecnologia'];
                    switch($tipo_videoportero)
                    {
                        case "analogo":
                            $clave_producto = 2075;
                            $clave_complemento = 2077;
                            $contestadores = $_POST['cantidad_contestadores_analogo'];
                            if($contestadores > 1)
                            {
                                $complementos = true;
                                $cantidad_art_comp = 1;
                                $cantidad_complemento = 1;
                                $consulta_complemento = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_complemento'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
                                $lista_complementos = mysqli_fetch_assoc($consulta_complemento);
                                $nombre_complemento = $lista_complementos["nombre"];
                                $descripcion_complemento = $lista_complementos["descripcion"];
                                switch($esquema)
                                {
                                    case 1:
                                        $precio_complemento = $lista_complementos["precio_renta"];
                                        break;
                                    case 2:
                                        $precio_complemento = $lista_complementos["precio_venta"];
                                        break;
                                }
                                $importe_complemento = $precio_complemento * $cantidad_complemento;
                                
                                $precio_complemento_txt = number_format($precio_complemento, 2, '.', ',');
                                if(is_null($precio_complemento_txt))
                                {
                                    $precio_complemento_txt = "No disponible";
                                }
                                else
                                {
                                    $precio_complemento_txt = "$ $precio_complemento_txt";
                                }
                                
                                $importe_complemento_txt = number_format($importe_complemento, 2, '.', ',');
                                if(is_null($importe_complemento_txt))
                                {
                                    $importe_complemento_txt = "No disponible";
                                }
                                else
                                {
                                    $importe_complemento_txt = "$ $importe_complemento_txt";
                                }
                            }
                        break;
                        
                        case "ip":
                            $uso_ip = $_POST['lugar_ip'];
                            switch($uso_ip)
                            {
                                case "casa":
                                    $clave_producto = 2079;
                                    $clave_complemento = 2081;
                                    $contestadores = $_POST['cantidad_contestadores_ip'];
                                    if($contestadores > 1)
                                    {
                                        $complementos = true;
                                        $cantidad_art_comp = 1;
                                        $cantidad_complemento = 1;
                                        $consulta_complemento = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_complemento'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
                                        $lista_complementos = mysqli_fetch_assoc($consulta_complemento);
                                        $nombre_complemento = $lista_complementos["nombre"];
                                        $descripcion_complemento = $lista_complementos["descripcion"];
                                        switch($esquema)
                                        {
                                            case 1:
                                                $precio_complemento = $lista_complementos["precio_renta"];
                                                break;
                                            case 2:
                                                $precio_complemento = $lista_complementos["precio_venta"];
                                                break;
                                        }
                                        $importe_complemento = $precio_complemento * $cantidad_complemento;
                                        
                                        $precio_complemento_txt = number_format($precio_complemento, 2, '.', ',');
                                        if(is_null($precio_complemento_txt))
                                        {
                                            $precio_complemento_txt = "No disponible";
                                        }
                                        else
                                        {
                                            $precio_complemento_txt = "$ $precio_complemento_txt";
                                        }
                                        
                                        $importe_complemento_txt = number_format($importe_complemento, 2, '.', ',');
                                        if(is_null($importe_complemento_txt))
                                        {
                                            $importe_complemento_txt = "No disponible";
                                        }
                                        else
                                        {
                                            $importe_complemento_txt = "$ $importe_complemento_txt";
                                        }
                                    }
                                    break;
                                case "departamento":
                                    $clave_producto = 2083;
                                    $clave_complemento = 2085;
                                    $cantidad_departamentos = $_POST['cantidad_departamentos'];
                                    if($cantidad_departamentos > 10)
                                    {
                                        $complementos = true;
                                        $cantidad_art_comp = 1;
                                        $cantidad_complemento = $cantidad_departamentos - 10;
                                        $consulta_complemento = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_complemento'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
                                        $lista_complementos = mysqli_fetch_assoc($consulta_complemento);
                                        $nombre_complemento = $lista_complementos["nombre"];
                                        $descripcion_complemento = $lista_complementos["descripcion"];
                                        switch($esquema)
                                        {
                                            case 1:
                                                $precio_complemento = $lista_complementos["precio_renta"];
                                                break;
                                            case 2:
                                                $precio_complemento = $lista_complementos["precio_venta"];
                                                break;
                                        }
                                        $importe_complemento = $precio_complemento * $cantidad_complemento;
                                        
                                        $precio_complemento_txt = number_format($precio_complemento, 2, '.', ',');
                                        if(is_null($precio_complemento_txt))
                                        {
                                            $precio_complemento_txt = "No disponible";
                                        }
                                        else
                                        {
                                            $precio_complemento_txt = "$ $precio_complemento_txt";
                                        }
                                        
                                        $importe_complemento_txt = number_format($importe_complemento, 2, '.', ',');
                                        if(is_null($importe_complemento_txt))
                                        {
                                            $importe_complemento_txt = "No disponible";
                                        }
                                        else
                                        {
                                            $importe_complemento_txt = "$ $importe_complemento_txt";
                                        }
                                    }
                                    break;
                            }
                        break;
                    }
                    break;
                case "interfon":
                    $uso_interfon = $_POST['lugar_interfon'];
                    switch($uso_interfon)
                    {
                        case "casas":
                            $clave_producto = 2071;
                            $clave_complemento = 2073;
                            $contestadores = $_POST['cantidad_contestadores_interfon'];
                            if($contestadores > 1)
                            {
                                $complementos = true;
                                $cantidad_art_comp = 1;
                                $cantidad_complemento = 1;
                                $consulta_complemento = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_complemento'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
                                $lista_complementos = mysqli_fetch_assoc($consulta_complemento);
                                $nombre_complemento = $lista_complementos["nombre"];
                                $descripcion_complemento = $lista_complementos["descripcion"];
                                switch($esquema)
                                {
                                    case 1:
                                        $precio_complemento = $lista_complementos["precio_renta"];
                                        break;
                                    case 2:
                                        $precio_complemento = $lista_complementos["precio_venta"];
                                        break;
                                }
                                $importe_complemento = $precio_complemento * $cantidad_complemento;
                                
                                $precio_complemento_txt = number_format($precio_complemento, 2, '.', ',');
                                if(is_null($precio_complemento_txt))
                                {
                                    $precio_complemento_txt = "No disponible";
                                }
                                else
                                {
                                    $precio_complemento_txt = "$ $precio_complemento_txt";
                                }
                                
                                $importe_complemento_txt = number_format($importe_complemento, 2, '.', ',');
                                if(is_null($importe_complemento_txt))
                                {
                                    $importe_complemento_txt = "No disponible";
                                }
                                else
                                {
                                    $importe_complemento_txt = "$ $importe_complemento_txt";
                                }
                            }
                            break;
                        case "otro":
                            $clave_producto = 2069;
                            $cantidad_producto = $_POST['cantidad_casas'];
                            break;
                    }
                    break;
            }
            $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
            $lista_productos = mysqli_fetch_assoc($consulta_productos);
            $nombre_producto = $lista_productos["nombre"];
            $descripcion_producto = $lista_productos["descripcion"];
            switch($esquema)
            {
                case 1:
                    $precio = $lista_productos["precio_renta"];
                    break;
                case 2:
                    $precio = $lista_productos["precio_venta"];
                    break;
            }
            $importe_producto = $precio * $cantidad_producto;
                            
            $precio_txt = number_format($precio, 2, '.', ',');
            if(is_null($precio_txt))
            {
                $precio_txt = "No disponible";
            }
            else
            {
                $precio_txt = "$ $precio_txt";
            }
            
            $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
            if(is_null($importe_producto_txt))
            {
                $importe_producto_txt = "No disponible";
            }
            else
            {
                $importe_producto_txt = "$ $importe_producto_txt";
            }
            break;
        }
        case 7: // ARCO DETECTOR DE METAL
        {
            $cotizacion_producto = "ARCO DETECTOR";
            $cantidad_producto=1;
            $tipo_producto=$_POST['zonas'];
            
            switch($tipo_producto)
            {
                case 6:
                    $clave_producto = "2109";
                    break;
                case 18:
                    $clave_producto = "2110";
                    break;
            }
            
            $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
            $lista_productos = mysqli_fetch_assoc($consulta_productos);
            $nombre_producto = $lista_productos["nombre"];
            $descripcion_producto = $lista_productos["descripcion"];
            switch($esquema)
            {
                case 1:
                    $precio = $lista_productos["precio_renta"];
                    break;
                case 2:
                    $precio = $lista_productos["precio_venta"];
                    break;
            }
            $importe_producto = $precio * $cantidad_producto;
                            
            $precio_txt = number_format($precio, 2, '.', ',');
            if(is_null($precio_txt))
            {
                $precio_txt = "No disponible";
            }
            else
            {
                $precio_txt = "$ $precio_txt";
            }
            
            $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
            if(is_null($importe_producto_txt))
            {
                $importe_producto_txt = "No disponible";
            }
            else
            {
                $importe_producto_txt = "$ $importe_producto_txt";
            }
            break;
        }
        case 8: // PUNTO DE VENTA - POINT OF SALE (POS)
        {
            $cotizacion_producto = "POINT OF SALE (POS)";
            $tipo_producto=$_POST['tienda'];

            switch($tipo_producto)
            {
                case "restaurante":
                    $cantidad_producto=$_POST['cantidad_puntos'];
                    $clave_producto = "2107";
                    $clave_complemento = "2108";
                    $cantidad_tablet=$_POST['cantidad_tablet'];
                    if($cantidad_tablet > 0)
                    {
                        $complementos = true;
                        $cantidad_art_comp = 1;
                        $cantidad_complemento = $cantidad_tablet;
                        $consulta_complemento = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_complemento'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
                        $lista_complementos = mysqli_fetch_assoc($consulta_complemento);
                        $nombre_complemento = $lista_complementos["nombre"];
                        $descripcion_complemento = $lista_complementos["descripcion"];
                        switch($esquema)
                        {
                            case 1:
                                $precio_complemento = $lista_complementos["precio_renta"];
                                break;
                            case 2:
                                $precio_complemento = $lista_complementos["precio_venta"];
                                break;
                        }
                        $importe_complemento = $precio_complemento * $cantidad_complemento;
                        
                        $precio_complemento_txt = number_format($precio_complemento, 2, '.', ',');
                        if(is_null($precio_complemento_txt))
                        {
                            $precio_complemento_txt = "No disponible";
                        }
                        else
                        {
                            $precio_complemento_txt = "$ $precio_complemento_txt";
                        }
                        
                        $importe_complemento_txt = number_format($importe_complemento, 2, '.', ',');
                        if(is_null($importe_complemento_txt))
                        {
                            $importe_complemento_txt = "No disponible";
                        }
                        else
                        {
                            $importe_complemento_txt = "$ $importe_complemento_txt";
                        }
                    }
                    break;
                case "otro":
                    $cantidad_producto=$_POST['cantidad_otros'];
                    $clave_producto = "2106";
                    break;
            }
            
            $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
            $lista_productos = mysqli_fetch_assoc($consulta_productos);
            $nombre_producto = $lista_productos["nombre"];
            $descripcion_producto = $lista_productos["descripcion"];
            switch($esquema)
            {
                case 1:
                    $precio = $lista_productos["precio_renta"];
                    break;
                case 2:
                    $precio = $lista_productos["precio_venta"];
                    break;
            }
            $importe_producto = $precio * $cantidad_producto;
                            
            $precio_txt = number_format($precio, 2, '.', ',');
            if(is_null($precio_txt))
            {
                $precio_txt = "No disponible";
            }
            else
            {
                $precio_txt = "$ $precio_txt";
            }
            
            $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
            if(is_null($importe_producto_txt))
            {
                $importe_producto_txt = "No disponible";
            }
            else
            {
                $importe_producto_txt = "$ $importe_producto_txt";
            }
            break;
        }
        case 9: // CERRADURA ELECTRÓNICA
        {
            $cotizacion_producto = "CERRADURA ELECTRÓNICA";
            $cantidad_producto=$_POST['cantidad_puertas'];
            $tipo_cerradura=$_POST['cerradura'];
            
            switch($tipo_cerradura)
            {
                case "hotel":
                    $clave_control = 2125;
                    break;
                case "casa":
                    $clave_control = 2126;
                    break;
                case "airbnb":
                    $clave_control = 2127;
                    break;
            }
            
            $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_control'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
            $lista_productos = mysqli_fetch_assoc($consulta_productos);
            $nombre_producto = $lista_productos["nombre"];
            $descripcion_producto = $lista_productos["descripcion"];
            switch($esquema)
            {
                case 1:
                    $precio = $lista_productos["precio_renta"];
                    break;
                case 2:
                    $precio = $lista_productos["precio_venta"];
                    break;
            }
            
            $importe_producto = $precio * $cantidad_producto;
                            
            $precio_txt = number_format($precio, 2, '.', ',');
            if(is_null($precio_txt))
            {
                $precio_txt = "No disponible";
            }
            else
            {
                $precio_txt = "$ $precio_txt";
            }
            
            $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
            if(is_null($importe_producto_txt))
            {
                $importe_producto_txt = "No disponible";
            }
            else
            {
                $importe_producto_txt = "$ $importe_producto_txt";
            }
            
            break;
        }
        default: // SIN DEFINIR
        {
            $condicion_pago = "SIN DEFINIR";
            $condicion_amarillo = "N/A";
            break;
        }
    }
    /////////////////// OPERACIONES PARA OBTENER EL CONTENIDO DEL PDF ///////////////////

    ///////////////// SE INSTANCIA LA CLASE DEL PDF /////////////////
    //////// SE PUEDE AÑADIR ENCABEZADO Y PIE DE PAGINA AQUÍ ////////
    class Pdf extends Fpdi\Tcpdf\Fpdi
    {
        /**
         * "Remembers" the template id of the imported page
         */
        protected $tplId;

        /**
         * Draw an imported PDF logo on every page
         */
        function Header()
        {
            // emtpy method body
        }

        function Footer()
        {
            // emtpy method body
        }
    }
    ///////////////// SE INSTANCIA LA CLASE DEL PDF /////////////////
    //////// SE PUEDE AÑADIR ENCABEZADO Y PIE DE PAGINA AQUÍ ////////

    ///////////////// SE CREA OBJETO PDF /////////////////
    $pdf = new pdf();
    ///////////////// SE CREA OBJETO PDF /////////////////

    ////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////
    $pagecount = $pdf->setSourceFile("hoja.pdf");
    ////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////
    
    ////////////// SE IMPORTA LA HOJA QUE SE USARÁ DE PLANTILLA //////////////
    $tpl = $pdf->importPage(1);
    ////////////// SE IMPORTA LA HOJA QUE SE USARÁ DE PLANTILLA //////////////

    /////// DESIGNAMOS EL TAMAÑO DE LA PLANTILLA DESDE LA HOJA IMPORTADA ///////
    $size = $pdf->getTemplateSize($tpl);
    /////// DESIGNAMOS EL TAMAÑO DE LA PLANTILLA DESDE LA HOJA IMPORTADA ///////
    
    ///////// AÑADIMOS UNA PÁGINA DESIGNANDO EL TAMAÑO DEL DOCUMENTO /////////
    ////////////// (LETTER = CARTA, 'P' = Portrait ~ vertical) //////////////
    $pdf->AddPage('P', 'LETTER');
    ///////// AÑADIMOS UNA PÁGINA DESIGNANDO EL TAMAÑO DEL DOCUMENTO /////////

    ////////////// CARGAMOS LA PLANTILLA EN NUESTRA NUEVA PÁGINA //////////////
    $pdf->useTemplate($tpl);
    ////////////// CARGAMOS LA PLANTILLA EN NUESTRA NUEVA PÁGINA //////////////

    // POSICIÓN DE PRIMERAS COORDENADAS (LAS COORDENADAS SE AJUSTAN A LOS MILIMETROS DE LA HOJA)
    //Limite de hoja 0-216 (ancho) primer valor 0 representa borde
    $pdf->SetY(43);
    $pdf->SetX(15);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',10.5);
    // WRITEHTMLCELL permite crear una celda en la que podemos insertar código HTML y de esta forma hacer un texto más dinámico
    //$pdf->writeHTMLCell(W, H, 'X', 'Y', $html, border, line, fill, reseth, 'align', autopadding);
    
    /*$html = "MARGEN INICIAL (1.5cm) 4.3cm de alto";
    $pdf->writeHTMLCell(186, 5, '', '', $html, 1, 0, 0, TRUE, 'J', TRUE);*/
    
    // REAJUSTE DE COORDENADAS (DESPLAZAMIENTO ENTRE LA HOJA)
    $pdf->SetY(50);
    $pdf->SetX(15);
    // SE PUEDE CAMBIAR LA FUENTE, Y TAMAÑO VOLVIENDO A USAR EL COMANDO SETFONT
    $pdf->SetFont('helvetica','B',20);
    $pdf->Cell(186, 10, "COTIZACIÓN", 0, 0, 'R');

    ////// SECCIÓN RECTANGULO NARANJA 01 //////
    $pdf->SetY(65);
    $pdf->SetX(121);
    $pdf->SetFont('helvetica','B',12);
    // DEFINE COLOR DE RELLENO
    $pdf->SetFillColor(253,107,13); 
    // DEFINE COLOR DE RELLENO

    // DEFINE COLOR DE TEXTO
    $pdf->SetTextColor(255,255,255);
    // DEFINE COLOR DE TEXTO

    // CELL(X,Y,texto,borde,ln,alineacion,relleno(booleano))
    $pdf->Cell(80, 6, "NÚMERO DE COTIZACIÓN", 0, 0, 'R',TRUE);
    ////// SECCIÓN RECTANGULO NARANJA 01 //////

    ////// SECCIÓN RECTANGULO AMARILLO 01 //////
    $pdf->SetY(71);
    $pdf->SetX(121);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(80, 6, "$folio_cotizacion", 0, 0, 'R',TRUE);
    ////// SECCIÓN RECTANGULO AMARILLO 01 //////

    ////// SECCIÓN RECTANGULO NARANJA 02 //////
    $pdf->SetY(77);
    $pdf->SetX(121);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(253,107,13);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(80, 6, "CONDICIONES DE PAGO", 0, 0, 'R',TRUE);
    ////// SECCIÓN RECTANGULO NARANJA 02 //////

    ////// SECCIÓN RECTANGULO AMARILLO 02 //////
    $pdf->SetY(83);
    $pdf->SetX(121);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(80, 6, "$condicion_pago", 0, 0, 'R',TRUE);
    ////// SECCIÓN RECTANGULO AMARILLO 02 //////

    ////// SECCIÓN RECTANGULO NARANJA (FECHA) //////
    $pdf->SetY(65);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(253,107,13);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(40, 6, "FECHA", 0, 0, 'C',TRUE);
    ////// SECCIÓN RECTANGULO NARANJA (FECHA) //////

    $fecha_actual = fechaCastellano($fecha_actual);
    ////// SECCIÓN RECTANGULO FECHA //////
    $pdf->SetY(65);
    $pdf->SetX(57);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(60, 6, $fecha_actual, 0, 0, 'L');
    ////// SECCIÓN RECTANGULO FECHA //////

    ////// SECCIÓN RECTANGULO AMARILLO (nombre de proyecto) //////
    $pdf->SetY(71);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90, 6, "$direccion", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO AMARILLO (nombre de proyecto) //////

    ////// SECCIÓN RECTANGULO AMARILLO (nombre cliente) //////
    $pdf->SetY(77);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90, 6, "$nombre_cliente", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO AMARILLO (nombre cliente) //////

    ////// SECCIÓN RECTANGULO AMARILLO (PRODUCTO/SERVICIO) //////
    $pdf->SetY(83);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90, 6, "$cotizacion_producto", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO AMARILLO (PRODUCTO/SERVICIO) //////

    ////// INICIA ZONA DE LISTA DE ARTICULOS  //////

    ////// CABECERAS DE LA TABLA (MARCO REFERENCIA - QUITAR) //////
    $pdf->SetY(95);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(186, 6, "", 0, 0, 'L');
    ////// CABECERAS DE LA TABLA (MARCO REFERENCIA - QUITAR) //////

    ////// CABECERAS DE LA TABLA //////
    $pdf->SetY(95);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(30, 6, "Cant.", 0, 0, 'C');

    /*$pdf->SetY(95);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(30, 6, "Item no.", 0, 0, 'C');*/

    $pdf->SetY(95);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(95, 6, "Descripción del producto.", 0, 0, 'C');

    $pdf->SetY(95);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(30, 6, "P. Unitario.", 0, 0, 'C');

    $pdf->SetY(95);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(31, 6, "Importe.", 0, 0, 'C');
    ////// CABECERAS DE LA TABLA //////

    ////// BARRA AMARILLA //////
    $pdf->SetY(101);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(30, 6, "$condicion_amarillo", 0, 0, 'C',TRUE);
    ////// BARRA AMARILLA //////

    ////// BARRA GRIS //////
    $pdf->SetY(101);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(191,191,191);
    $pdf->Cell(156, 6, "", 0, 0, 'C',TRUE);
    ////// BARRA GRIS //////

    // INFORMACIÓN PARA PRUEBAS //
    $conceptos = 2;
    $altura_concepto = 107;
    $altura_articulo = 107;
    $altura_descripcion = 119;
    // INFORMACIÓN PARA PRUEBAS //

    ///////// COMIENZA CONTENIDO /////////
    ////// CANTIDAD //////
    $pdf->SetY(107);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','',12);
    $pdf->Cell(30, 40, "$cantidad_producto", 0,0,'C');
    ////// CANTIDAD //////

    ////// DESCRIPCIÓN (ARTÍCULO) //////
    $pdf->SetY(107);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(95, 12, "$nombre_producto", 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
    ////// DESCRIPCIÓN (ARTÍCULO) //////

    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
    $pdf->SetY(119);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',8);
    $pdf->MultiCell(95, 28, "$descripcion_producto", 0, 'L', 0,0,'','',true,0,false,true,28,'M');
    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY(107);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(30, 40, "$precio_txt", 0, 'C', 0,0,'','',true,0,false,true,40,'M');
    ////// PRECIO UNITARIO //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY(107);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(31, 40, "$importe_producto_txt", 0, 'C', 0,0,'','',true,0,false,true,40,'M');
    ////// PRECIO UNITARIO //////

    $altura_concepto = $altura_concepto + 40;
    $altura_descripcion = $altura_concepto + 12;
    $llenado = true;
    $pdf->SetFillColor(216,217,215);
    ///////////// TERMINA PRODUCTO PRINCIPAL ///////////////

    
    if($complementos == true)
    {
        for($i=1;$i<=$cantidad_art_comp;$i++)
        {
            ///////////// INICIAN COMPLEMENTOS ///////////////
            
            ////// CANTIDAD //////
            $pdf->SetY($altura_concepto);
            $pdf->SetX(15);
            $pdf->SetFont('helvetica','',12);
            $pdf->Cell(30, 20, "$cantidad_complemento", 0,0,'C',$llenado);
            ////// CANTIDAD //////
        
            ////// DESCRIPCIÓN (ARTÍCULO) //////
            $pdf->SetY($altura_concepto);
            $pdf->SetX(45);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell(95, 12, "$nombre_complemento", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 12, 'M');
            ////// DESCRIPCIÓN (ARTÍCULO) //////
        
            ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
            $pdf->SetY($altura_descripcion);
            $pdf->SetX(45);
            $pdf->SetFont('helvetica','B',8);
            $pdf->MultiCell(95, 8, "$descripcion_complemento", 0, 'L', $llenado,0,'','',true,0,false,true,8,'M');
            ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
        
            ////// PRECIO UNITARIO //////
            $pdf->SetY($altura_concepto);
            $pdf->SetX(140);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell(30, 20, "$precio_complemento_txt", 0, 'C', $llenado,0,'','',true,0,false,true,20,'M');
            ////// PRECIO UNITARIO //////
        
            ////// PRECIO UNITARIO //////
            $pdf->SetY($altura_concepto);
            $pdf->SetX(170);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell(31, 20, "$importe_complemento_txt", 0, 'C', $llenado,0,'','',true,0,false,true,20,'M');
            ////// PRECIO UNITARIO //////
            
            $altura_concepto = $altura_concepto + 20;
            $altura_descripcion = $altura_concepto + 12;
            $subtotal_complemento = $subtotal_complemento + $importe_complemento;
            if($llenado == true)
            {
                $llenado = false;
            }
            else
            {
                $llenado = true;
            }
        }
    }

    ///////// TERMINA CONTENIDO /////////

    ///////// INICIA FOOTER /////////

    $altura_footer = $altura_concepto;
    $altura_subtotal = $altura_footer;
    $altura_iva = $altura_subtotal + 6;
    $altura_total = $altura_iva + 6;
    
    $subtotal = $importe_producto + $subtotal_complemento;
    $iva = $subtotal * 0.16;
    $total = $subtotal + $iva;
    
    $subtotal = number_format($subtotal, 2, '.', ',');
    if(is_null($subtotal))
    {
        $subtotal = "$ 0.00";
    }
    else
    {
        $subtotal = "$ $subtotal";
    }
    
    $iva = number_format($iva, 2, '.', ',');
    if(is_null($iva))
    {
        $iva = "$ 0.00";
    }
    else
    {
        $iva = "$ $iva";
    }
    
    $total = number_format($total, 2, '.', ',');
    if(is_null($total))
    {
        $total = "$ 0.00";
    }
    else
    {
        $total = "$ $total";
    }

    ////// BARRA GRIS FOOTER //////
    $pdf->SetY($altura_footer);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(191,191,191);
    $pdf->Cell(186, 6, "", 0, 0, 'C',TRUE);
    ////// BARRA GRIS FOOTER //////

    // SUBTOTAL (texto) //
    $pdf->SetY($altura_subtotal);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(30, 6, "SUBTOTAL", 0, 0, 'C');
    // SUBTOTAL (texto) //

    // SUBTOTAL (cantidad) //
    $pdf->SetY($altura_subtotal);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(31, 6, "$subtotal", 0, 0, 'C');
    // SUBTOTAL (cantidad) //

    // IVA (texto) //
    $pdf->SetY($altura_iva);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(30, 6, "IVA", 0, 0, 'C',TRUE);
    // IVA (texto) //

    // IVA (cantidad) //
    $pdf->SetY($altura_iva);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(31, 6, "$iva", 0, 0, 'C',TRUE);
    // IVA (cantidad) //

    // TOTAL (texto) //
    $pdf->SetY($altura_total);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(30, 6, "TOTAL", 0, 0, 'C',TRUE);
    // TOTAL (texto) //

    // TOTAL (cantidad) //
    $pdf->SetY($altura_total);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(31, 6, "$total", 0, 0, 'C',TRUE);
    // TOTAL (cantidad) //

    ///////// TERMINA FOOTER /////////

    //////// TERMINOS Y DATOS DEL ASESOR /////////

    ////// BARRA NARANJA TYC //////
    $pdf->SetY(215);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(253,107,13);
    $pdf->Cell(90, 6, "", 0, 0, 'C',TRUE);
    ////// BARRA NARANJA TYC //////

    ////// TITULO TYC //////
    $pdf->SetY(215);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(90, 6, "TERMINOS Y CONDICIONES", 0, 0, 'C');
    ////// TITULO TYC //////

    $texto_term = 
    ' 1. Precios cotizados en moneda nacional mas el 16% de IVA.
 2. Se requiere depósito bancario del 60% del pedido total.
 3. Entrega inmediata.
 4. La garantía normal es por un periodo de 1 año.
 5. Promoción válida durante 15 días a partir de la fecha de cotización.
 6. Los precios cotizados son válidos para una sola orden de compra.
 7. Se requiere pago de depósito y primera mensualidad al inicio del proyecto para Leasing.
 8. La garantia es por contrato en curso para leasing.
 9. El contrato tiene una vigencia de 36 meses para Leasing.
';

    ////// TYC //////
    $pdf->SetY(221);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','',6);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(90, 28, $texto_term, 0, 'J', 0, 0, '', '', true, 0, false, true, 28, 'M');
    ////// TYC //////

    ////// SECCIÓN RECTANGULO CERRADOR //////
    $pdf->SetY(221);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(61, 6, "$nombre_usuario", 0, 0, 'R',TRUE);
    ////// SECCIÓN RECTANGULO CERRADOR //////

    ////// SECCIÓN RECTANGULO CERRADOR //////
    $pdf->SetY(227);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','',10);
    $pdf->Cell(61, 6, "Alianzas comerciales", 0, 0, 'R');
    ////// SECCIÓN RECTANGULO CERRADOR //////

    ////// SECCIÓN RECTANGULO AMARILLO CORREO //////
    $pdf->SetY(233);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(61, 6, "$correo_usuario", 0, 0, 'R',TRUE);
    ////// SECCIÓN RECTANGULO AMARILLO CORREO //////

    ////// SECCIÓN RECTANGULO TELEFONO //////
    $pdf->SetY(239);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(61, 6, "Tel. 55-5367-4298 / 55-6821-5744", 0, 0, 'R');
    ////// SECCIÓN RECTANGULO TELEFONO //////

    //////// TERMINOS Y DATOS DEL ASESOR /////////

    
    // ENVIA EL PDF A DESPLEGARSE EN PANTALLA
    // SE PUEDE PONER EL NOMBRE DEL ARCHIVO PARA GUARDADO
    $pdf->Output("cotizacion.pdf", 'I');



?>