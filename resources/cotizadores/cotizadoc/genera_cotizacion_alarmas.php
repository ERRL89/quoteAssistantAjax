<?php
/////////////////// AJUSTES INICIALES ///////////////////
header("Cache-Control: no-cache, must-revalidate");
setlocale(LC_TIME, "spanish");
/////////////////// AJUSTES INICIALES ///////////////////

/////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////
use setasign\Fpdi;

require_once('tcpdf/tcpdf.php');
require_once('fpdi/autoload.php');
/////////////////// SE CARGAN LIBRERIAS PARA EL PDF ///////////////////

/////////////////// VARIABLES INICIALES ///////////////////

include '../conexion/conexion.php';
include '../../../config/config.php';

$usuario=9979;
$cargo="Lider Comercial";
$nb="Mauricio Castillo";
$sucursal=1;

$importe_producto = 0;
$fecha_actual = date('Y-m-d');
$dia = date('d');
$mes = date('m');
$anio = date('y');
$hora = date('G');
$minuto = date('i');
$segundo = date('s');


$cantidad_art_comp = 10;
$complementos = true;
$espaciado_descripcion = 5;
$espaciado_producto = 18;
$espaciado_titulo = 7;
$alinea_descripcion = "C";
$condicion_amarillo = "leasing";
// Variables de pruebas
/*
$cantidad_producto = 1;
$titulo_producto = "Kit de 4 cámaras";
$cantidad_complemento = 1;
$nombre_complemento = 'Acceso remoto';
$precio_complemento_txt = 100;
$importe_complemento_txt = 150;
$importe_complemento = 'prueba';
//$importe_producto = 3000;
//$subtotal_complemento = 12;
*/
/////////////////// VARIABLES INICIALES ///////////////////

///////////////// FUNCIÓN PARA CONVERTIR FECHA EN TEXTO /////////////////
function fechaCastellano($fecha)
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
    return $numeroDia . " de " . $nombreMes . " de " . $anio;
}
///////////////// FUNCIÓN PARA CONVERTIR FECHA EN TEXTO /////////////////

/////////////////// OPERACIONES PARA OBTENER EL CONTENIDO DEL PDF ///////////////////

// $complementos = false;
// $subtotal_complemento = 0;
if($usuario == "1025" || $usuario == "1014")
{
     $superior=$_SESSION['superior'];
     $consulta_usuario = mysqli_query($con, "SELECT * FROM usuarios JOIN vendedores ON usuarios.id_cliente = vendedores.id_cliente WHERE usuarios.id_cliente = '$superior'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
     $datos_usuario = mysqli_fetch_assoc($consulta_usuario);
     $nombre_usuario = $datos_usuario["nombre"];;
     $correo_usuario = $datos_usuario["user"];
 }
 else
 {
     $consulta_usuario = mysqli_query($con, "SELECT * FROM usuarios WHERE id_cliente = '$usuario'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
     $datos_usuario = mysqli_fetch_assoc($consulta_usuario);
     $nombre_usuario = $nb;
     $correo_usuario = $datos_usuario["user"];
 }

// // EXTRACCIÓN DEL FORMULARIO
// $servicio=$_POST['servicio'];
$direccion=$direccionCompleta;
$nombre_cliente=$nombre;
$cotizacion_producto =$kitTxt;

$final=1;

// $cantidad=$_POST['cantidad'];
// // EXTRACCIÓN DEL FORMULARIO

// // DECLARACIÓN DEL TIPO DE SERVICIO

// $condicion_amarillo = "LEASING";
// // DECLARACIÓN DEL TIPO DE SERVICIO


switch($final)
{
    case 1:
        {
            $condicion_pago = "MENSUAL";
            $condicion_amarillo = "leasing";
            $letra_condicion_pago = 12;
            $texto_term = 
            ' 1. Precios cotizados en moneda nacional mas el 16% de IVA.
 2. Se requiere pago de depósito y primera mensualidad al inicio del proyecto para Leasing.
 3. Entrega inmediata.
 4. La garantía normal es por un periodo de 1 año.
 5. Promoción válida durante 15 días a partir de la fecha de cotización.
 6. Los precios cotizados son válidos para una sola orden de compra.
 7. La garantia es por contrato en curso para leasing.
 8. El contrato tiene una vigencia de 36 meses para Leasing.
 ';
            break;
        }
    case 2:
        {
            $condicion_pago = "ANUAL";
            $condicion_amarillo = "leasing";
            $letra_condicion_pago = 12;
            $texto_term = 
            ' 1. Precios cotizados en moneda nacional mas el 16% de IVA.
 2. Se requiere pago de depósito y primera mensualidad al inicio del proyecto para Leasing.
 3. Entrega inmediata.
 4. La garantía normal es por un periodo de 1 año.
 5. Promoción válida durante 15 días a partir de la fecha de cotización.
 6. Los precios cotizados son válidos para una sola orden de compra.
 7. La garantia es por contrato en curso para leasing.
 8. El contrato tiene una vigencia de 36 meses para Leasing.
 ';
            break;
        }
    case 3:
        {
            $condicion_pago = "50% ANTICIPO, 50% AL FINALIZAR EL PROYECTO";
            $condicion_amarillo = "Venta";
            $letra_condicion_pago = 9;
            $texto_term =
    '         1. Precios cotizados en moneda nacional mas el 16% de IVA.
         2. Se requiere depósito bancario del 50% de anticipo para iniciar el proyecto.
         3. Entrega inmediata.
         4. La garantía del equipo es por un periodo de un año condicionado a mantenimientos.
         5. Promoción válida durante 15 días a partir de la fecha de cotización.
         6. Los precios cotizados son válidos para una sola orden de compra.
        ';
            $texto_term_venta =
    '         1. Precios cotizados en moneda nacional mas el 16% de IVA.
         2. Se requiere depósito bancario del 50% de anticipo para iniciar el proyecto.
         3. Entrega inmediata.
         4. La garantía del equipo es por un periodo de un año condicionado a mantenimientos.
         5. Promoción válida durante 15 días a partir de la fecha de cotización.
         6. Los precios cotizados son válidos para una sola orden de compra.
        ';
            break;
        }
    default:
        {
            $condicion_pago = "POR DEFINIR";
            $condicion_amarillo = "Indefinido";
            break;
        }
}

// switch($servicio)
// {
//     case 1: // MONITOREO DE ALARMA
//     {
//         $cotizacion_producto = "MONITOREO DE ALARMA";
//         $espaciado_producto = "20";
//         $espaciado_titulo = "12";
//         $espaciado_descripcion = "8";
//         $alinea_descripcion = "C";
//         $cantidad_producto=$cantidad;
//         $clave_producto = "2112";
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_producto = $lista_productos["nombre"];
//         $descripcion_producto = $lista_productos["descripcion"];
//         $precio = $lista_productos["precio_renta"];
//         $importe_producto = $precio * $cantidad_producto;

//         $precio_txt = number_format($precio, 2, '.', ',');
//         if(is_null($precio_txt))
//         {
//             $precio_txt = "No disponible";
//         }
//         else
//         {
//             $precio_txt = "$ $precio_txt";
//         }

//         $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
//         if(is_null($importe_producto_txt))
//         {
//             $importe_producto_txt = "No disponible";
//         }
//         else
//         {
//             $importe_producto_txt = "$ $importe_producto_txt";
//         }
//         break;
//     }
//     case 2: // MONITOREO DE ALARMA CON VIDEOVERIFICACIÓN
//     {
//         $cotizacion_producto = "MONITOREO DE ALARMA";
//         $espaciado_producto = "20";
//         $espaciado_titulo = "12";
//         $espaciado_descripcion = "8";
//         $alinea_descripcion = "C";
//         $cantidad_producto=$cantidad;
//         $clave_producto = "2113";
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_producto = $lista_productos["nombre"];
//         $descripcion_producto = $lista_productos["descripcion"];
//         $precio = $lista_productos["precio_renta"];
//         $importe_producto = $precio * $cantidad_producto;

//         $precio_txt = number_format($precio, 2, '.', ',');
//         if(is_null($precio_txt))
//         {
//             $precio_txt = "No disponible";
//         }
//         else
//         {
//             $precio_txt = "$ $precio_txt";
//         }

//         $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
//         if(is_null($importe_producto_txt))
//         {
//             $importe_producto_txt = "No disponible";
//         }
//         else
//         {
//             $importe_producto_txt = "$ $importe_producto_txt";
//         }
//         break;
//     }
//     case 3: // MONITOREO OPERATIVO (MONITOREO DE CÁMARAS)
//     {
//         $cotizacion_producto = "MONITOREO OPERATIVO";
//         $espaciado_producto = "35";
//         $espaciado_titulo = "12";
//         $espaciado_descripcion = "23";
//         $alinea_descripcion = "L";
//         $cantidad_producto=$cantidad;
//         if($cantidad_producto > 100)
//         {
//             $clave_producto = "2115";
//         }
//         else
//         {
//             $clave_producto = "2114";
//         }
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_producto = $lista_productos["nombre"];
//         $descripcion_producto = $lista_productos["descripcion"];
//         $precio = $lista_productos["precio_renta"];
//         $importe_producto = $precio * $cantidad_producto;

//         $precio_txt = number_format($precio, 2, '.', ',');
//         if(is_null($precio_txt))
//         {
//             $precio_txt = "No disponible";
//         }
//         else
//         {
//             $precio_txt = "$ $precio_txt";
//         }

//         $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
//         if(is_null($importe_producto_txt))
//         {
//             $importe_producto_txt = "No disponible";
//         }
//         else
//         {
//             $importe_producto_txt = "$ $importe_producto_txt";
//         }
//         break;
//     }
//     case 4: // ACIL Contigo
//     {
//         $cotizacion_producto = "ACIL Contigo";
//         $espaciado_producto = "20";
//         $espaciado_titulo = "12";
//         $espaciado_descripcion = "8";
//         $alinea_descripcion = "C";
//         $tipo_plan=$_POST['tipo_plan'];
//         $cantidad_producto=$cantidad;
//         switch($tipo_plan)
//         {
//             case 1:
//                 $clave_producto = "2116";
//                 break;
//             case 2:
//                 $clave_producto = "2117";
//                 $condicion_pago = "ANUAL";
//                 break;
//         }
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_producto = $lista_productos["nombre"];
//         $descripcion_producto = $lista_productos["descripcion"];
//         $precio = $lista_productos["precio_renta"];
//         $importe_producto = $precio * $cantidad_producto;

//         $precio_txt = number_format($precio, 2, '.', ',');
//         if(is_null($precio_txt))
//         {
//             $precio_txt = "No disponible";
//         }
//         else
//         {
//             $precio_txt = "$ $precio_txt";
//         }

//         $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
//         if(is_null($importe_producto_txt))
//         {
//             $importe_producto_txt = "No disponible";
//         }
//         else
//         {
//             $importe_producto_txt = "$ $importe_producto_txt";
//         }
//         break;
//     }
//     case 5: // ACIL Guard
//     {
//         $cotizacion_producto = "ACIL Guard";
//         $espaciado_producto = "20";
//         $espaciado_titulo = "12";
//         $espaciado_descripcion = "8";
//         $alinea_descripcion = "C";
//         $tipo_plan=$_POST['tipo_plan'];
//         $cantidad_producto=$cantidad;
//         switch($tipo_plan)
//         {
//             case 1:
//                 $clave_producto = "2118";
//                 break;
//             case 2:
//                 $clave_producto = "2119";
//                 $condicion_pago = "ANUAL";
//                 break;
//         }
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_producto = $lista_productos["nombre"];
//         $descripcion_producto = $lista_productos["descripcion"];
//         $precio = $lista_productos["precio_renta"];
//         $importe_producto = $precio * $cantidad_producto;

//         $precio_txt = number_format($precio, 2, '.', ',');
//         if(is_null($precio_txt))
//         {
//             $precio_txt = "No disponible";
//         }
//         else
//         {
//             $precio_txt = "$ $precio_txt";
//         }

//         $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
//         if(is_null($importe_producto_txt))
//         {
//             $importe_producto_txt = "No disponible";
//         }
//         else
//         {
//             $importe_producto_txt = "$ $importe_producto_txt";
//         }
//         break;
//     }
//     case 6: // ACIL Cleaner
//     {
//         $cotizacion_producto = "ACIL Cleaner";
//         $espaciado_producto = "20";
//         $espaciado_titulo = "12";
//         $espaciado_descripcion = "8";
//         $alinea_descripcion = "C";
//         $tipo_plan=$_POST['tipo_plan'];
//         $cantidad_producto=$cantidad;
//         switch($tipo_plan)
//         {
//             case 1:
//                 $clave_producto = "2120";
//                 break;
//             case 2:
//                 $clave_producto = "2121";
//                 $condicion_pago = "ANUAL";
//                 break;
//         }
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_producto = $lista_productos["nombre"];
//         $descripcion_producto = $lista_productos["descripcion"];
//         $precio = $lista_productos["precio_renta"];
//         $importe_producto = $precio * $cantidad_producto;

//         $precio_txt = number_format($precio, 2, '.', ',');
//         if(is_null($precio_txt))
//         {
//             $precio_txt = "No disponible";
//         }
//         else
//         {
//             $precio_txt = "$ $precio_txt";
//         }

//         $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
//         if(is_null($importe_producto_txt))
//         {
//             $importe_producto_txt = "No disponible";
//         }
//         else
//         {
//             $importe_producto_txt = "$ $importe_producto_txt";
//         }
//         break;
//     }
//     case 7: // ACIL GPS
//     {
//         $cotizacion_producto = "ACIL GPS";
//         $espaciado_producto = "30";
//         $espaciado_titulo = "12";
//         $espaciado_descripcion = "18";
//         $alinea_descripcion = "L";
//         $cantidad_producto=$cantidad;
//         $clave_producto = "2122";
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_producto = $lista_productos["nombre"];
//         $descripcion_producto = $lista_productos["descripcion"];
//         $precio = $lista_productos["precio_renta"];
//         $importe_producto = $precio * $cantidad_producto;

//         $precio_txt = number_format($precio, 2, '.', ',');
//         if(is_null($precio_txt))
//         {
//             $precio_txt = "No disponible";
//         }
//         else
//         {
//             $precio_txt = "$ $precio_txt";
//         }

//         $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
//         if(is_null($importe_producto_txt))
//         {
//             $importe_producto_txt = "No disponible";
//         }
//         else
//         {
//             $importe_producto_txt = "$ $importe_producto_txt";
//         }

//         $complementos = true;
//         $cantidad_art_comp = 1;
//         $cantidad_complemento = $cantidad;

//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '2131'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_complemento = $lista_productos["nombre"];
//         $descripcion_complemento = $lista_productos["descripcion"];
//         $precio_complemento = $lista_productos["precio_renta"];
//         $importe_complemento = $precio_complemento * $cantidad_complemento;

//         $precio_complemento_txt = number_format($precio_complemento, 2, '.', ',');
//         if(is_null($precio_complemento_txt))
//         {
//             $precio_complemento_txt = "No disponible";
//         }
//         else
//         {
//             $precio_complemento_txt = "$ $precio_complemento_txt";
//         }

//         $importe_complemento_txt = number_format($importe_complemento, 2, '.', ',');
//         if(is_null($importe_complemento_txt))
//         {
//             $importe_complemento_txt = "No disponible";
//         }
//         else
//         {
//             $importe_complemento_txt = "$ $importe_complemento_txt";
//         }
//         break;
//     }
//     case 8: // ACIL On Time
//     {
//         $cotizacion_producto = "ACIL ON TIME";
//         $espaciado_producto = "30";
//         $espaciado_titulo = "12";
//         $espaciado_descripcion = "18";
//         $cantidad_producto=$cantidad;
//         $clave_producto = "2123";
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '$clave_producto'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_producto = $lista_productos["nombre"];
//         $descripcion_producto = $lista_productos["descripcion"];
//         $precio = $lista_productos["precio_renta"];
//         $importe_producto = $precio * $cantidad_producto;

//         $precio_txt = number_format($precio, 2, '.', ',');
//         if(is_null($precio_txt))
//         {
//             $precio_txt = "No disponible";
//         }
//         else
//         {
//             $precio_txt = "$ $precio_txt";
//         }

//         $importe_producto_txt = number_format($importe_producto, 2, '.', ',');
//         if(is_null($importe_producto_txt))
//         {
//             $importe_producto_txt = "No disponible";
//         }
//         else
//         {
//             $importe_producto_txt = "$ $importe_producto_txt";
//         }

//         $complementos = true;
//         $cantidad_art_comp = 1;
//         $alumnos = $cantidad;
//         $cantidad_complemento = 0;
//         while($alumnos >= 1)
//         {
//             $alumnos = $alumnos - 250;
//             $cantidad_complemento++;
//         }
//         $consulta_productos = mysqli_query($con, "SELECT * FROM productos WHERE id_producto = '2111'") or die('Consulta 1 fallida: ' . mysqli_error($con));	    
//         $lista_productos = mysqli_fetch_assoc($consulta_productos);
//         $nombre_complemento = $lista_productos["nombre"];
//         $descripcion_complemento = $lista_productos["descripcion"];
//         $precio_complemento = $lista_productos["precio_renta"];
//         $importe_complemento = $precio_complemento * $cantidad_complemento;

//         $precio_complemento_txt = number_format($precio_complemento, 2, '.', ',');
//         if(is_null($precio_complemento_txt))
//         {
//             $precio_complemento_txt = "No disponible";
//         }
//         else
//         {
//             $precio_complemento_txt = "$ $precio_complemento_txt";
//         }

//         $importe_complemento_txt = number_format($importe_complemento, 2, '.', ',');
//         if(is_null($importe_complemento_txt))
//         {
//             $importe_complemento_txt = "No disponible";
//         }
//         else
//         {
//             $importe_complemento_txt = "$ $importe_complemento_txt";
//         }

//         break;
//     }

//     default: // SIN DEFINIR
//     {
//         $condicion_pago = "SIN DEFINIR";
//         $condicion_amarillo = "N/A";
//         break;
//     }
// }
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
if($sucursal == '9999')
{
    $sucursal = 1;
}
$nombre_hoja = "hoja_".$sucursal.".pdf";
$pagecount = $pdf->setSourceFile("../cotizadoc/$nombre_hoja");
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
$pdf->SetFont('helvetica', '', 10.5);
// WRITEHTMLCELL permite crear una celda en la que podemos insertar código HTML y de esta forma hacer un texto más dinámico
//$pdf->writeHTMLCell(W, H, 'X', 'Y', $html, border, line, fill, reseth, 'align', autopadding);

/*$html = "MARGEN INICIAL (1.5cm) 4.3cm de alto";
    $pdf->writeHTMLCell(186, 5, '', '', $html, 1, 0, 0, TRUE, 'J', TRUE);*/

// REAJUSTE DE COORDENADAS (DESPLAZAMIENTO ENTRE LA HOJA)
$pdf->SetY(50);
$pdf->SetX(15);
// SE PUEDE CAMBIAR LA FUENTE, Y TAMAÑO VOLVIENDO A USAR EL COMANDO SETFONT
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(186, 10, "COTIZACIÓN", 0, 0, 'R');

// BOTON DE CONTRATAR
//Array asociativo para armar url hacia formulario de contrato desde boton COTIZAR en PDF
$urlParams = array(
    'nombre' => $nombreCodificado,
    'calle' => $calleCodificado,
    'numero' => $numeroCodificado,
    'colonia' => $coloniaCodificado,
    'kitNum' => $kitNum,
    'kit' => $kitCodificado,
    'kitPrice' => $kitPriceCodificado,
    'folioCotizacion' => $folio_cotizacion,
    'idUsuario' => $usuario
);

$queryString = http_build_query($urlParams);
$url = $routeAcil."closeContract.php?".$queryString;
$pdf->Link(140, 20, 61, 17, $url);

$pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(202, 93, 35)));
$pdf->SetFillColor(202, 93, 35);
$pdf->RoundedRect(140, 20, 61, 17, 5, '1111', 'DF');// Posición x, posición y, ancho, alto

// Agregar texto superpuesto
$pdf->SetFont('helvetica', 'B', 17);
$pdf->SetTextColor(255, 255, 255); // Color blanco para el texto
$pdf->SetXY(137, 25); // Posición x, posición y
$pdf->Cell(0, 0, 'CONTRATAR', 0, 1, 'C');



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
$pdf->Cell(80, 6, "NÚMERO DE COTIZACIÓN", 0, 0, 'R', TRUE);
////// SECCIÓN RECTANGULO NARANJA 01 //////

////// SECCIÓN RECTANGULO AMARILLO 01 //////
$pdf->SetY(71);
$pdf->SetX(121);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(253, 255, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(80, 6, "$folio_cotizacion", 0, 0, 'R', TRUE);
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
$pdf->SetFont('helvetica', 'B', $letra_condicion_pago);
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

$fecha_actual = fechaCastellano($fecha_actual);
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
$pdf->Cell(30, 6, 'Cantidad', 0, 0, 'C');

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
$pdf->Cell(30, 6, 'P.Unitario', 0, 0, 'C');

$pdf->SetY(95);
$pdf->SetX(170);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(31, 6, 'Importe', 0, 0, 'C');
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
$altura_concepto = 89;
$altura_articulo = 100;
$altura_descripcion = 119;
// INFORMACIÓN PARA PRUEBAS //

///////// COMIENZA CONTENIDO /////////
// //// CANTIDAD //////
// $pdf->SetY(104);
// $pdf->SetX(15);
// $pdf->SetFont('helvetica','',10);
// $pdf->Cell(30, $espaciado_producto, "$cantidad_producto", 0,0,'C');
// //// CANTIDAD //////

// //// DESCRIPCIÓN (ARTÍCULO) //////
// $pdf->SetY(107);
// $pdf->SetX(45);
// $pdf->SetFont('helvetica','B',8);
// $pdf->MultiCell(95, $espaciado_titulo, "$titulo_producto",1, 'C', 0, 0, '', '', true, 0, false, true, $espaciado_titulo, 'M');
// //// DESCRIPCIÓN (ARTÍCULO) //////

// //// DESCRIPCIÓN (DESCRIPCIÓN) //////
// $pdf->SetY(114);
// $pdf->SetX(45);
// $pdf->SetFont('helvetica','B',8);
// $pdf->MultiCell(95, $espaciado_descripcion, '$descripcion_producto', 1, $alinea_descripcion, 0,0,'','',true,0,false,true,$espaciado_descripcion,'M');
// //// DESCRIPCIÓN (DESCRIPCIÓN) //////

// //// PRECIO UNITARIO //////
// $pdf->SetY(104);
// $pdf->SetX(140);
// $pdf->SetFont('helvetica','B',8);
// $pdf->MultiCell(30, $espaciado_producto, '$precio_txt', 0, 'C', 0,0,'','',true,0,false,true,$espaciado_producto,'M');
// //// PRECIO UNITARIO //////

// //// PRECIO UNITARIO //////
// $pdf->SetY(104);
// $pdf->SetX(170);
// $pdf->SetFont('helvetica','B',8);
// $pdf->MultiCell(31, $espaciado_producto, '$importe_producto_txt', 0, 'C', 0,0,'','',true,0,false,true,$espaciado_producto,'M');
// //// PRECIO UNITARIO //////

$altura_concepto = $altura_concepto + $espaciado_producto;
$altura_descripcion = $altura_concepto + $espaciado_titulo;
$llenado = false;
$pdf->SetFillColor(216, 217, 215);
///////////// TERMINA PRODUCTO PRINCIPAL ///////////////

$control_extras = 0;

if ($complementos == true) {


    
    
    switch($final)
    {
    case 1:
        {
            include 'agrega_hoja.php';
            break;
        }
    case 2:
        {
            include 'agrega_hoja.php';
            break;
        }
    case 3:
        {
            include 'agrega_hoja.php';
            break;
        }
    default:
        {
           include 'agrega_hoja.php';
            break;
        }
    }
    

}

/////// TERMINA CONTENIDO /////////

///////// INICIA FOOTER /////////

$altura_footer = $altura_concepto;
$altura_subtotal = $altura_footer;
$altura_iva = $altura_subtotal + 6;
$altura_total = $altura_iva + 6;

$subtotal = $importe_producto + $subtotal_complemento;

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


if($final == 3)
{
    include "mantenimientoHoja.php";
    
    // ENVIA EL PDF A DESPLEGARSE EN PANTALLA
    // SE PUEDE PONER EL NOMBRE DEL ARCHIVO PARA GUARDADO
    $pdf->Output("cotizacion.pdf", 'I');
}
else
{
    // ENVIA EL PDF A DESPLEGARSE EN PANTALLA
    // SE PUEDE PONER EL NOMBRE DEL ARCHIVO PARA GUARDADO
    $pdf->Output("cotizacion.pdf", 'I');
}


