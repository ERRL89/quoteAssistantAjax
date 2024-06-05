<?php
    /////////////////// AJUSTES INICIALES ///////////////////
    header("Cache-Control: no-cache, must-revalidate");
    setlocale(LC_TIME,"spanish");
    /////////////////// AJUSTES INICIALES ///////////////////
    
    /////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////
    use setasign\Fpdi;
    require_once($root.'resources/tcpdf/tcpdf.php');
    require_once($root.'resources/fpdi/autoload.php');
    /////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////
    
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
    $pdf->Cell(186, 10, "RECIBO", 0, 0, 'R');

    
   

    ////// SECCIÓN RECTANGULO NARANJA (FECHA) //////
    $pdf->SetY(65);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(253,107,13);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(40, 6, "FECHA", 0, 0, 'C',TRUE);
    ////// SECCIÓN RECTANGULO NARANJA (FECHA) //////

    $fecha_actual = fechaCastellano($fecha_inicio);
    ////// SECCIÓN RECTANGULO FECHA //////
    $pdf->SetY(65);
    $pdf->SetX(55);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(191,191,191);
    $pdf->Cell(50, 6, $fecha_actual, 0, 0, 'C', TRUE);
    ////// SECCIÓN RECTANGULO FECHA //////

    ////// SECCIÓN RECTANGULO BLANCO (nombre de Cliente) //////
    $pdf->SetY(71);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',11);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90, 6, "$razon_social", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO BLANCO (nombre de Cliente) //////

    ////// SECCIÓN RECTANGULO BLANCO (nombre del Proyecto) //////
    $pdf->SetY(77);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',11);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90, 6, "$nombre_comercial", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO BLANCO (nombre del Proyecto) //////

    ////// SECCIÓN RECTANGULO BLANCO (TELEFONO) //////
    $pdf->SetY(83);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',11);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90, 6, "$telefono", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO BLANCO (TELEFONO) //////

    ////// SECCIÓN RECTANGULO BLANCO (CORREO) //////
    $pdf->SetY(89);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',11);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90, 6, "$email_cliente", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO BLANCO (CORREO) //////

    ////// SECCIÓN RECTANGULO BLANCO (FOLIO) //////
    $pdf->SetY(95);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',11);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(15, 6, "FOLIO:", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO BLANCO (FOLIO) //////

    ////// SECCIÓN RECTANGULO BLANCO (Numero de contrato) //////
    $pdf->SetY(95);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',11);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(75, 6, "$numero_contrato", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO BLANCO (FOLIO) //////

    ////// INICIA ZONA DE LISTA DE ARTICULOS  //////

    ////// CABECERAS DE LA TABLA (MARCO REFERENCIA - QUITAR) //////
    $pdf->SetY(105);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',11);
    $pdf->Cell(186, 6, "", 0, 0, 'L');
    ////// CABECERAS DE LA TABLA (MARCO REFERENCIA - QUITAR) //////

    ////// CABECERAS DE LA TABLA //////
    $pdf->SetY(105);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',11);
    $pdf->Cell(30, 6, "", 0, 0, 'C');

    /*$pdf->SetY(95);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',11);
    $pdf->Cell(30, 6, "Item no.", 0, 0, 'C');*/

    $pdf->SetY(105);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(125, 6, "Descripción del producto.", 0, 0, 'C');

    $pdf->SetY(105);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(30, 6, "", 0, 0, 'C');

    $pdf->SetY(105);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(31, 6, "", 0, 0, 'C');
    ////// CABECERAS DE LA TABLA //////

    ////// BARRA AMARILLA //////
    $pdf->SetY(111);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(30, 6, "$tipo", 0, 0, 'C',TRUE);
    ////// BARRA AMARILLA //////

    ////// BARRA GRIS //////
    $pdf->SetY(111);
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
    $pdf->SetY(117);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','',12);
    $pdf->Cell(30, 40, "", 0,0,'C');
    ////// CANTIDAD //////

    /*////// DESCRIPCIÓN (ARTÍCULO) //////
    $pdf->SetY(117);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(125, 12, "KIT ALARMA IP ALAMBRICO E INALAMBRICO B SERIE R", 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
    ////// DESCRIPCIÓN (ARTÍCULO) //////*/

    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
    
    $espaciado = 80;
    $pdf->SetY(129);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',8);
    $pdf->MultiCell(125, 28, "$equipo", 0, 'L', 0,0,'','',true,0,false,true,$espaciado,'M');


    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY(117);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(30, 40, "", 0, 'C', 0,0,'','',true,0,false,true,40,'M');
    ////// PRECIO UNITARIO //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY(117);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(31, 40, "", 0, 'C', 0,0,'','',true,0,false,true,40,'M');
    ////// PRECIO UNITARIO //////

    $altura_concepto = 207;
    $altura_descripcion = 160;

    ///////////// TERMINA PRODUCTO PRINCIPAL ///////////////

    /*////////////// SECCIÓN OCULTA POR EL MOMENTO /////////


    ///////////// INICIAN COMPLEMENTOS ///////////////

    $altura_concepto = 147;
    $altura_descripcion = 159;
    $pdf->SetFillColor(216,217,215);
    $llenado = true;

    ////// CANTIDAD //////
    $pdf->SetY($altura_concepto);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','',12);
    $pdf->Cell(30, 20, "1", 0,0,'C',$llenado);
    ////// CANTIDAD //////

    ////// DESCRIPCIÓN (ARTÍCULO) //////
    $pdf->SetY($altura_concepto);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(95, 12, "POSTE/BRAZO 2m", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 12, 'M');
    ////// DESCRIPCIÓN (ARTÍCULO) //////

    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
    $pdf->SetY($altura_descripcion);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',8);
    $pdf->MultiCell(95, 8, "POSTE O BRAZO PARA AJUSTE DE CÁMARA DE 2M", 0, 'L', $llenado,0,'','',true,0,false,true,8,'M');
    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY($altura_concepto);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(30, 20, "{PRECIO}", 0, 'C', $llenado,0,'','',true,0,false,true,20,'M');
    ////// PRECIO UNITARIO //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY($altura_concepto);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(31, 20, "{PRECIO}", 0, 'C', $llenado,0,'','',true,0,false,true,20,'M');
    ////// PRECIO UNITARIO //////

    $altura_concepto = $altura_concepto + 20;
    $altura_descripcion = $altura_concepto + 12;
    $llenado = false;

    ////// CANTIDAD //////
    $pdf->SetY($altura_concepto);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','',12);
    $pdf->Cell(30, 20, "1", 0,0,'C',$llenado);
    ////// CANTIDAD //////

    ////// DESCRIPCIÓN (ARTÍCULO) //////
    $pdf->SetY($altura_concepto);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(95, 12, "POSTE/BRAZO 2m", 0, 'C', $llenado, 0, '', '', true, 0, false, true, 12, 'M');
    ////// DESCRIPCIÓN (ARTÍCULO) //////

    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////
    $pdf->SetY($altura_descripcion);
    $pdf->SetX(45);
    $pdf->SetFont('helvetica','B',8);
    $pdf->MultiCell(95, 8, "POSTE O BRAZO PARA AJUSTE DE CÁMARA DE 2M", 0, 'L', $llenado,0,'','',true,0,false,true,8,'M');
    ////// DESCRIPCIÓN (DESCRIPCIÓN) //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY($altura_concepto);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(30, 20, "{PRECIO}", 0, 'C', $llenado,0,'','',true,0,false,true,20,'M');
    ////// PRECIO UNITARIO //////

    ////// PRECIO UNITARIO //////
    $pdf->SetY($altura_concepto);
    $pdf->SetX(170);
    $pdf->SetFont('helvetica','B',10);
    $pdf->MultiCell(31, 20, "{PRECIO}", 0, 'C', $llenado,0,'','',true,0,false,true,20,'M');
    ////// PRECIO UNITARIO //////

    ////////////// SECCIÓN OCULTA POR EL MOMENTO //////////*/

    ///////// TERMINA CONTENIDO /////////

    ///////// INICIA FOOTER /////////

    $altura_footer = $altura_concepto + 10;
    $altura_subtotal = $altura_footer;
    $altura_iva = $altura_subtotal + 6;
    $altura_total = $altura_iva + 6;

    ////// BARRA GRIS FOOTER //////
    $pdf->SetY($altura_footer);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetFillColor(191,191,191);
    $pdf->Cell(186, 6, "", 0, 0, 'C',TRUE);
    ////// BARRA GRIS FOOTER //////

    // SUBTOTAL (texto) //
    // $pdf->SetY($altura_subtotal);
    // $pdf->SetX(140);
    // $pdf->SetFont('helvetica','B',10);
    // $pdf->Cell(30, 6, "SUBTOTAL", 0, 0, 'C');
    // SUBTOTAL (texto) //

    // SUBTOTAL (cantidad) //
    // $pdf->SetY($altura_subtotal);
    // $pdf->SetX(170);
    // $pdf->SetFont('helvetica','B',10);
    // $pdf->Cell(31, 6, "{PRECIO}", 0, 0, 'C');
    // SUBTOTAL (cantidad) //

    // IVA (texto) //
    // $pdf->SetY($altura_iva);
    // $pdf->SetX(140);
    // $pdf->SetFont('helvetica','B',10);
    // $pdf->Cell(30, 6, "IVA", 0, 0, 'C',TRUE);
    // IVA (texto) //

    // IVA (cantidad) //
    // $pdf->SetY($altura_iva);
    // $pdf->SetX(170);
    // $pdf->SetFont('helvetica','B',10);
    // $pdf->Cell(31, 6, "{PRECIO}", 0, 0, 'C',TRUE);
    // IVA (cantidad) //

    // TOTAL (texto) //
    // $pdf->SetY($altura_total);
    // $pdf->SetX(140);
    // $pdf->SetFont('helvetica','B',10);
    // $pdf->Cell(30, 6, "TOTAL", 0, 0, 'C',TRUE);
    // TOTAL (texto) //

    // TOTAL (cantidad) //
    // $pdf->SetY($altura_total);
    // $pdf->SetX(170);
    // $pdf->SetFont('helvetica','B',10);
    // $pdf->Cell(31, 6, "{PRECIO}", 0, 0, 'C',TRUE);
    // TOTAL (cantidad) //

    ///////// TERMINA FOOTER /////////

    //////// TERMINOS Y DATOS DEL ASESOR /////////

    ////// BARRA NARANJA TYC //////
    // $pdf->SetY(215);
    // $pdf->SetX(15);
    // $pdf->SetFont('helvetica','B',12);
    // $pdf->SetFillColor(253,107,13);
    // $pdf->Cell(90, 6, "", 0, 0, 'C',TRUE);
    ////// BARRA NARANJA TYC //////

    ////// TITULO TYC //////
    // $pdf->SetY(215);
    // $pdf->SetX(15);
    // $pdf->SetFont('helvetica','B',10);
    // $pdf->SetTextColor(255,255,255);
    // $pdf->Cell(90, 6, "TERMINOS Y CONDICIONES", 0, 0, 'C');
    ////// TITULO TYC //////

//     $texto_term = 
//     ' 1. Precios cotizados en Moneda Nacional mas el 16% de IVA.
//  2. Se requiere depósito bancario del 60% del pedido total.
//  3. Entrega inmediata.
//  4. La garantía normal es por un periodo de 1 año.
//  5. Promoción válida durante 15 días a partir de la fecha de cotización.
//  6. Los precios cotizados son válidos para una sola orden de compra.
//  7. Se requiere pago de depósito y primera mensualidad al inicio del proyecto para Leasing.
//  8.  La garantia es por contrato en curso para leasing.
//  9. El contrato tiene una vigencia de 36 meses para Leasing.
// ';

    ////// TYC //////
    // $pdf->SetY(221);
    // $pdf->SetX(15);
    // $pdf->SetFont('helvetica','',6);
    // $pdf->SetTextColor(0,0,0);
    // $pdf->MultiCell(90, 28, $texto_term, 0, 'J', 0, 0, '', '', true, 0, false, true, 28, 'M');
    ////// TYC //////

    ////// SECCIÓN RECTANGULO CERRADOR //////
    $pdf->SetY(225);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(61, 6, "$nombre_cerrador", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO CERRADOR //////

    ////// SECCIÓN RECTANGULO CERRADOR //////
    $pdf->SetY(232);
    $pdf->SetX(15);
    $pdf->SetFont('helvetica','',10);
    $pdf->Cell(61, 6, "Alianzas comerciales", 0, 0, 'L');
    ////// SECCIÓN RECTANGULO CERRADOR //////

    ////// SECCIÓN RECTANGULO AMARILLO CORREO //////
    $pdf->SetY(225);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(253,255,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(61, 6, "$email_cerrador", 0, 0, 'L',TRUE);
    ////// SECCIÓN RECTANGULO AMARILLO CORREO //////

    ////// SECCIÓN RECTANGULO TELEFONO //////
    $pdf->SetY(232);
    $pdf->SetX(140);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(61, 6, "Tel. 55-5367-4298 / 55-6821-5744", 0, 0, 'L');
    ////// SECCIÓN RECTANGULO TELEFONO //////

    //////// TERMINOS Y DATOS DEL ASESOR /////////

    // ENVIA EL PDF A DESPLEGARSE EN PANTALLA
    // SE PUEDE PONER EL NOMBRE DEL ARCHIVO PARA GUARDADO
    $pdf->Output("$numero_contrato.pdf", 'I');


?>