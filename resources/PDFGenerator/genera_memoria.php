<?php
    setlocale(LC_TIME,"spanish");
    
    /*if($razon_social == "PUBLICO EN GENERAL" || $razon_socia == "PÚBLICO EN GENERAL" || $razon_social == "PUBLICO EN GENERAL ")
    {
        $atencion = $contacto_1;
    }
    else
    {
        $atencion = $razon_social;
    }*/
    
    $atencion = $nombre;

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

    if($modalidad == 1)
    {
        $garantia = fechaCastellano($fecha_termino);
        $garantia = "$garantia (3 años de Garantía en MODALIDAD LEASING";
        //echo "$garantia (3 años de Garantía) en MODALIDAD LEASING";
    }
    
    if($modalidad == 2)
    {
        $garantia = fechaCastellano($fecha_termino);
        $garantia = "$garantia (1 año de Garantía en MODALIDAD VENTA";
        //echo "$garantia (3 años de Garantía) en MODALIDAD LEASING";
    }

    // SE CARGAN LIBRERÍAS
    use setasign\Fpdi;
    require_once($root.'resources/tcpdf/tcpdf.php');
    require_once($root.'resources/fpdi/autoload.php');

    // SE INSTANCIA LA CLASE DEL PDF, SE PUEDE AÑADIR ENCABEZADO Y PIE DE PAGINA AQUÍ
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

    // SE CREA OBJETO PDF
    $pdf = new pdf();

    // SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS
    $pagecount = $pdf->setSourceFile("hoja.pdf");

    // SE IMPORTA LA HOJA QUE SE USARÁ DE PLANTILLA
    $tpl = $pdf->importPage(1);
    // DESIGNAMOS EL TAMAÑO DE LA PLANTILLA
    $size = $pdf->getTemplateSize($tpl);
    // AÑADIMOS UNA PÁGINA DESIGNANDO EL TAMAÑO DEL DOCUMENTO (LETTER = CARTA, 'P' = Portrait ~ vertical)
    $pdf->AddPage('P', 'LETTER');
    // CARGAMOS LA PLANTILLA EN NUESTRA NUEVA PÁGINA
    $pdf->useTemplate($tpl);


    // POSICIÓN DE PRIMERAS COORDENADAS (LAS COORDENADAS SE AJUSTAN A LOS MILIMETROS DE LA HOJA)
    $pdf->SetY(85);
    $pdf->SetX(0);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',22);
    //Limite de hoja 0-216 (ancho) primer valor 0 representa borde
    //$pdf->Cell(216, 10, '"AURORA LEON TORRES"', 0, 0, 'C');
    // EN MULTICELL, EL PRIMER 0 REPRESENTA BORDE, EL SEGUNDO 0 REPRESENTA RELLENADO
    //$pdf->MultiCell(156, 10, "BOLONIA #25,FRACC. IZCALLI PIRAMIDE TALNEPANTLA DE BAZ, C.P. 54140, EDO DE MEX", 0,'C',0);
    // SE IMPRIME UN RENGLON 
    $pdf->Cell(216, 10, "MEMORIA TÉCNICA DE:", 0, 0, 'C');
    $pdf->SetY(95);
    $pdf->SetX(0);
    // SE PUEDE CAMBIAR LA FUENTE, Y TAMAÑO VOLVIENDO A USAR EL COMANDO SETFONT
    $pdf->SetFont('helvetica','B',26);
    $pdf->Cell(216, 10, "SISTEMAS DE SEGURIDAD", 0, 0, 'C');


    $pdf->SetY(130);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','BU',24);
    $pdf->MultiCell(156, 10, '"'."$nombre_comercial".'"', 0, 'C', 0);

    $pdf->SetY(160);
    $pdf->SetX(30);
    $pdf->MultiCell(156, 10, '"'."$atencion".'"', 0, 'C', 0);

    $pdf->SetY(190);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','U',22);
    $pdf->MultiCell(156, 10, "$direccion", 0,'C',0);

    // FUNCIÓN PARA COMENZAR UNA NUEVA PÁGINA CON EL TEMPLATE GENERADO
    $pdf->AddPage('P', 'LETTER');
    $pdf->useTemplate($tpl);
    // TERMINA FUNCIÓN

    $pdf->SetY(50);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','',12);
    $pdf->Cell(156, 5, "CARTA DE ENTREGA DE", 0, 0, 'R');
    $pdf->SetY(55);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',14);
    $pdf->Cell(156, 5, "SISTEMAS DE SEGURIDAD", 0, 0, 'R');
    $pdf->SetY(73);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','',10.5);
    $fecha_inicio = fechaCastellano($fecha_inicio);
    $pdf->Cell(156, 5, "Ciudad de México a $fecha_inicio.", 0, 0, 'R');
    $pdf->SetY(91);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',10.5);
    // lim izq = 30, lim der = 156
    $pdf->Cell(35, 5, 'Carta de entrega a:', 0, 0, 'L');
    $pdf->SetFont('helvetica','BU',10.5);
    $pdf->Cell(121, 5, '"'."$nombre_comercial".'"', 0, 0, 'L');
    $pdf->SetY(105);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',10.5);
    $pdf->Cell(20, 5, 'Atención.', 0, 0, 'L');
    $pdf->SetFont('helvetica','BU',10.5);
    $pdf->MultiCell(136, 5, '"'."$atencion".'"', 0, 'L', 0);
    $pdf->SetY(119);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','',10.5);
    // WRITEHTMLCELL permite crear una celda en la que podemos insertar código HTML y de esta forma hacer un texto más dinámico
    //$pdf->writeHTMLCell(W, H, 'X', 'Y', $html, border, line, fill, reseth, 'align', autopadding);
    $html = "Da conformidad a los trabajos realizados en: <u>$direccion</u><br><br><br>El cual quedó de acuerdo con el trabajo realizado y plasmado en la memoria técnica, enviando así por correo electrónico los manuales de operación de equipos instalados y distribución de equipos dentro del inmueble.<br><br>Sin otro en partícular, quedo como su servidor.";
    $pdf->writeHTMLCell(156, 5, '', '', $html, 0, 0, 0, true, 'J', true);
    $pdf->SetY(170);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',10.5);
    $pdf->Cell(156, 5, "AGRADECEMOS SU PREFERENCIA", 0, 0, 'C');
    $pdf->SetY(185);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','',10.5);
    $pdf->Cell(78, 5, "Atentamente:", 0, 0, 'C');
    $pdf->Cell(78, 5, "Cliente:", 0, 0, 'C');
    $pdf->SetY(205);
    $pdf->SetX(30);
    $pdf->Line(40,205, 98, 205);
    $pdf->SetFont('helvetica','B',10.5);
    $html = "$nombre_cerrador <br>ACIL MÉXICO S.A DE C.V.";
    $pdf->SetX(40);
    $pdf->writeHTMLCell(58, 5, '', '', $html, 0, 0, 0, true, 'C', true);
    $pdf->Line(118,205, 176, 205);
    $pdf->SetX(118);
    $pdf->MultiCell(58, 5, "$atencion", 0, 'C', 0);
    $pdf->SetY(235);
    $pdf->SetX(30);
    $pdf->Line(78,235, 136, 235);
    $html = "LIDER DE EQUIPO<br>DE INSTALACIÓN";
    $pdf->writeHTMLCell(156, 5, '', '', $html, 0, 0, 0, true, 'C', true);

    // FUNCIÓN PARA COMENZAR UNA NUEVA PÁGINA CON EL TEMPLATE GENERADO
    $pdf->AddPage('P', 'LETTER');
    $pdf->useTemplate($tpl);
    // TERMINA FUNCIÓN

    $pdf->SetY(43);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','',12);
    $pdf->Cell(156, 5, "CERTIFICADO DE", 0, 0, 'R');
    $pdf->SetY(48);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',16);
    $pdf->Cell(156, 5, "GARANTÍA", 0, 0, 'R');
    $pdf->SetY(58);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',10.5);
    $html = "ACIL MÉXICO S.A. DE C.V.; <u>".'"'."$nombre_comercial".'"'."</u>";
    $pdf->writeHTMLCell(156, 5, '', '', $html, 0, 0, 0, true, 'J', true);
    $pdf->SetY(68);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','',10.5);
    $html = "Dicha instalación incluye:
    <p><b>$tipos_contrato</b><br>$equipo</p>
    <p>Esta garantía es válida por cualquier defecto de fabricación, ejecución en el material y/o mano de obra, según el alcance total de los trabajos efectuados. Entiéndase que cualquier vicio oculto que se presente en el periodo comprendido de esta fecha límite, que será el día <b><u>$garantia en contrato original)</u></b> Quedará dentro de la garantía hasta que hayan quedado en perfectas condiciones y a satisfacción del cliente. No aplica dicha garantía por vandalismo, mal uso de su operación y/o fallas eléctricas. <b>ACIL MÉXICO S.A. DE C.V.</b> no se hace responsable por fallas en la configuración del sistema, fallas eléctricas y/o mal uso del equipo. El costo de la configuración se cotizará en forma diferente.</p>";
    $pdf->writeHTMLCell(156, 5, '', '', $html, 0, 0, 0, true, 'J', true);

    $pdf->SetY(175);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',10.5);
    $pdf->Cell(156, 5, "AGRADECEMOS SU PREFERENCIA", 0, 0, 'C');
    $pdf->SetY(185);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','',10.5);
    $pdf->Cell(78, 5, "Atentamente:", 0, 0, 'C');
    $pdf->Cell(78, 5, "Cliente:", 0, 0, 'C');
    $pdf->SetY(205);
    $pdf->SetX(30);
    $pdf->Line(40,205, 98, 205);
    $pdf->SetFont('helvetica','B',10.5);
    $html = "$nombre_cerrador <br>ACIL MÉXICO S.A DE C.V.";
    $pdf->SetX(40);
    $pdf->writeHTMLCell(58, 5, '', '', $html, 0, 0, 0, true, 'C', true);
    $pdf->Line(118,205, 176, 205);
    $pdf->SetX(118);
    $pdf->MultiCell(58, 5, "$atencion", 0, 'C', 0);
    $pdf->SetY(235);
    $pdf->SetX(30);
    $pdf->Line(78,235, 136, 235);
    $html = "LIDER DE EQUIPO<br>DE INSTALACIÓN";
    $pdf->writeHTMLCell(156, 5, '', '', $html, 0, 0, 0, true, 'C', true);

    // FUNCIÓN PARA COMENZAR UNA NUEVA PÁGINA CON EL TEMPLATE GENERADO
    $pdf->AddPage('P', 'LETTER');
    $pdf->useTemplate($tpl);
    // TERMINA FUNCIÓN

    $pdf->SetY(55);
    $pdf->SetX(10);
    $pdf->SetFont('helvetica','B',10.5);
    $pdf->Cell(196, 60, "", 1, 0, '');
    $pdf->SetY(55);
    $pdf->SetX(12);
    $pdf->Cell(196, 10, "OBSERVACIONES CLIENTE", 0, 0, 'L');

    $pdf->SetY(122);
    $pdf->SetX(10);
    $pdf->SetFont('helvetica','B',10.5);
    $pdf->Cell(196, 60, "", 1, 0, '');
    $pdf->SetY(122);
    $pdf->SetX(12);
    $pdf->Cell(196, 10, "OBSERVACIONES ACIL MÉXICO", 0, 0, 'L');


    $pdf->SetY(185);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','',10.5);
    $pdf->Cell(78, 5, "Atentamente:", 0, 0, 'C');
    $pdf->Cell(78, 5, "Cliente:", 0, 0, 'C');
    $pdf->SetY(205);
    $pdf->SetX(30);
    $pdf->Line(40,205, 98, 205);
    $pdf->SetFont('helvetica','B',10.5);
    $html = "$nombre_cerrador <br>ACIL MÉXICO S.A DE C.V.";
    $pdf->SetX(40);
    $pdf->writeHTMLCell(58, 5, '', '', $html, 0, 0, 0, true, 'C', true);
    $pdf->Line(118,205, 176, 205);
    $pdf->SetX(118);
    $pdf->MultiCell(58, 5, "$atencion", 0, 'C', 0);
    $pdf->SetY(235);
    $pdf->SetX(30);
    $pdf->Line(78,235, 136, 235);
    $html = "LIDER DE EQUIPO<br>DE INSTALACIÓN";
    $pdf->writeHTMLCell(156, 5, '', '', $html, 0, 0, 0, true, 'C', true);
    
    // FUNCIÓN PARA COMENZAR UNA NUEVA PÁGINA CON EL TEMPLATE GENERADO
    $pdf->AddPage('P', 'LETTER');
    $pdf->useTemplate($tpl);
    
    // FUNCIÓN PARA CREAR UN CÓDIGO QR, SE ENVÍA EL LINK PARA LA ENCUESTA
    $url="https://www.acil.mx/encuesta/formulario.php?cte=$numero_cliente&contrato=$numero_contrato";
    // QRCODE,H : QR-CODE Best error correction
    $pdf->write2DBarcode($url, 'QRCODE,H', 83, 70, 50, 50, array(), 'N');
    $pdf->SetY(125);
    $pdf->SetX(0);
    $pdf->SetFont('helvetica','',22);
    $pdf->Cell(216, 5, "ENCUESTA DE SATISFACCIÓN", 0, 0, 'C');
    //$pdf->write2DBarcode(URL, 'CALIDAD', POSX, POSY, TAMX, TAMY, 'ESTILO', 'N');
    //$pdf->Text(140, 205, 'QRCODE H - NO PADDING');
    
    $pdf->SetY(175);
    $pdf->SetX(30);
    $pdf->SetFont('helvetica','B',10.5);
    $pdf->Cell(156, 5, "FIRMA DE ENTERADO", 0, 0, 'C');
    $pdf->SetY(205);
    $pdf->SetX(30);
    $pdf->Line(78,205, 136, 205);
    $html = "$atencion";
    $pdf->writeHTMLCell(156, 5, '', '', $html, 0, 0, 0, true, 'C', true);
    
    
    // ENVIA EL PDF A DESPLEGARSE EN PANTALLA
    // SE PUEDE PONER EL NOMBRE DEL ARCHIVO PARA GUARDADO
    $pdf->Output("$numero_contrato.pdf", 'I');



?>