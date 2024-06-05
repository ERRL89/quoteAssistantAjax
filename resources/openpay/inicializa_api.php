<?php
    // INSERTAMOS LA BIBLIOTECA DE LA API
    require(dirname(__FILE__) . '/Openpay.php');
    
    ///////////////////// CÓDIGO PARA ACTIVAR EL MODO PRUEBAS //////////////////
    // INSTANCIAMOS CON ID Y LLAVE PRIVADA
    $openpay = Openpay::getInstance('meqbc1rusn21h1gbnwjx', 'sk_8b9b782c303f493a87183dd3dc8bc5ba', 'MX');
    ///////////////////// CÓDIGO PARA ACTIVAR EL MODO PRUEBAS //////////////////
    ///////////////////// CÓDIGO PARA ACTIVAR EL MODO PRODUCCIÓN //////////////////
    // INSTANCIAMOS CON ID Y LLAVE PRIVADA
    /*$openpay = Openpay::getInstance('mmuha4s6gfqtu1qggnfb', 'sk_d553e460ed5547028ca4dd908a95be3f', 'MX');
    Openpay::setProductionMode(true);*/
    ///////////////////// CÓDIGO PARA ACTIVAR EL MODO PRODUCCIÓN ///////////////////
    
    // MERCHANT_ID = moiep6umtcnanql3jrxp
    // PRIVATE_KEY = sk_3433941e467c1055b178ce26348b0fac
    // COUNTRY_CODE = MX (México), CO (Colombia), PE (Peru)
?>