<?php

$condicion_pago = "Leasing";
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
$contador_iteraciones  = 0;
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
    $tam_celda = 14;
    $tam_letra = 8;
    $tam_cantidad = 10;
    $limite_iteraciones = 16;
    $tam_leyenda = 14;
}

$cotizacion_producto = "ACIL GPS";
$espaciado_producto = "30";
$espaciado_titulo = "12";
$espaciado_descripcion = "18";
$alinea_descripcion = "L";
$cantidad_producto=1;
$clave_producto = "2122";
$consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
$lista_productos = mysqli_fetch_assoc($consulta_productos);
$nombre_producto = $lista_productos["nombre"];
$descripcion_producto = $lista_productos["descripcion"];
$precio = $lista_productos["precio_renta"];
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

///////// COMIENZA CONTENIDO /////////
    ////// CANTIDAD //////
    $pdf->SetY(107);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','',12);
    $pdf->Cell(30, $espaciado_producto, "$cantidad_producto", 0,0,'C');
    ////// CANTIDAD //////

    ////// DESCRIPCIÓN (ARTÍCULO) //////
    $pdf->SetY(107);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(95, $espaciado_titulo, "$nombre_producto",0, 'C', 0, 0, '', '', true, 0, false, true, $espaciado_titulo, 'M');
    ////// DESCRIPCIÓN (ARTÍCULO) //////

    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
    $pdf->SetY(119);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',8);
    $pdf->MultiCell(95, $espaciado_descripción, "$descripcion_producto", 0, $alinea_descripcion, 0,0,'','',true,0,false,true,$espaciado_descripción,'M');
    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY(107);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(30, $espaciado_producto, "", 0, 'C', 0,0,'','',true,0,false,true,$espaciado_producto,'M');
    ////// PRECIO UNITARIO //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY(107);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(31, $espaciado_producto, "", 0, 'C', 0,0,'','',true,0,false,true,$espaciado_producto,'M');
    ////// PRECIO UNITARIO //////

    $altura_concepto = $altura_concepto + $espaciado_producto;
    $altura_descripcion = $altura_concepto + $espaciado_titulo;
    ///////////// TERMINA PRODUCTO PRINCIPAL ///////////////

///////// INICIA FOOTER /////////

$altura_footer = $altura_concepto;
$altura_subtotal = $altura_footer;
$altura_iva = $altura_subtotal + 6;
$altura_total = $altura_iva + 6;

$subtotal = $importe_producto;

switch($final)
{
    case 1:
        {
            break;
        }
    case 2:
        {
            $subtotal = $subtotal * 11;
            break;
        }
    case 3:
        {
            $subtotal_mensual = $subtotal;
            $subtotal = $subtotal * 21;
            break;
        }
    default:
        {
            break;
        }
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