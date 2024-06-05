<?php

    function consultaKitReferencia($dbconnection, $cantidad_pixeles_prov, $cantidad_camaras){
        
        $consulta = "
        SELECT *
        FROM kits_camaras
        WHERE megapixel = '$cantidad_pixeles_prov' AND (max_camaras >= '$cantidad_camaras' AND min_camaras <= '$cantidad_camaras')
        ";
        
        return $dbconnection->query($consulta);
    }
    
    function consultaProductosKit($dbconnection, $id_kit){
        
        $consulta = "
        SELECT productos_nuevo.*
        FROM componentes_kits
        JOIN productos_nuevo ON componentes_kits.id_producto = productos_nuevo.id_producto
        WHERE id_kit = '$id_kit'
        ";
        
        return $dbconnection->query($consulta);
    }
    
    function consultaProducto($dbconnection, $id_producto){
        
        $consulta = "
        SELECT *
        FROM productos_nuevo
        WHERE id_producto = '$id_producto'
        ";
        
        return $dbconnection->query($consulta);
    }


?>