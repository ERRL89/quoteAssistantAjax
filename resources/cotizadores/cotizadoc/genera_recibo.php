<?php

///////////////// SE CREA OBJETO reciboPDF /////////////////
$reciboPDF = new pdf();

////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////

$pagecount = $reciboPDF->setSourceFile($root."resources/cotizadores/cotizadoc/hoja_1.pdf");

////////////// SE IMPORTA LA HOJA QUE SE USARÁ DE PLANTILLA //////////////
$tpl = $reciboPDF->importPage(1);

/////// DESIGNAMOS EL TAMAÑO DE LA PLANTILLA DESDE LA HOJA IMPORTADA ///////
$size = $reciboPDF->getTemplateSize($tpl);
/////// DESIGNAMOS EL TAMAÑO DE LA PLANTILLA DESDE LA HOJA IMPORTADA ///////

///////// AÑADIMOS UNA PÁGINA DESIGNANDO EL TAMAÑO DEL DOCUMENTO /////////
////////////// (LETTER = CARTA, 'P' = Portrait ~ vertical) //////////////
$reciboPDF->AddPage('P', 'LETTER');
///////// AÑADIMOS UNA PÁGINA DESIGNANDO EL TAMAÑO DEL DOCUMENTO /////////

////////////// CARGAMOS LA PLANTILLA EN NUESTRA NUEVA PÁGINA //////////////
$reciboPDF->useTemplate($tpl);
////////////// CARGAMOS LA PLANTILLA EN NUESTRA NUEVA PÁGINA //////////////

// TEXTO RECIBO DE PAGO
$reciboPDF->SetFont('helvetica', 'B', 14);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 70); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'RECIBO DE PAGO', 0, 1, '');

// TEXTO FECHA
$reciboPDF->SetFont('helvetica', '', 13);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(140, 40); // Posición x, posición y
$mensaje="FECHA: ".$fechaInicio;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// TEXTO NOMBRE DE CLIENTE
$reciboPDF->SetFont('helvetica', '', 12);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 85); // Posición x, posición y
$mensaje=$nombre;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// TELEFONO DE CLIENTE
$reciboPDF->SetFont('helvetica', '', 12);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 91); // Posición x, posición y
$mensaje=$telefono;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// DIRECCION DE CLIENTE
$reciboPDF->SetFont('helvetica', '', 12);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 97); // Posición x, posición y
$mensaje=$direccion;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

$mensualidad="$".round($kitCosto,2);
$iva=round($kitCosto*.16,2);
$total=round(($kitCosto+$iva));
$data = array(
    array('Producto', 'Cantidad', 'Mensualidad'),
    array('SUSCRIPCIÓN - '.$kitTxt, '1', $mensualidad),
    array('', 'Subtotal:', $mensualidad),
    array('', 'IVA:', '$'.$iva),
    array('', 'Total:', '$'.$total)
);

// Configurar ancho de las columnas
$column_widths = array(100, 30, 30);

// Imprimir la tabla
$reciboPDF->SetFont('helvetica', '', 11);

 // Establecer color de fondo de la celda
$alturaCell=105;
$index=0;
$reciboPDF->SetFillColor(202, 93, 35); 
$reciboPDF->SetTextColor(255, 255, 255); // Color de texto blanco
foreach ($data as $row) {
    $reciboPDF->SetXY(25, $alturaCell+=10); // Posición x, posición y
    if($index==0){
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1);
    }

    else if($index==1){
        $reciboPDF->SetFillColor(255, 255, 255); 
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetFont('helvetica', '', 9);
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1); 
    }

    else if($index==2){
        $reciboPDF->SetFillColor(255, 255, 255);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetFont('helvetica', '', 9);
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1); 
    }

    else if($index==3){
        $reciboPDF->SetFillColor(255, 255, 255);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetFont('helvetica', '', 9);
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1); 
    }

    else if($index==4){
        $reciboPDF->SetFillColor(202, 93, 35); 
        $reciboPDF->SetTextColor(255, 255, 255);
        $reciboPDF->SetFont('helvetica', 'B', 12);
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 0);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1);
    } 

    $index+=1;
}

// TEXTO DETALLE DE PAGO
$reciboPDF->SetFont('helvetica', 'B', 13);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 180); // Posición x, posición y
$mensaje="DETALLE DE PAGO";
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// TEXTO TITULAR DE TARJETA
$reciboPDF->SetFont('helvetica', '', 11);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 190); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'Titular: '.$nameUser, 0, 1, '');

// TEXTO NUMERO DE TARJETA
$reciboPDF->SetFont('helvetica', '', 11);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 196); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'Número de Tarjeta: '.$cardNumber, 0, 1, '');

// TEXTO TIPO DE TARJETA
$reciboPDF->SetFont('helvetica', '', 11);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 201); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'Tarjeta: '.$typeCard.'/'.$typeBrand, 0, 1, '');

// TEXTO CLAVE DE RASTREO
$reciboPDF->SetFont('helvetica', '', 11);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 207); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'Clave de autorización: '.$idSuscripcion, 0, 1, '');

// TEXTO GRACIAS POR TU COMPRA
$reciboPDF->SetFont('helvetica', 'B', 13);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(70, 230); // Posición x, posición y
$mensaje="¡GRACIAS POR TU COMPRA!";
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

//-----------------PAGINA 2 ---------------------------------------//
///////// AÑADIMOS UNA PÁGINA DESIGNANDO EL TAMAÑO DEL DOCUMENTO /////////
$reciboPDF->AddPage('P', 'LETTER');

////////////// CARGAMOS LA PLANTILLA EN NUESTRA NUEVA PÁGINA //////////////
$reciboPDF->useTemplate($tpl);

// TEXTO RECIBO DE PAGO
$reciboPDF->SetFont('helvetica', 'B', 14);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 70); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'RECIBO DE PAGO', 0, 1, '');

// TEXTO FECHA
$reciboPDF->SetFont('helvetica', '', 13);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(140, 40); // Posición x, posición y
$mensaje="FECHA: ".$fechaInicio;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// TEXTO NOMBRE DE CLIENTE
$reciboPDF->SetFont('helvetica', '', 12);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 85); // Posición x, posición y
$mensaje=$nombre;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// TELEFONO DE CLIENTE
$reciboPDF->SetFont('helvetica', '', 12);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 91); // Posición x, posición y
$mensaje=$telefono;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// DIRECCION DE CLIENTE
$reciboPDF->SetFont('helvetica', '', 12);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 97); // Posición x, posición y
$mensaje=$direccion;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

$costoTxt="$".round($costo,2);
$iva=round($costo*.16,2);
$total=round(($costo+$iva));
$data = array(
    array('Descripción', 'Cantidad', 'Monto'),
    array($descriptionCharge, '1', $costoTxt),
    array('', 'Subtotal:', $costoTxt),
    array('', 'IVA:', '$'.$iva),
    array('', 'Total:', '$'.$total)
);

// Configurar ancho de las columnas
$column_widths = array(100, 30, 30);

// Imprimir la tabla
$reciboPDF->SetFont('helvetica', '', 11);

 // Establecer color de fondo de la celda
$alturaCell=105;
$index=0;
$reciboPDF->SetFillColor(202, 93, 35); 
$reciboPDF->SetTextColor(255, 255, 255); // Color de texto blanco
foreach ($data as $row) {
    $reciboPDF->SetXY(25, $alturaCell+=10); // Posición x, posición y
    if($index==0){
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1);
    }

    else if($index==1){
        $reciboPDF->SetFillColor(255, 255, 255); 
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetFont('helvetica', '', 9);
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1); 
    }

    else if($index==2){
        $reciboPDF->SetFillColor(255, 255, 255);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetFont('helvetica', '', 9);
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1); 
    }

    else if($index==3){
        $reciboPDF->SetFillColor(255, 255, 255);
        $reciboPDF->SetTextColor(0, 0, 0);
        $reciboPDF->SetFont('helvetica', '', 9);
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1); 
    }

    else if($index==4){
        $reciboPDF->SetFillColor(202, 93, 35); 
        $reciboPDF->SetTextColor(255, 255, 255);
        $reciboPDF->SetFont('helvetica', 'B', 12);
        $reciboPDF->Cell($column_widths[0], 10, $row[0], 0, 0, 'C', 0);
        $reciboPDF->Cell($column_widths[1], 10, $row[1], 0, 0, 'C', 1);
        $reciboPDF->Cell($column_widths[2], 10, $row[2], 0, 0, 'C', 1);
    } 

    $index+=1;
}

// TEXTO DETALLE DE PAGO
$reciboPDF->SetFont('helvetica', 'B', 13);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 180); // Posición x, posición y
$mensaje="DETALLE DE PAGO";
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// TEXTO TITULAR DE TARJETA
$reciboPDF->SetFont('helvetica', '', 11);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 190); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'Titular: '.$nameUser, 0, 1, '');

// TEXTO NUMERO DE TARJETA
$reciboPDF->SetFont('helvetica', '', 11);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 196); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'Número de Tarjeta: '.$cardNumber, 0, 1, '');

// TEXTO TIPO DE TARJETA
$reciboPDF->SetFont('helvetica', '', 11);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 201); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'Tarjeta: '.$typeCard.'/'.$typeBrand, 0, 1, '');

// TEXTO CLAVE DE RASTREO
$reciboPDF->SetFont('helvetica', '', 11);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(30, 207); // Posición x, posición y
$reciboPDF->Cell(0, 10, 'Clave de autorización: '.$idCharge, 0, 1, '');

// TEXTO GRACIAS POR TU COMPRA
$reciboPDF->SetFont('helvetica', 'B', 13);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(70, 230); // Posición x, posición y
$mensaje="¡GRACIAS POR TU COMPRA!";
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

$reciboPDF->Output($root."docs/digitalContracts/".$numContrato."/comprobante_pago_".$numContrato.".pdf", 'F');

?>


