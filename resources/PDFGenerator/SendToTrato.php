<?php
    /////////////////// AJUSTES INICIALES ///////////////////
    header("Cache-Control: no-cache, must-revalidate");
    setlocale(LC_TIME,"spanish");

    /////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////
    use setasign\Fpdi;
    require_once($root.'resources/tcpdf/tcpdf.php');
    require_once($root.'resources/fpdi/autoload.php');
    /////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////

    $db = conexionPdo();

    $valor_total = 36 * $kitMensualidad;
    $residual = 0.25 * $valor_total;
    $fin_contrato = strtotime('+3 years -1 day', strtotime($fechaInicio));
    $fin_contrato = date('Y-m-d', $fin_contrato);
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
    $pagecount = $pdf->setSourceFile($root."docs/templatesFpdi/leasingContract.pdf");
    ////////////// SE CARGA LA PLANTILLA CON LA QUE TRABAJAREMOS //////////////
    
    ////////////// SE CREA CICLO PARA IMPORTAR TODAS LAS HOJAS DEL CONTRATO //////////////
    for($i = 1; $i <=5; $i++)
    {
        $tpl = $pdf->importPage($i);
        $size = $pdf->getTemplateSize($tpl);
        $pdf->AddPage('P', 'LETTER');
        $pdf->useTemplate($tpl);
    }

    //$folio_contrato = $r_folio['id_folio'];
    $folio_contrato = $numContrato;
    ///////////////// OBTENEMOS VARIABLES ///////////////////

    // POSICIÓN DE PRIMERAS COORDENADAS (LAS COORDENADAS SE AJUSTAN A LOS MILIMETROS DE LA HOJA)
    //Limite de hoja 0-216 (ancho) primer valor 0 representa borde

    //////////////// SE AÑADE FOLIO ///////////////
    $pdf->SetY(17.8);
    $pdf->SetX(169.8);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',12);
    $pdf->SetTextColor(255,0,0);
    $mensaje = $folio_contrato;
    $pdf->Cell(24, 6, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE FOLIO ///////////////

    //////////////// SE AÑADE NÚMERO DE COTIZACIÓN ///////////////
    $pdf->SetTextColor(0,0,0);
    $pdf->SetY(19.1);
    $pdf->SetX(125);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $folioCotizacion;
    $pdf->Cell(27.6, 4, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NÚMERO DE COTIZACIÓN ///////////////

    //////////////// SE AÑADE NÚMERO DE CLIENTE ///////////////
    $pdf->SetY(24.1);
    $pdf->SetX(121.3);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $numCliente;
    $pdf->Cell(31, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NÚMERO DE CLIENTE ///////////////

    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////
    $pdf->SetY(33.4);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    if($persona == "Persona Fisica")
    {
        $mensaje = $nombre;
    }
    else
    {
        $mensaje = $nombre;
    }
    $pdf->Cell(78, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////

    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE ///////////////
    $pdf->SetY(51.6);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    if($persona == "Persona Moral")
    {
        $mensaje = $representanteLegal;
    }
    else
    {
        $mensaje = "N/A";
    }
    $pdf->Cell(80, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE ///////////////

    //////////////// SE AÑADE DATOS DE LA ESCRITURA ///////////////
    $pdf->SetY(65.4);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    if($persona == "Persona Moral")
    {
        $escritura_txt = number_format($escritura, 0, '.', ',');
        $mensaje = $escritura_txt;
    }
    else
    {
        $mensaje = "N/A";
    }
    $pdf->Cell(80, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE DATOS DE LA ESCRITURA ///////////////

    //////////////// SE AÑADE DIRECCIÓN DEL CLIENTE ///////////////
    $pdf->SetY(79.4);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8.5);
    $mensaje = $direccion;
    $pdf->MultiCell(81, 3, $mensaje, 0, 0, 0);
    //////////////// SE AÑADE DIRECCIÓN DEL CLIENTE ///////////////

    //////////////// SE AÑADE TELEFONO ///////////////
    $pdf->SetY(88.4);
    $pdf->SetX(117);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $telefono;
    $pdf->Cell(63.5, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE TELEFONO ///////////////

    //////////////// SE AÑADE MODALIDAD ///////////////
    $pdf->SetY(92.9);
    $pdf->SetX(120);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $modalidad;
    $pdf->Cell(61.5, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE MODALIDAD ///////////////

    //////////////// SE AÑADE VALOR TOTAL ///////////////
    $pdf->SetY(99.9);
    $pdf->SetX(130.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);

    $valor_total_txt = number_format($valor_total, 2, '.', ',');
    if(is_null($valor_total_txt))
    {
        $valor_total_txt = "No disponible";
    }
    else
    {
        $valor_total_txt = "$ $valor_total_txt";
    }

    $mensaje = $valor_total_txt;
    $pdf->Cell(60, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE VALOR TOTAL ///////////////

    //////////////// SE AÑADE MENSUALIDAD ///////////////
    $pdf->SetY(104.4);
    $pdf->SetX(120.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);

    $mensualidad_txt = number_format($kitMensualidad, 2, '.', ',');
    if(is_null($mensualidad_txt))
    {
        $mensualidad_txt = "No disponible";
    }
    else
    {
        $mensualidad_txt = "$ $mensualidad_txt";
    }

    $mensaje = $mensualidad_txt;
    $pdf->Cell(70, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE MENSUALIDAD ///////////////

    //////////////// SE AÑADE RESIDUAL ///////////////
    $pdf->SetY(110.9);
    $pdf->SetX(123);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);

    $residual_txt = number_format($residual, 2, '.', ',');
    if(is_null($residual_txt))
    {
        $residual_txt = "No disponible";
    }
    else
    {
        $residual_txt = "$ $residual_txt";
    }

    $mensaje = $residual_txt;
    $pdf->Cell(67, 4, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE RESIDUAL ///////////////

    //////////////// SE AÑADE FORMA DE PAGO ///////////////
    $pdf->SetY(120.4);
    $pdf->SetX(108.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $frecuenciaPago;
    $pdf->Cell(81, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE FORMA DE PAGO ///////////////

    //////////////// SE AÑADE ACUERDO DE PAGO ///////////////
    $pdf->SetY(124.9);
    $pdf->SetX(125);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $acuerdoPago;
    $pdf->Cell(65, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE ACUERDO DE PAGO ///////////////

    //////////////// SE AÑADE FECHA INICIO ///////////////
    $pdf->SetY(129.5);
    $pdf->SetX(134);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $fecha_inicio_txt = dateToLabel($fechaInicio);
    $mensaje = $fecha_inicio_txt;
    $pdf->Cell(56, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE FECHA INICIO ///////////////

    //////////////// SE AÑADE FIN DE CONTRATO ///////////////
    $pdf->SetY(134);
    $pdf->SetX(139.2);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $fin_contrato_txt = dateToLabel($fin_contrato);
    $mensaje = $fin_contrato_txt;
    $pdf->Cell(51, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE FIN DE CONTRATO ///////////////

    //////////////// SE AÑADE NOMBRE DE CONTACTO 01 ///////////////
    $pdf->SetY(143);
    $pdf->SetX(119);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $contacto1;
    $pdf->Cell(71.5, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CONTACTO 01 ///////////////

    //////////////// SE AÑADE NOMBRE DE TELEFONO 01 ///////////////
    $pdf->SetY(148);
    $pdf->SetX(117);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $telefono1;
    $pdf->Cell(73.5, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NOMBRE DE TELEFONO 01 ///////////////

    //////////////// SE AÑADE NOMBRE DE CONTACTO 02 ///////////////
    $pdf->SetY(152);
    $pdf->SetX(119);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $contacto2;
    $pdf->Cell(71.5, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CONTACTO 02 ///////////////

    //////////////// SE AÑADE NOMBRE DE TELEFONO 02 ///////////////
    $pdf->SetY(156.7);
    $pdf->SetX(117);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',8);
    $mensaje = $telefono2;
    $pdf->Cell(73.5, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NOMBRE DE TELEFONO 02 ///////////////

    $nombre_cerrador="Mauricio Castillo";
    //////////////// SE AÑADE NOMBRE DE CERRADOR ///////////////
    $pdf->SetY(185.7);
    $pdf->SetX(122.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',4.5);
    $mensaje = $nombre_cerrador;
    $pdf->Cell(30, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CERRADOR///////////////


    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////
    $pdf->SetY(185.7);
    $pdf->SetX(165);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',4.5);
    if($persona == "Persona Fisica")
    {
        $mensaje = "N/A";
    }
    else
    {
        $mensaje = $nombre;
    }
    $pdf->Cell(32, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////

    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE ///////////////
    $pdf->SetY(181.2);
    $pdf->SetX(169);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',4.5);
    if($persona == "Persona Moral")
    {
        $mensaje = $representanteLegal;
    }
    else
    {
        $mensaje = "$nombre";
    }
    $pdf->Cell(31, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE ///////////////

    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE O CLIENTE ///////////////
    $pdf->SetY(198.3);
    $pdf->SetX(112);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',6);
    if($persona == "Persona Moral")
    {
        $mensaje = $representanteLegal;
    }
    else
    {
        $mensaje = "$nombre";
    }
    $pdf->Cell(68, 3, $mensaje, 0, 0, 'C');
    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE O CLIENTE ///////////////

    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE O CLIENTE ///////////////
    $pdf->SetY(227);
    $pdf->SetX(124);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',5);
    if($persona == "Persona Moral")
    {
        $mensaje = $representanteLegal;
    }
    else
    {
        $mensaje = "$nombre";
    }
    $pdf->Cell(74, 2, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE REPRESENTANTE O CLIENTE ///////////////

    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////
    $pdf->SetY(235.8);
    $pdf->SetX(138.5);
    // SE ELIGE LA FUENTE
    $pdf->SetFont('helvetica','',4.5);
    if($persona == "Persona Moral")
    {
        $mensaje = $nombre;
    }
    else
    {
        $mensaje = "N/A";
    }
    $pdf->Cell(58, 3, $mensaje, 0, 0, 'L');
    //////////////// SE AÑADE NOMBRE DE CLIENTE O RAZÓN SOCIAL ///////////////

    $carpeta = $root."docs/digitalContracts/".$numContrato;

    if (!file_exists($carpeta)) {
        if (mkdir($carpeta, 0777)) { 
            chmod($carpeta, 0777); 
            $pdf->Output($root."docs/digitalContracts/".$numContrato."/contrato_para_firma_".$numContrato.".pdf", 'F');
        } 
    }


    


?>