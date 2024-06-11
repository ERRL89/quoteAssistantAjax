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
    
?>