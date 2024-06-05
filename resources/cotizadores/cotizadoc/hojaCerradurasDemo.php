<?php

$condicion_pago = "ANUAL";
$condicion_amarillo = "Servicio";


// FUNCIÓN PARA COMENZAR UNA NUEVA PÁGINA CON EL TEMPLATE GENERADO
$pdf->AddPage('P', 'LETTER');
$pdf->useTemplate($tpl);
// TERMINA FUNCIÓN

// POSICIÓN DE PRIMERAS COORDENADAS (LAS COORDENADAS SE AJUSTAN A LOS MILIMETROS DE LA HOJA)
//Limite de hoja 0-216 (ancho) primer valor 0 representa borde
$pdf->SetY(43);
$pdf->SetX(15);
// SE ELIGE LA FUENTE
$pdf->SetFont('helvetica', '', 10.5);
// WRITEHTMLCELL permite crear una celda en la que podemos insertar código HTML y de esta forma hacer un texto más dinámico
//$pdf->writeHTMLCell(W, H, 'X', 'Y', $html, border, line, fill, reseth, 'align', autopadding);

/*$html = 'MARGEN INICIAL (1.5cm) 4.3cm de alto';
            $pdf->writeHTMLCell(186, 5, '', '', $html, 1, 0, 0, TRUE, 'J', TRUE);*/

// REAJUSTE DE COORDENADAS (DESPLAZAMIENTO ENTRE LA HOJA)
$pdf->SetY(50);
$pdf->SetX(15);
// SE PUEDE CAMBIAR LA FUENTE, Y TAMAÑO VOLVIENDO A USAR EL COMANDO SETFONT
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(186, 10, 'COTIZACIÓN', 0, 0, 'R');

////// SECCIÓN RECTANGULO NARANJA 01 //////
$pdf->SetY(65);
$pdf->SetX(121);
$pdf->SetFont('helvetica', 'B', 12);
// DEFINE COLOR DE RELLENO
$pdf->SetFillColor(253, 107, 13);
// DEFINE COLOR DE RELLENO

// DEFINE COLOR DE TEXTO
$pdf->SetTextColor(255, 255, 255);
// DEFINE COLOR DE TEXTO

// CELL(X,Y,texto,borde,ln,alineacion,relleno(booleano))
$pdf->Cell(80, 6, 'NÚMERO DE COTIZACIÓN', 0, 0, 'R', TRUE);
////// SECCIÓN RECTANGULO NARANJA 01 //////

////// SECCIÓN RECTANGULO AMARILLO 01 //////
$pdf->SetY(71);
$pdf->SetX(121);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(80, 6, "$folio_cotizacion-2", 0, 0, 'R', TRUE);
////// SECCIÓN RECTANGULO AMARILLO 01 //////

////// SECCIÓN RECTANGULO NARANJA 02 //////
$pdf->SetY(77);
$pdf->SetX(121);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(253, 107, 13);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(80, 6, 'CONDICIONES DE PAGO', 0, 0, 'R', TRUE);
////// SECCIÓN RECTANGULO NARANJA 02 //////

////// SECCIÓN RECTANGULO AMARILLO 02 //////
$pdf->SetY(83);
$pdf->SetX(121);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(80, 6, "$condicion_pago", 0, 0, 'R', TRUE);
////// SECCIÓN RECTANGULO AMARILLO 02 //////

////// SECCIÓN RECTANGULO NARANJA (FECHA) //////
$pdf->SetY(65);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(253, 107, 13);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 6, 'FECHA', 0, 0, 'C', TRUE);
////// SECCIÓN RECTANGULO NARANJA (FECHA) //////

////// SECCIÓN RECTANGULO FECHA //////
$pdf->SetY(65);
$pdf->SetX(57);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(60, 6, $fecha_actual, 0, 0, 'L');
////// SECCIÓN RECTANGULO FECHA //////

////// SECCIÓN RECTANGULO AMARILLO (nombre de proyecto) //////
$pdf->SetY(71);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(90, 6, "$direccion", 0, 0, 'L', TRUE);
////// SECCIÓN RECTANGULO AMARILLO (nombre de proyecto) //////

////// SECCIÓN RECTANGULO AMARILLO (nombre cliente) //////
$pdf->SetY(77);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(90, 6, "$nombre_cliente", 0, 0, 'L', TRUE);
////// SECCIÓN RECTANGULO AMARILLO (nombre cliente) //////

////// SECCIÓN RECTANGULO AMARILLO (PRODUCTO/SERVICIO) //////
$pdf->SetY(83);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(90, 6, "$cotizacion_producto", 0, 0, 'L', TRUE);
////// SECCIÓN RECTANGULO AMARILLO (PRODUCTO/SERVICIO) //////

////// INICIA ZONA DE LISTA DE ARTICULOS  //////

////// CABECERAS DE LA TABLA (MARCO REFERENCIA - QUITAR) //////
$pdf->SetY(95);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(186, 6, '', 0, 0, 'L');
////// CABECERAS DE LA TABLA (MARCO REFERENCIA - QUITAR) //////

////// CABECERAS DE LA TABLA //////
$pdf->SetY(95);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(30, 6, 'Cant.', 0, 0, 'C');

/*$pdf->SetY(95);
            $pdf->SetX(45);
            $pdf->SetFont('helvetica','B',12);
            $pdf->Cell(30, 6, 'Item no.', 0, 0, 'C');*/

$pdf->SetY(95);
$pdf->SetX(45);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(95, 6, 'Descripción del producto.', 0, 0, 'C');

$pdf->SetY(95);
$pdf->SetX(140);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(30, 6, 'P. Unitario.', 0, 0, 'C');

$pdf->SetY(95);
$pdf->SetX(170);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(31, 6, 'Importe.', 0, 0, 'C');
////// CABECERAS DE LA TABLA //////

////// BARRA AMARILLA //////
$pdf->SetY(101);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(30, 6, "$condicion_amarillo", 0, 0, 'C', TRUE);
////// BARRA AMARILLA //////

////// BARRA GRIS //////
$pdf->SetY(101);
$pdf->SetX(45);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(191, 191, 191);
$pdf->Cell(156, 6, '', 0, 0, 'C', TRUE);
////// BARRA GRIS //////

// INFORMACIÓN PARA PRUEBAS //
$conceptos = 2;
$altura_concepto = 107;
$altura_articulo = 107;
$altura_descripcion = 119;
// INFORMACIÓN PARA PRUEBAS //

$tam_celda = 30;
$tam_letra = 8;
$tam_cantidad = 10;
$limite_iteraciones = 16;
$tam_leyenda = 30;

///////// COMIENZA CONTENIDO /////////

        $nombre_complemento = "POLIZA DE MANTENIMIENTO\nIncluye:\n1 Visita de mantenimiento cada 6 meses";
        
        $contador_iteraciones++;
        ////// CANTIDAD //////
        $pdf->SetY($altura_concepto);
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', '', $tam_cantidad);
        $pdf->Cell(30, $tam_leyenda, "$cantidad_complemento_txt", 0, 0, "C", $llenado);
        ////// CANTIDAD //////
    
        ////// DESCRIPCIÓN (ARTÍCULO) //////
        $pdf->SetY($altura_concepto);
        $pdf->SetX(45);
        $pdf->SetFont("helvetica", "B", $tam_letra);
        $pdf->SetDrawColor(191, 191, 191);
        $pdf->MultiCell(95, $tam_leyenda, "$nombre_complemento", 0, "C", $llenado, 0, '', '', true, 0, false, true, $tam_leyenda, 'M');
        ////// DESCRIPCIÓN (ARTÍCULO) //////
    
        ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
        // $pdf->SetY($altura_descripcion);
        // $pdf->SetX(45);
        // $pdf->SetFont('helvetica','B',8);
        // $pdf->MultiCell(95, 28, '$descripcion_complemento', 0, 'L', $llenado,0,'','',true,0,false,true,28,'M');
        ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
    
        ////// PRECIO UNITARIO //////
        $pdf->SetY($altura_concepto);
        $pdf->SetX(140);
        $pdf->SetFont('helvetica', 'B', $tam_letra);
        //$pdf->MultiCell(30, $tam_leyenda, "", 0, 'C', $llenado, 0, '', '', true, 0, false, true, $tam_leyenda, 'M');
        //$pdf->MultiCell(30, 14, "$precio_complemento_txt", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 14, 'M');
        ////// PRECIO UNITARIO //////
    
        ////// PRECIO UNITARIO //////
        $pdf->SetY($altura_concepto);
        $pdf->SetX(170);
        $pdf->SetFont('helvetica', 'B', $tam_letra);
        //$pdf->MultiCell(31, $tam_leyenda, "", 0, 'C', $llenado, 0, '', '', true, 0, false, true, $tam_leyenda, 'M');
        //$pdf->MultiCell(31, 14, "$importe_complemento_txt", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 14, 'M');
        ////// PRECIO UNITARIO //////
        
        $altura_concepto = $altura_concepto + $tam_leyenda;
        $altura_descripcion = $altura_concepto + $tam_leyenda;
        $subtotal_complemento = $subtotal_complemento + $importe_complemento;



$precio_final = ($altura_subtotal) - 102;

////// PRECIO UNITARIO //////
$pdf->SetY(102);
$pdf->SetX(140);
$pdf->SetFont('helvetica', 'B', 12);
//$pdf->MultiCell(30, 6, "", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(30, $precio_final, "$subtotal", 0, 'C', $llenado, 0, '', '', true, 0, false, true, $precio_final, 'M');
////// PRECIO UNITARIO //////

////// PRECIO UNITARIO //////
$pdf->SetY(102);
$pdf->SetX(170);
$pdf->SetFont('helvetica', 'B', 12);
//$pdf->MultiCell(31, 6, "", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(31, $precio_final, "$subtotal", 0, 'C', $llenado, 0, '', '', true, 0, false, true, $precio_final, 'M');
////// PRECIO UNITARIO //////



////// BARRA GRIS FOOTER //////
$pdf->SetY($altura_footer);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(191, 191, 191);
$pdf->Cell(186, 6, "", 0, 0, 'C', TRUE);
////// BARRA GRIS FOOTER //////

// SUBTOTAL (texto) //
$pdf->SetY($altura_subtotal);
$pdf->SetX(140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(30, 6, "SUBTOTAL", 0, 0, 'C');
// SUBTOTAL (texto) //

// SUBTOTAL (cantidad) //
$pdf->SetY($altura_subtotal);
$pdf->SetX(170);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(31, 6, $subtotal, 0, 0, 'C');
// SUBTOTAL (cantidad) //

// IVA (texto) //
$pdf->SetY($altura_iva);
$pdf->SetX(140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(30, 6, "IVA", 0, 0, 'C', TRUE);
// IVA (texto) //

// IVA (cantidad) //
$pdf->SetY($altura_iva);
$pdf->SetX(170);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(31, 6, $iva, 0, 0, 'C', TRUE);
// IVA (cantidad) //

// TOTAL (texto) //
$pdf->SetY($altura_total);
$pdf->SetX(140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(30, 6, 'TOTAL', 0, 0, 'C', TRUE);
// TOTAL (texto) //

// TOTAL (cantidad) //
$pdf->SetY($altura_total);
$pdf->SetX(170);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(31, 6, $total, 0, 0, 'C', TRUE);
// TOTAL (cantidad) //

///////// TERMINA FOOTER /////////




$control_extras = 0;
$llenado = false;
$fecha_actual = date('Y-m-d');


$contador_iteraciones = 0;
