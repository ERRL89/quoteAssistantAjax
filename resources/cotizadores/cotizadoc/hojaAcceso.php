<?php

$contador_iteraciones  = 0;
$subtotal_complemento = 0;
$importe_producto = 0;
$indice_final = count($kit_final);
if($indice_final > 15)
{
    $tam_celda = 5;
    $tam_letra = 7.2;
    $tam_cantidad = 8;
    $limite_iteraciones = 30;
    $tam_leyenda = 5;
}
else
{
    $tam_celda = 11;
    $tam_letra = 8;
    $tam_cantidad = 10;
    $limite_iteraciones = 16;
    $tam_leyenda = 14;
}
foreach($kit_final as $componente) {
    ///////////// INICIAN COMPLEMENTOS ///////////////
    
    $cantidad_complemento = $componente[0];
    if($cantidad_complemento == 0 || $cantidad_complemento == NULL){
        $cantidad_complemento_txt = "-";
    } else {
         $cantidad_complemento_txt = $cantidad_complemento;
    }
    $nombre_complemento = $componente[1];
    $precio_complemento = $componente[2];
    if($precio_complemento == 0 || $precio_complemento == NULL){
        $precio_complemento_txt = "-";
    } else {
        $precio_complemento_txt = number_format($precio_complemento,2,'.',',');
    }
    $importe_complemento = $componente[3];
    if($importe_complemento == 0 || $importe_complemento == NULL){
        $importe_complemento_txt = "-";
    } else {
        $importe_complemento_txt = number_format($importe_complemento,2,'.',',');
    }
    
    if($nombre_complemento == "kit inicial")
    {
        $cantidad_complemento_txt = "";
        $nombre_complemento = "";
        $precio_complemento_txt = "";
        $importe_complemento_txt = "";
        $altura_concepto = $altura_concepto - $tam_celda;
        $altura_descripcion = $altura_concepto - $tam_celda;
    }
    
    if($nombre_complemento == "INSTALACIÓN, CONFIGURACIÓN, CAPACITACIÓN Y PUESTA A PUNTO")
    {
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
        $pdf->MultiCell(30, $tam_leyenda, "", 0, 'C', $llenado, 0, '', '', true, 0, false, true, $tam_leyenda, 'M');
        //$pdf->MultiCell(30, 14, "$precio_complemento_txt", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 14, 'M');
        ////// PRECIO UNITARIO //////
    
        ////// PRECIO UNITARIO //////
        $pdf->SetY($altura_concepto);
        $pdf->SetX(170);
        $pdf->SetFont('helvetica', 'B', $tam_letra);
        $pdf->MultiCell(31, $tam_leyenda, "", 0, 'C', $llenado, 0, '', '', true, 0, false, true, $tam_leyenda, 'M');
        //$pdf->MultiCell(31, 14, "$importe_complemento_txt", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 14, 'M');
        ////// PRECIO UNITARIO //////
        
        $altura_concepto = $altura_concepto + $tam_leyenda;
        $altura_descripcion = $altura_concepto + $tam_leyenda;
        $subtotal_complemento = $subtotal_complemento + $importe_complemento;
    }
    else
    {
        $contador_iteraciones++;
        ////// CANTIDAD //////
        $pdf->SetY($altura_concepto);
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', '', $tam_cantidad);
        $pdf->Cell(30, $tam_celda, "$cantidad_complemento_txt", 0, 0, "C", $llenado);
        ////// CANTIDAD //////
    
        ////// DESCRIPCIÓN (ARTÍCULO) //////
        $pdf->SetY($altura_concepto);
        $pdf->SetX(45);
        $pdf->SetFont("helvetica", "B", $tam_letra);
        $pdf->SetDrawColor(191, 191, 191);
        $pdf->MultiCell(95, $tam_celda, "$nombre_complemento", 0, "C", $llenado, 0, '', '', true, 0, false, true, $tam_celda, 'M');
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
        $pdf->MultiCell(30, $tam_celda, "", 0, 'C', $llenado, 0, '', '', true, 0, false, true, $tam_celda, 'M');
        //$pdf->MultiCell(30, 6, "$precio_complemento_txt", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 6, 'M');
        ////// PRECIO UNITARIO //////
    
        ////// PRECIO UNITARIO //////
        $pdf->SetY($altura_concepto);
        $pdf->SetX(170);
        $pdf->SetFont('helvetica', 'B', $tam_letra);
        $pdf->MultiCell(31, $tam_celda, "", 0, 'C', $llenado, 0, '', '', true, 0, false, true, $tam_celda, 'M');
        //$pdf->MultiCell(31, 6, "$importe_complemento_txt", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 6, 'M');
        ////// PRECIO UNITARIO //////
        
        $altura_concepto = $altura_concepto + $tam_celda;
        $altura_descripcion = $altura_concepto + $tam_celda;
        $subtotal_complemento = $subtotal_complemento + $importe_complemento;
    }
    
    if ($llenado == true) {
        $llenado = false;
    } else {
        $llenado = false;
    }

    if ($contador_iteraciones == $limite_iteraciones) {
      

        ///////// COMIENZA CONTENIDO /////////

        $control_extras = 0;
        $llenado = false;
        $fecha_actual = date('Y-m-d');

        $contador_iteraciones = 0;
    }
}
///////// INICIA FOOTER /////////

$altura_footer = $altura_concepto;
$altura_subtotal = $altura_footer;
$altura_iva = $altura_subtotal + 6;
$altura_total = $altura_iva + 6;

$subtotal = $importe_producto + $subtotal_complemento;

switch($final){

    case 2:
        $subtotal = $subtotal * 11;
        break;
        
    case 3:
        $subtotal_mensual = $subtotal;
        $subtotal = $subtotal * 21;
        break;
        
}
$iva = $subtotal * 0.16;
$total = $subtotal + $iva;

$subtotal = number_format($subtotal, 2, '.', ',');
if (is_null($subtotal)) {
    $subtotal = "$ 0.00";
} else {
    $subtotal = "$ $subtotal";
}

$iva = number_format($iva, 2, '.', ',');
if (is_null($iva)) {
    $iva = "$ 0.00";
} else {
    $iva = "$ $iva";
}

$total = number_format($total, 2, '.', ',');
if (is_null($total)) {
    $total = "$ 0.00";
} else {
    $total = "$ $total";
}

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

//////// TERMINOS Y DATOS DEL ASESOR /////////

////// BARRA NARANJA TYC //////
$pdf->SetY(215);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(253, 107, 13);
$pdf->Cell(90, 6, '', 0, 0, 'C', TRUE);
////// BARRA NARANJA TYC //////

////// TITULO TYC //////
$pdf->SetY(215);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(90, 6, 'TERMINOS Y CONDICIONES', 0, 0, 'C');
////// TITULO TYC //////
/*
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
';*/

////// TYC //////
$pdf->SetY(221);
$pdf->SetX(15);
$pdf->SetFont('helvetica', '', 6);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(90, 28, $texto_term, 0, 'J', 0, 0, '', '', true, 0, false, true, 28, 'M');
////// TYC //////

////// SECCIÓN RECTANGULO CERRADOR //////
$pdf->SetY(221);
$pdf->SetX(140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(61, 6, "$nombre_usuario", 0, 0, 'R', TRUE);
////// SECCIÓN RECTANGULO CERRADOR //////

////// SECCIÓN RECTANGULO CERRADOR //////
$pdf->SetY(227);
$pdf->SetX(140);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(61, 6, 'Alianzas comerciales', 0, 0, 'R');
////// SECCIÓN RECTANGULO CERRADOR //////

////// SECCIÓN RECTANGULO AMARILLO CORREO //////
$pdf->SetY(233);
$pdf->SetX(140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(61, 6, "$correo_usuario", 0, 0, 'R', TRUE);
////// SECCIÓN RECTANGULO AMARILLO CORREO //////

////// SECCIÓN RECTANGULO TELEFONO //////
$pdf->SetY(239);
$pdf->SetX(140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(61, 6, 'Tel. 55-5367-4298 / 55-6821-5744', 0, 0, 'R');
////// SECCIÓN RECTANGULO TELEFONO //////

//////// TERMINOS Y DATOS DEL ASESOR /////////


// ENVIA EL PDF A DESPLEGARSE EN PANTALLA
// SE PUEDE PONER EL NOMBRE DEL ARCHIVO PARA GUARDADO