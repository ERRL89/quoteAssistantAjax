<?php
    // LLAMADA A LA CONEXIÓN DE LA BD //
    include "../conexion/conexion.php";
    // LLAMADA A LA CONEXIÓN DE LA BD //
    if(isset($_POST["kit"]) && isset($_POST["nombre"]) && isset($_POST["calle"]) && isset($_POST["numero"]) && isset($_POST["colonia"])){
        // Recibe variables de formulario principal
        $kit = $_POST["kit"];
        $kitTxt=$_POST["kit"];
        $kitPrice=$_POST["kitPrice"];
        $kitNum=$_POST["kitNum"];
        $folio_cotizacion=$_POST["folioCotizacion"];

        //Transforma kit recibido en texto a numero para adaptacion al script ya existente
        if($kit=="KIT 4 CAMARAS"){ $kit=1; }
        if($kit=="KIT ALARMA DEPARTAMENTO CON MONITOREO"){ $kit=2; }
        if($kit=="KIT ALARMA CON MONITOREO"){ $kit=3; }
        if($kit=="KIT DE 4 CAMARAS, ALARMA Y MONITOREO"){ $kit=4; }

        //Asiga variables recibidas por POST
        $nombre=$_POST["nombre"];
        $calle=$_POST["calle"];
        $numero=$_POST["numero"];
        $colonia=$_POST["colonia"];
        $direccionCompleta=$calle." ".$numero." ".$colonia;

        //Codifica variables
        $nombreCodificado = base64_encode($nombre);
        $calleCodificado = base64_encode($calle);
        $numeroCodificado = base64_encode($numero);
        $coloniaCodificado = base64_encode($colonia);
        $kitCodificado = base64_encode($kitTxt);
        $kitPriceCodificado = base64_encode($kitPrice);
    }

    $precio_final = 0;

    $kit_final = [];
    
     //Se obtienen los datos por POST
    
    $tipo_kit = "";
    
    //TIPO KIT
    if($kit == 1 )
    {
        //$tipo_kit = 4001;
        
        $cantidad_combo = 1;
        
        // LLAMADA A LA CONEXIÓN DE LA BD //
        include "../conexion/conexion.php";
        // LLAMADA A LA CONEXIÓN DE LA BD //
        
        $kit_base = "4004";
        //$final = $modalidad_final;
        
        // CARGA DE PRECIO DEL KIT BASE YA ELEGIDO
        $query = "SELECT * FROM kits_combos WHERE id_kit = '$kit_base'";
        $consulta_kit = mysqli_query($con, $query) or die('Fallo en la busqueda del kit base -- Error: ' . mysqli_errno($con) ." - " . mysqli_error($con));
        $r_kit = mysqli_fetch_assoc($consulta_kit);
        $precio_base = $r_kit['costo'];
        // CARGA DE PRECIO DEL KIT BASE YA ELEGIDO
        
        /*
        // CARGA DE PRODUCTOS CORRESPONDIENTES AL KIT
        $query = "SELECT * FROM kits_combos_comp JOIN productos_nuevo ON producto = id_producto WHERE kit = '$kit_base'";
        $consulta_kit = mysqli_query($con, $query) or die('Fallo en la busqueda de los componentes del kit base -- Error: ' . mysqli_errno($con) ." - " . mysqli_error($con));
        while($r_kit = mysqli_fetch_assoc($consulta_kit))
        {
            $clave_componente = $r_kit["producto"];
            $unidades_componente = $cantidad_combo * $r_kit["unidades"];
            $nombre_componente = $r_kit["nombre"];
            $precio_componente = $r_kit["precio"];
            
            $producto = array("$nombre_componente","0","$unidades_componente");
            array_push($kit_final, $producto);
            
        }
        // CARGA DE PRODUCTOS CORRESPONDIENTES AL KIT
        */
        
        // AÑADIMOS EL VALOR DEL PRECIO BASE
        $producto = array("kit","$precio_base","$cantidad_combo");
        array_push($kit_final, $producto);
        // AÑADIMOS EL VALOR DEL PRECIO BASE
        
        $producto = array("DVR 4 CANALES","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("DISCO DURO 1 TB","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("CÁMARA 2 MPX LENTE FIJO","0","4");
        array_push($kit_final, $producto);
        
        $producto = array("TRANSCEPTORES HD","0","8");
        array_push($kit_final, $producto);
        
        $producto = array("FUENTE DE PODER 12V 10A-9CH","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("CABLE CAT 5","0",$cantidad_combo."00 METROS");
        array_push($kit_final, $producto);
        $producto = array("INSTALACIÓN, CONFIGURACIÓN, CAPACITACIÓN Y PUESTA A PUNTO","0","0");
        array_push($kit_final, $producto);
        
        //var_dump($kit_final);
        
        
        // LLAMADA AL GENERADOR DE PDF //
        include '../cotizadoc/genera_cotizacion_alarmas.php';
        // LLAMADA AL GENERADOR DE PDF //
        
    }
    if($kit == 2 )
    {
        //$tipo_kit = 4001;
        
        $cantidad_combo = 1;
        
        // LLAMADA A LA CONEXIÓN DE LA BD //
        include "../conexion/conexion.php";
        // LLAMADA A LA CONEXIÓN DE LA BD //
        
        $kit_base = "4001";
        //$final = $modalidad_final;
        
        // CARGA DE PRECIO DEL KIT BASE YA ELEGIDO
        $query = "SELECT * FROM kits_combos WHERE id_kit = '$kit_base'";
        $consulta_kit = mysqli_query($con, $query) or die('Fallo en la busqueda del kit base -- Error: ' . mysqli_errno($con) ." - " . mysqli_error($con));
        $r_kit = mysqli_fetch_assoc($consulta_kit);
        $precio_base = $r_kit['costo'];
        // CARGA DE PRECIO DEL KIT BASE YA ELEGIDO
        
        // CARGA DE PRODUCTOS CORRESPONDIENTES AL KIT
        $query = "SELECT * FROM kits_combos_comp JOIN productos_nuevo ON producto = id_producto WHERE kit = '$kit_base'";
        $consulta_kit = mysqli_query($con, $query) or die('Fallo en la busqueda de los componentes del kit base -- Error: ' . mysqli_errno($con) ." - " . mysqli_error($con));
        while($r_kit = mysqli_fetch_assoc($consulta_kit))
        {
            $clave_componente = $r_kit["producto"];
            $unidades_componente = $cantidad_combo * $r_kit["unidades"];
            $nombre_componente = $r_kit["nombre"];
            $precio_componente = $r_kit["precio"];
            
            $producto = array("$nombre_componente","0","$unidades_componente");
            array_push($kit_final, $producto);
            
        }
        // CARGA DE PRODUCTOS CORRESPONDIENTES AL KIT
        
        // AÑADIMOS EL VALOR DEL PRECIO BASE
        $producto = array("kit","$precio_base","$cantidad_combo");
        array_push($kit_final, $producto);
        // AÑADIMOS EL VALOR DEL PRECIO BASE
        
        $producto = array("INSTALACIÓN, CONFIGURACIÓN, CAPACITACIÓN Y PUESTA A PUNTO","0","$cantidad_combo");
        array_push($kit_final, $producto);
        
        //var_dump($kit_final);
        
        
        // LLAMADA AL GENERADOR DE PDF //
        include '../cotizadoc/genera_cotizacion_alarmas.php';
        // LLAMADA AL GENERADOR DE PDF //
        
    }
    if($kit == 3)
    {
        //$tipo_kit = 4002;
        
        //$tipo_kit = 4001;
        
        $cantidad_combo = 1;
        
        // LLAMADA A LA CONEXIÓN DE LA BD //
        include "../conexion/conexion.php";
        // LLAMADA A LA CONEXIÓN DE LA BD //
        
        $kit_base = "4002";
        //$final = $modalidad_final;
        
        // CARGA DE PRECIO DEL KIT BASE YA ELEGIDO
        $query = "SELECT * FROM kits_combos WHERE id_kit = '$kit_base'";
        $consulta_kit = mysqli_query($con, $query) or die('Fallo en la busqueda del kit base -- Error: ' . mysqli_errno($con) ." - " . mysqli_error($con));
        $r_kit = mysqli_fetch_assoc($consulta_kit);
        $precio_base = $r_kit['costo'];
        // CARGA DE PRECIO DEL KIT BASE YA ELEGIDO
        
        // CARGA DE PRODUCTOS CORRESPONDIENTES AL KIT
        $query = "SELECT * FROM kits_combos_comp JOIN productos_nuevo ON producto = id_producto WHERE kit = '$kit_base'";
        $consulta_kit = mysqli_query($con, $query) or die('Fallo en la busqueda de los componentes del kit base -- Error: ' . mysqli_errno($con) ." - " . mysqli_error($con));
        while($r_kit = mysqli_fetch_assoc($consulta_kit))
        {
            $clave_componente = $r_kit["producto"];
            $unidades_componente = $cantidad_combo * $r_kit["unidades"];
            $nombre_componente = $r_kit["nombre"];
            $precio_componente = $r_kit["precio"];
            
            $producto = array("$nombre_componente","0","$unidades_componente");
            array_push($kit_final, $producto);
            
        }
        // CARGA DE PRODUCTOS CORRESPONDIENTES AL KIT
        
        // AÑADIMOS EL VALOR DEL PRECIO BASE
        $producto = array("kit","$precio_base","$cantidad_combo");
        array_push($kit_final, $producto);
        // AÑADIMOS EL VALOR DEL PRECIO BASE
        
        $producto = array("INSTALACIÓN, CONFIGURACIÓN, CAPACITACIÓN Y PUESTA A PUNTO","0","0");
        array_push($kit_final, $producto);
        
        //var_dump($kit_final);
        
        
        // LLAMADA AL GENERADOR DE PDF //
        include '../cotizadoc/genera_cotizacion_alarmas.php';
        // LLAMADA AL GENERADOR DE PDF //
    }
    if($kit == 4 )
    {
        //$tipo_kit = 4001;
        
        $cantidad_combo = 1;
        
        // LLAMADA A LA CONEXIÓN DE LA BD //
        include "../conexion/conexion.php";
        // LLAMADA A LA CONEXIÓN DE LA BD //
        
        $kit_base = "4003";
        //$final = $modalidad_final;
        
        // CARGA DE PRECIO DEL KIT BASE YA ELEGIDO
        $query = "SELECT * FROM kits_combos WHERE id_kit = '$kit_base'";
        $consulta_kit = mysqli_query($con, $query) or die('Fallo en la busqueda del kit base -- Error: ' . mysqli_errno($con) ." - " . mysqli_error($con));
        $r_kit = mysqli_fetch_assoc($consulta_kit);
        $precio_base = $r_kit['costo'];
        // CARGA DE PRECIO DEL KIT BASE YA ELEGIDO
        
        /*
        // CARGA DE PRODUCTOS CORRESPONDIENTES AL KIT
        $query = "SELECT * FROM kits_combos_comp JOIN productos_nuevo ON producto = id_producto WHERE kit = '$kit_base'";
        $consulta_kit = mysqli_query($con, $query) or die('Fallo en la busqueda de los componentes del kit base -- Error: ' . mysqli_errno($con) ." - " . mysqli_error($con));
        while($r_kit = mysqli_fetch_assoc($consulta_kit))
        {
            $clave_componente = $r_kit["producto"];
            $unidades_componente = $cantidad_combo * $r_kit["unidades"];
            $nombre_componente = $r_kit["nombre"];
            $precio_componente = $r_kit["precio"];
            
            $producto = array("$nombre_componente","0","$unidades_componente");
            array_push($kit_final, $producto);
            
        }
        // CARGA DE PRODUCTOS CORRESPONDIENTES AL KIT
        */
        
        // AÑADIMOS EL VALOR DEL PRECIO BASE
        $producto = array("kit","$precio_base","$cantidad_combo");
        array_push($kit_final, $producto);
        // AÑADIMOS EL VALOR DEL PRECIO BASE
        
        $producto = array("DVR 4 CANALES","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("DISCO DURO 1 TB","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("CÁMARA 2 MPX LENTE FIJO","0","4");
        array_push($kit_final, $producto);
        
        $producto = array("TRANSCEPTORES HD","0","4");
        array_push($kit_final, $producto);
        
        $producto = array("FUENTE DE PODER 12V 10A-9CH","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("CABLE CAT 5","0",$cantidad_combo."00 METROS");
        array_push($kit_final, $producto);
        
        $producto = array("PANEL DE ALARMA CONEXIÓN ETHERNET, WIFI, LTE","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("SIM PARA COMUNICACIÓN GPRS","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("SIRENA EXTERIOR INALÁMBRICA","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("SENSOR DE MOVIMIENTO INALÁMBRICO","0","1");
        array_push($kit_final, $producto);
        
        $producto = array("SENSOR PUERTA/VENTANA INALÁMBRICO","0","2");
        array_push($kit_final, $producto);
        
        // SE AÑADE SERVICIO DE MONITOREO
        $producto = array("SERVICIO DE MONITOREO DE ALARMA 24 HRS", "0", "0"); 
        array_push($kit_final, $producto);
        
        $producto = array("INSTALACIÓN, CONFIGURACIÓN, CAPACITACIÓN Y PUESTA A PUNTO","0","0");
        array_push($kit_final, $producto);
        
        //var_dump($kit_final);
        
        
        // LLAMADA AL GENERADOR DE PDF //
        include '../cotizadoc/genera_cotizacion_alarmas.php';
        // LLAMADA AL GENERADOR DE PDF //
        
    }
    
    
    /*
    if($_POST['kit'] == 4)
    {
        $tipo_kit = 12;
        #CAMARAS
        $cantidad_pixeles = 2;
        $cantidad_cam_int = 4;
        $cantidad_cam_ext = 0;
        $cantidad_camaras = $cantidad_cam_int + $cantidad_cam_ext;
               
            
        #DIMENSIONES
        $cantidad_habitaciones = $_POST['cantidad_habitaciones'];
        $metros_dimension = $_POST['metros_dimension'];
        $cantidad_pisos = $_POST['cantidad_pisos'];
        
        if($_POST['instalacion'] == 1){
            
            $cantidad_canaletas = $_POST['cantidad_canaletas'];
        }
        
        
        #PROCESO
        
        //Su función es dar una cantidad provicional de pixeles para traer el kit de referencia correcto
        $cantidad_pixeles_prov = ($cantidad_pixeles >= 4) ? 4 : $cantidad_pixeles;
        
        //Funciones con datos
        $cantidad_cable = obtenMetrosCable($metros_dimension, $cantidad_habitaciones, $cantidad_pisos, $cantidad_camaras);
        $cantidad_tranceptores = obtenTranceptores($cantidad_camaras);
        
        $kit_final = []; #Array que tomará a todos los productos {'CANTIDAD', 'NOMBRE', 'COSTO UNITARIO', 'COSTO TOTAL'}
        
        //Obtenemos kit de referencia
        $consulta = "
            SELECT *
            FROM kits_camaras
            WHERE id_kit = $tipo_kit
            ";
            
        $resultado = $dbconnection->query($consulta);
        
        $datos_kit = $resultado->fetch_assoc();
        $id_kit = $datos_kit['id_kit']; #Guardamos id para consulta
        $megapixel = $datos_kit['megapixel'];
        $min_camaras = $datos_kit['min_camaras'];
        $cams = $datos_kit['cams'];
        $max_distancia_fuente = $datos_kit['max_distancia_fuente'];
        $id_fuente = $datos_kit['fuente'];
        $costo_kit = $datos_kit['costo']; #Para sumar el costo base
        $costo_kit= 1162.931;
        
        
        //Obtenemos DVR 
        $obsequio_dvr = 0;
        $cantidad_dvr_ant = 0;
        $nombre_dvr_ant = "";
        $costo_dvr_ant = 0;
        $repeticiones_dvr = 0;
        
        $arrayGrabador = obtenArrayGrabador($cantidad_camaras);
        foreach($arrayGrabador as $grabador){
            
            $id_grabador = $grabador[0];
            $cantidad = $grabador[1];
            $resultado = consultaProducto($dbconnection, $id_grabador);
            $datos_grabador = $resultado->fetch_assoc();
            $nombre_grabador = $datos_grabador['nombre'];
            $costo_grabador = $datos_grabador['precio'];
            
            if($obsequio_dvr == 1)
            {
                $aumento_dvr = 150;
            }
            else
            {
                $aumento_dvr = 0;
            }
            
            if($obsequio_dvr == 0)
            {
                $obsequio_dvr = 1;
            }
            
            if($nombre_dvr_ant == "")
            {
                $nombre_dvr_ant = $nombre_grabador;
                $costo_dvr_ant = $costo_grabador;
                $cantidad_dvr_ant = $cantidad;
                $referencia = array($cantidad_dvr_ant, $nombre_dvr_ant, $costo_dvr_ant, $costo_dvr_ant);
                $indice = count($kit_final);
                $repeticiones_dvr = 1;
                $kit_final[] = array($cantidad, $nombre_grabador, $costo_grabador, $costo_grabador);
                
            }
            else if($nombre_dvr_ant == $nombre_grabador)
            {
                
                $repeticiones_dvr++;
                $cantidad = $repeticiones_dvr;
                $nombre_grabador = $nombre_dvr_ant;
                $costo_grabador = $costo_dvr_ant + $costo_grabador;
                $costo_grabador = $costo_grabador + $aumento_dvr;
                
                $nombre_dvr_ant = $nombre_grabador;
                $costo_dvr_ant = $costo_grabador;
                $cantidad_dvr_ant = $cantidad;
                $referencia = array($cantidad_dvr_ant, $nombre_dvr_ant, $costo_dvr_ant, $costo_dvr_ant);
                
                
                $kit_final[($indice)] = array($cantidad, $nombre_grabador, $costo_grabador, $costo_grabador);
            }
            else
            {
                $costo_grabador = $costo_grabador + $aumento_dvr;
                $kit_final[] = array($cantidad, $nombre_grabador, $costo_grabador, $costo_grabador);
                
            }
            
            //$kit_final[] = array($cantidad, $nombre_grabador, $costo_grabador, $costo_grabador);
        }
        
        $obsequio = 0;
        $cantidad_ant = 0;
        $nombre_disco_ant = "";
        $costo_disco_ant = 0;
        $repeticiones = 0;
        //Obtenemos valores clave de disco
        $arrayDisco = obtenArrayDisco($cantidad_pixeles, 30,$cantidad_camaras);
        foreach($arrayDisco as $disco){ #Obtenemos tantos discos sean necesarios
            $id_disco = $disco[0];
            $cantidad = $disco[1];
            $resultado = consultaProducto($dbconnection, $id_disco);
            $datos_disco = $resultado->fetch_assoc();
            $nombre_disco = $datos_disco['nombre'];
            $costo_disco = $datos_disco['precio'];
            
            if($obsequio == 1)
            {
                $aumento = 50;
            }
            else
            {
                $aumento = 0;
            }
            
            if($obsequio == 0)
            {
                $obsequio = 1;
            }
            
            if($nombre_disco_ant == "")
            {
                $nombre_disco_ant = $nombre_disco;
                $costo_disco_ant = $costo_disco;
                $cantidad_ant = $cantidad;
                $referencia = array($cantidad_ant, $nombre_disco_ant, $costo_disco_ant, $costo_disco_ant);
                $indice = count($kit_final);
                $repeticiones = 1;
                $kit_final[] = array($cantidad, $nombre_disco, $costo_disco, $costo_disco);
                
            }
            else if($nombre_disco_ant == $nombre_disco)
            {
                
                $repeticiones++;
                $cantidad = $repeticiones;
                $nombre_disco = $nombre_disco_ant;
                $costo_disco = $costo_disco_ant + $costo_disco;
                $costo_disco = $costo_disco + $aumento;
                
                $nombre_disco_ant = $nombre_disco;
                $costo_disco_ant = $costo_disco;
                $cantidad_ant = $cantidad;
                $referencia = array($cantidad_ant, $nombre_disco_ant, $costo_disco_ant, $costo_disco_ant);
                
                
                $kit_final[($indice)] = array($cantidad, $nombre_disco, $costo_disco, $costo_disco);
            }
            else
            {
                $costo_disco = $costo_disco + $aumento;
                $kit_final[] = array($cantidad, $nombre_disco, $costo_disco, $costo_disco);
                
            }
            
            //$costo_disco = $costo_disco + $aumento;
            //$kit_final[] = array($cantidad, $nombre_disco, $costo_disco, $costo_disco);
        }
        
        $costo_camara_base = 0;
        
        //Obtenemos Camaras
        $arrayCamaras = obtenArrayCamaras($cantidad_pixeles, $cantidad_cam_ext, $cantidad_cam_int, $cantidad_cam_ext_mc, $cantidad_cam_int_mc);
        foreach($arrayCamaras as $camaras) {
            
            $id_camara = $camaras[0];
            $cantidad = $camaras[1];
            $tipo_camara = $camaras[2];
            
            $resultado = consultaProducto($dbconnection, $id_camara);
            $datos_camara = $resultado->fetch_assoc();
            $nombre_camara = $datos_camara['nombre']." ".$tipo_camara;
            $costo_camara = $datos_camara['precio'];
            
            if($costo_camara_base == 0)
            {
                $costo_camara_base = $costo_camara;
            }
            
            $costo_total_camara = $costo_camara * $cantidad;
            
            $kit_final[] = array($cantidad, $nombre_camara, $costo_camara, $costo_total_camara); 
        }
        
        //TRANSCEPTORES
        if($megapixel == 2)
        {
            $kit_final []= array($cantidad_tranceptores, "TRANSCEPTORES HD", NULL, NULL);
            
        }
        else
        {
            $kit_final []= array($cantidad_tranceptores, "TRANSCEPTORES 4K", NULL, NULL);
            
        }
        
        //Obtenemos informacion de fuente
        if($megapixel > 2){
            $arrayFuente = obtenArrayFuente($megapixel, $cantidad_cable, $max_distancia_fuente, $id_fuente);
        } elseif($cantidad_camaras < 4) {
            $arrayFuente = obtenArrayFuente($megapixel, $cantidad_cable, $max_distancia_fuente, $id_fuente);
        } else {
            $arrayFuente = obtenArrayFuente($megapixel, $cantidad_cable, $max_distancia_fuente);
        }
        
        $id_fuente = $arrayFuente[0][0];
        $cantidad_fuente = $arrayFuente[0][1];
        $resultado = consultaProducto($dbconnection, $id_fuente);
        $datos_fuente = $resultado->fetch_assoc();
        $nombre_fuente = $datos_fuente['nombre'];
        $costo_fuente = $datos_fuente['precio'];
        
        if($megapixel > 2)
        {
            $costo_total_fuente = ($cantidad_fuente - 1) * $costo_fuente;
        }
        //$costo_total_fuente = ($cantidad_fuente - 1) * $costo_fuente;
        
        if($cantidad_fuente == 0)
        {
            $cantidad_fuente = 1;
        }
        else
        {
            $costo_total_fuente = ($cantidad_fuente - 1) * $costo_fuente;
        }
        $kit_final[] = array($cantidad_fuente, $nombre_fuente, $costo_fuente, $costo_total_fuente); 
        
        
        //Obtenemos valores clave de cable
        $arrayCable= obtenArrayCable($cantidad_cable, $cantidad_pixeles);
        $id_cable = $arrayCable[0];
        $cant_uni_cable = $arrayCable[1];
        
        //Obtenemos datos de cable especifico
        $resultado = consultaProducto($dbconnection, $id_cable);
        $datos_cable = $resultado->fetch_assoc();
        $nombre_cable = $datos_cable['nombre'];
        $costo_cable = $datos_cable['precio'];
        
        //Realizamos operaciones necesarias
        $cantidad_cable_total = $cant_uni_cable * 100;
        $costo_cable_total = (($cantidad_cable_total - 100)/100) * $costo_cable; #Se restan 100 por los metros base incluidos
        if($costo_cable_total < 0)
        {
            $costo_cable_total = 0;
        }
        
        $extras[] = array($cantidad_cable_total." METROS", $nombre_cable, $costo_cable, $costo_cable_total);
        
        //Agregamos los productos de alarmas 
        //Obtenemos datos de PANEL DE ALARMA CONEXIÓN ETHERNET, WIFI, LTE"
        $resultado = consultaProducto($dbconnection, 30);
        $datos_panel = $resultado->fetch_assoc();
        $nombre_panel = $datos_panel['nombre'];
    
        $extras[] = array(1,$nombre_panel, 0, 0);
        
        //Obtenemos datos de SIM PARA COMUNICACIÓN GPRS
        $resultado = consultaProducto($dbconnection, 31);
        $datos_sim = $resultado->fetch_assoc();
        $nombre_sim = $datos_sim['nombre'];
    
        $extras[] = array(1, $nombre_sim, 0, 0);
        
        //Obtenemos datos de SIRENA PARA EXTERIOR INALÁMBRICA
        $resultado = consultaProducto($dbconnection, 2211);
        $datos_SIRENA = $resultado->fetch_assoc();
        $nombre_SIRENA = $datos_SIRENA['nombre'];
    
        $extras[] = array(1, $nombre_SIRENA, 0, 0);
        
        //Obtenemos datos de DETECTOR DE MOVIMIENTO INALÁMBRICO
        $resultado = consultaProducto($dbconnection, 2201);
        $datos_DETECTOR = $resultado->fetch_assoc();
        $nombre_DETECTOR = $datos_DETECTOR['nombre'];
    
        $extras[] = array(1, $nombre_DETECTOR, 0, 0);
        
        //Obtenemos datos de SENSOR DE PUERTA INALÁMBRICO
        $resultado = consultaProducto($dbconnection, 2206);
        $datos_SENSOR = $resultado->fetch_assoc();
        $nombre_SENSOR = $datos_SENSOR['nombre'];
    
        $extras[] = array(2, $nombre_SENSOR, 0, 0);
        
        //Construcción cotización 
        $reduce_camaras = ($cantidad_cam_int + $cantidad_cam_ext) - $cams;
        $suma_microfonos = ($cantidad_cam_int_mc + $cantidad_cam_ext_mc);
        if($reduce_camaras <= 0 && $suma_microfonos > 0)
        {
            $reduce_camaras = 0;
            //$arreglo = 0;
            $arreglo = ($cams * 10);
            $costo_kit = $arreglo + $costo_kit - ($cams * $costo_camara_base);
            $extras[] = array(1, 'kit inicial', $costo_kit, $costo_kit); 
            
        }
        else
        {
            $costo_kit = $costo_kit - ($cams * $costo_camara_base);
            $extras[] = array(1, 'kit inicial', $costo_kit, $costo_kit); 
            
        }
        
        // SE AÑADE SERVICIO DE MONITOREO
        $extras[] = array(0, 'SERVICIO DE MONITOREO DE ALARMA 24 HRS', 0, 0); 
        
        // LEYENDA DE INSTALACIÓN
        $extras[] = array(0, 'INSTALACIÓN, CONFIGURACIÓN, CAPACITACIÓN Y PUESTA A PUNTO', 0, 0); 
       
        // LEYENDA DE INSTALACIÓN
        $kit_final = array_merge($kit_final, $extras);
        
        /*
        //TESTER
        foreach($kit_final as $componente){
            
            $cantidad = $componente[0];
            $nombre = $componente[1];
            $costo_uni = "$".number_format($componente[2],2,'.',',');
            $costo_total = "$".number_format($componente[3],2,'.',',');
            
            echo $cantidad." ".$nombre." ".$costo_uni." ".$costo_total."<br>";
        }
        */
        
        // LLAMADA AL GENERADOR DE PDF //
        //include '../cotizadoc/genera_cotizacion_pyme.php';
        // LLAMADA AL GENERADOR DE PDF //
    //}
    
?>