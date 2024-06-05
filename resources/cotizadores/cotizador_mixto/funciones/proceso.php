<?php

   function obtenMetrosCable ($metros_dimension, $cantidad_habitaciones, $cantidad_pisos, $cantidad_camaras){

        $metros_habitacion = $metros_dimension / $cantidad_habitaciones; //Metros cuadrados por habitacion
        $metros_individuales = sqrt($metros_habitacion); //Sacar perimetro de una pared
        $altura = $cantidad_pisos * 3; //2 metros por cada piso de la casa

        if($cantidad_pisos > 1){
            
            //Suma de 4 paredes por cuarto más la altura
            $cantidad_cable1 = round((($metros_individuales * 4) * $cantidad_habitaciones));  
            $adicional_piso1 = (($cantidad_cable1 * 0.75) * ($cantidad_pisos - 1)); //Se obtiene el area por cada piso
            $cantidad_cable1 += ($adicional_piso1 + $altura); //Al final se suma la altura
        
        } else {
            
             $cantidad_cable1 = round((($metros_individuales * 4) * $cantidad_habitaciones) + $altura);  
        }
        
        //25 metros por cada cámara
        $cantidad_cable2 = (25 * $cantidad_camaras) + $altura; 
        
        //Se toma la operación que tenga el resultado más grande
        if($cantidad_cable1 > $cantidad_cable2){
            return $cantidad_cable1;
        } else {
            return $cantidad_cable2;
        }
        
    }

    function obtenTranceptores($cantidad_camaras) {

        return $cantidad_camaras * 2;

    }
    
    function obtenArrayFuente($megapixel, $cantidad_cable, $max_distancia_fuente, $id_fuente = NULL){
  
        $array_fuentes = [];
        $cable_restante = $cantidad_cable;
        $contador_fuentes = 0;

        if($megapixel > 2){
            $cams_restante = $GLOBALS['cantidad_camaras'];
            while($cams_restante > 0){
                
                $cams_restante = $cams_restante - 8;
                
                //$cable_restante -= $max_distancia_fuente;
                $contador_fuentes++;
            }
            
            if($id_fuente != NULL){
                $array_fuentes[] = array($id_fuente, $contador_fuentes);
            }
            
                
        } else {
            
            if($cantidad_cable <= 120){
                $id_fuente = 13; #FUENTE DE PODER 12V 10A-9CH
                $array_fuentes[] = array($id_fuente, 1);
            } elseif($cantidad_cable <= 150){
                $id_fuente = 15; #FUENTE DE PODER 12V 20A-9CH
                $array_fuentes[] = array($id_fuente, 1);
            } else {
                
                $id_fuente = 14; #FUENTE DE PODER 12V 13A-9CH
                $cams_restante = $GLOBALS['cantidad_camaras'];
                while($cams_restante > 0){
                    
                    //$cable_restante -= $max_distancia_fuente;
                    
                    $cams_restante = $cams_restante - 8;
                    $contador_fuentes++;
                }
                
                $array_fuentes[] = array($id_fuente, $contador_fuentes);
                
            }
            
        }
        
        return $array_fuentes;
        
    }
    
    function obtenArrayCamaras($megapixel, $cantidad_cam_ext, $cantidad_cam_int, $cantidad_cam_ext_mc, $cantidad_cam_int_mc){
        
        $array_camaras = [];
        
        switch($megapixel){
            
            case 2: #2MPX 
                
                if($cantidad_cam_ext > 0){
                    $array_camaras[] = array(1, $cantidad_cam_ext, "BULLET"); 
                }
                if($cantidad_cam_int > 0){
                    $array_camaras[] = array(1, $cantidad_cam_int, "DOMO"); 
                }
                if($cantidad_cam_ext_mc > 0){
                    $array_camaras[] = array(27, $cantidad_cam_ext_mc, "BULLET"); 
                }
                if($cantidad_cam_int_mc > 0){
                    $array_camaras[] = array(27, $cantidad_cam_int_mc, "DOMO"); 
                }
                
            break;
            
            case 4: #4MPX 
                
                if($cantidad_cam_ext > 0){
                    $array_camaras[] = array(2, $cantidad_cam_ext, "BULLET"); 
                }  
                if($cantidad_cam_int > 0){
                    $array_camaras[] = array(2, $cantidad_cam_int, "DOMO"); 
                
                }    
                if($cantidad_cam_ext_mc > 0){
                    $array_camaras[] = array(25, $cantidad_cam_ext_mc, "BULLET"); 
                }    
                if($cantidad_cam_int_mc > 0){
                    $array_camaras[] = array(25, $cantidad_cam_int_mc, "DOMO"); 
                }
                
            break;
            
            case 5: #5MPX 
                
                if($cantidad_cam_ext > 0){
                    $array_camaras[] = array(3, $cantidad_cam_ext, "BULLET"); 
                }
                if($cantidad_cam_int > 0){
                    $array_camaras[] = array(3, $cantidad_cam_int, "DOMO"); 
                }    
                if($cantidad_cam_ext_mc > 0){
                    $array_camaras[] = array(28, $cantidad_cam_ext_mc, "BULLET"); 
                }    
                if($cantidad_cam_int_mc > 0){
                    $array_camaras[] = array(28, $cantidad_cam_int_mc, "DOMO"); 
                }
                
            break;
        }
        
        return $array_camaras;
        
    }
    
    function obtenArrayGrabador($cantidad_camaras){
    
        $array_grabadores = [];
        
        while($cantidad_camaras > 0){
            
            if($cantidad_camaras <= 4){
                $id_grabador = 4;
                $cantidad_camaras -= 4;
            } elseif ($cantidad_camaras > 4 && $cantidad_camaras <= 8){
                $id_grabador = 5;
                $cantidad_camaras -= 8;
            } elseif ($cantidad_camaras > 8 && $cantidad_camaras <= 16){
                $id_grabador = 6;
                $cantidad_camaras -= 16;
            } elseif ($cantidad_camaras > 16 && $cantidad_camaras <= 32){
                $id_grabador = 7;
                $cantidad_camaras -= 32;
            }
            
            $array_grabadores[] = array($id_grabador, 1) ;
        }
        
        return $array_grabadores;
    
    }
    
    
    function obtenArrayDisco($cantidad_pixeles, $dias_grabacion,$cantidad_camaras){
        
        switch($cantidad_pixeles){
            
            case 2: $tera_dia = 0.008; break;
            case 4: $tera_dia = 0.014; break;
            case 5: $tera_dia = 0.020; break;
            
        }
        
        $total_teras = ceil(($dias_grabacion * $tera_dia) * $cantidad_camaras);
        
        //echo "$total_teras";
        
        $array_discos = [];
        
        
        while($total_teras > 0){
            if($total_teras <= 1){ #DISCO DURO 1TB
                $id_disco =  8;
                $total_teras -= 1;
            } elseif ($total_teras > 1 && $total_teras <= 2){ #DISCO DURO 2TB
                $id_disco = 9;
                $total_teras -= 2;
            } elseif ($total_teras > 2 && $total_teras <= 3){ #DISCO DURO 3TB
                $id_disco = 10;
                $total_teras -= 3;
            } elseif ($total_teras > 3){ #DISCO DURO 4TB
                $id_disco = 11;
                $total_teras -= 4;
            }
            
            $array_discos[] = array($id_disco, 1);
        }
        
        return $array_discos;
        
    }
    
    function obtenArrayCable($cantidad_cable, $cantidad_pixeles){
        
        if($cantidad_pixeles <=2){
            
            if($cantidad_cable <= 60){
                $id_cable = 16; #CAT5
            } elseif ($cantidad_cable <= 100) {
                $id_cable = 16; #CAT5 100% COBRE (FINAL - #CAT5)
            } else {
                $id_cable = 16; #CAT6 100% COBRE (FINAL - #CAT5)
            }
            
        } else {
            
            if($cantidad_cable <= 80){
                $id_cable = 17; #CAT5 100% COBRE
            } else {
                $id_cable = 17; #CAT6 100% COBRE (FINAL #CAT5 100% COBRE)
            }
            
        }
        $cantidad_cable_total = $cantidad_cable;
        //echo "$cantidad_cable_total";
        $cantidad_cable = ($cantidad_cable/100);
        $cantidad_cable_entero = floor($cantidad_cable);
        $cantidad_cable_entero = ($cantidad_cable_entero * 100) * 1.25;
        if($cantidad_cable_total < $cantidad_cable_entero)
        {
            $cant_uni_cable = floor($cantidad_cable);
        }
        else
        {
            $cant_uni_cable = ceil($cantidad_cable);
        }
        //echo "$cantidad_cable_total";
        return array($id_cable, $cant_uni_cable);
        
    }
    
    
 

    
   



?>