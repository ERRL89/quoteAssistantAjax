<?php

///////////////// SE CREA OBJETO reciboPDF /////////////////
$reciboPDF = new pdf();

////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////

$pagecount = $reciboPDF->setSourceFile($root."resources/cotizadores/cotizadoc/hoja_datos_bancarios.pdf");

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
$reciboPDF->SetXY(28, 65); // Posición x, posición y
$reciboPDF->Cell(0, 10, $nombre, 0, 1, '');

// TEXTO FECHA
$fecha_actual = date("d-m-Y");
$reciboPDF->SetFont('helvetica', '', 13);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(145, 40); // Posición x, posición y
$mensaje="FECHA: ".$fecha_actual;
$reciboPDF->Cell(0, 10, $mensaje, 0, 1, '');

// NUMERO DE CONTRATO
$reciboPDF->SetFont('helvetica', 'B', 14);
$reciboPDF->SetTextColor(0, 0, 0); // Color blanco para el texto
$reciboPDF->SetXY(114.6, 163.9); // Posición x, posición y
$reciboPDF->Cell(0, 10, $numContrato, 0, 1, '');

$carpeta = $root."docs/digitalContracts/".$numContrato;

$reciboPDF->Output($root."docs/digitalContracts/".$numContrato."/datos_bancarios_".$numContrato.".pdf", 'F');

?>

