<?php
    require('../../registerUserProcess.php');
?>

<!--Pantalla de agradecimiento con redireccionamiento a formulario de contrato -->
<div class="container-md d-flex justify-content-center align-items-center flex-column mt-4 mb-5 container_form_custom">
    <h3 class="text-center">Ayudanos a confirmar tus datos</h3>
    <div class="container-md text-left mt-4">
        <ul>
        <hr class="line_hr">
            <h5 class="fw-bold">DATOS GENERALES</h5>
        <hr class="line_hr">
                    <li><h6 class="mt-3">Nombre: <?php echo $dataUserPrecontract["nombreDB"];?></h6></li>
                    <li><h6>Dirección: <?php echo $dataUserPrecontract["calleDB"]." ".$dataUserPrecontract["numeroDB"]." ".$dataUserPrecontract["coloniaDB"]." ".$codigoPostal." ".$municipio." ".$estado;?></h6></li>
                    <li><h6>Teléfono: <?php echo $dataUserPrecontract["telefonoDB"];?></h6></li>
                    <li><h6>Email: <?php echo $dataUserPrecontract["emailDB"];?></h6></li>
                    <li><h6 class="">Contacto 1: <?php echo $dataUserPrecontract["contacto1DB"];?></h6></li>
                    <li><h6 class="">Teléfono 1: <?php echo $dataUserPrecontract["telefono1DB"];?></h6></li>
                    <li><h6 class="">Contacto 2: <?php echo $dataUserPrecontract["contacto2DB"];?></h6></li>
                    <li><h6 class="">Teléfono 2: <?php echo $dataUserPrecontract["telefono2DB"];?></h6></li>      
        <hr class="line_hr mt-4">       
            <h5 class="fw-bold">PAQUETE</h5>
        <hr class="line_hr">
                    <li><h6 class="mt-3">Folio: <?php echo $dataUserPrecontract["idPreContratoDB"];?></h6></li>
                    <li><h6>Cotización: <?php echo $dataUserPrecontract["folioCotizacionDB"];?></h6></li>
                    <li><h6>kit: <?php echo $dataUserPrecontract["nombreKitDB"];?></h6></li>
                    <li><h6>Mensualidad: $<?php echo $dataUserPrecontract["mensualidadDB"]; $pagoMensualidad=$dataUserPrecontract["mensualidadDB"]?></h6></li>
                    <li><h6>Metodo de Pago: <?php echo $metodoPagoTxt;?></h6></li> 
        
        <?php
            if($metodoPago==3){
                $totalPagar=$pagoMensualidad*2;
                echo "
                    <hr class='line_hr mt-4'>       
                    <h5 class='fw-bold'>DATOS DE PAGO</h5>
                    <hr class='line_hr'>
                    ";
                    if (isset($tarjeta)) {
                        echo "<li><h6 class='mt-3'>Tarjeta: $tarjeta</h6></li>";
                    }
                    echo "<li><h6>Nombre del Titular: $nameTDC</h6></li>
                          <li><h6>Suscripción Mensual: $$pagoMensualidad</h6></li>
                          <li><h6>Déposito Inicial (Cargo Único): $$pagoMensualidad</h6></li>
                          <li><h6><strong>TOTAL A PAGAR: $$totalPagar</strong></h6></li>
                         "; 
            }
        ?>
        
        </ul>
    </div>

    <div class="container-fluid d-flex justify-content-center align-items-center column-gap-3 mt-5">
        <button class="btn btn-primary btn-custom text-center" onClick="regresar()">REGRESAR</button>
        <?php
            if($metodoPago==3)
            {
                echo "
                     <button class='btn btn-primary btn-custom text-center' onClick='realizarPagoContrato()'>CONFIRMAR</button>
                     <script>
                        function realizarPagoContrato() {
                            let urlPay='idApi=$idAPI'+
                                    '&idPlan=$id_plan'+
                                    '" . (isset($id_tarjeta) ? "&tarjeta=$id_tarjeta" : "") . "' + 
                                    '&numeroCotizacion=$folioCot'+
                                    '&nombre=".$dataUserPrecontract["nombreDB"]."'+
                                    '&calle=".$dataUserPrecontract["calleDB"]."'+
                                    '&numero=".$dataUserPrecontract["numeroDB"]."'+
                                    '&colonia=".$dataUserPrecontract["coloniaDB"]."'+
                                    '&codigoPostal=$codigoPostal'+
                                    '&municipio=$municipio'+
                                    '&estado=$estado'+
                                    '&telefono=$telefono'+
                                    '&email=$email'+
                                    '&kitNum=$kitNum'+
                                    '&kitMensualidad=$kitMensualidad'+
                                    '&acuerdoPago=$acuerdoPago'+
                                    '&modalidad=$modalidad'+
                                    '&frecuenciaPago=$frecuenciaPago'+
                                    '&fechaInicio=$fechaInicio'+
                                    '&contacto1=$contacto1'+
                                    '&telefono1=$telefono1'+
                                    '&contacto2=$contacto2'+
                                    '&telefono2=$telefono2'+
                                    '&metodoPago=$metodoPago';
                            location.href = '/quoteAssistant/paymentConfirmed.php?'+urlPay
                            var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                            modal.show();
                        }
                     </script>
                     "; 
            }
            else
            {
                echo "
                        <button class='btn btn-primary btn-custom text-center' onClick='envioContrato()'>CONFIRMAR</button>
                        <script>
                            function envioContrato() {
                                let urlPay='metodoPago='+$metodoPago+
                                               '&numeroCotizacion=$folioCot'+
                                               '&nombre=".$dataUserPrecontract["nombreDB"]."'+
                                               '&calle=".$dataUserPrecontract["calleDB"]."'+
                                               '&numero=".$dataUserPrecontract["numeroDB"]."'+
                                               '&colonia=".$dataUserPrecontract["coloniaDB"]."'+
                                               '&codigoPostal=$codigoPostal'+
                                               '&municipio=$municipio'+
                                               '&estado=$estado'+
                                               '&telefono=".$dataUserPrecontract["telefonoDB"]."'+
                                               '&email=$email'+
                                               '&kitNum=$kitNum'+
                                               '&kitMensualidad=$kitMensualidad'+
                                               '&acuerdoPago=$acuerdoPago'+
                                               '&modalidad=$modalidad'+
                                               '&frecuenciaPago=$frecuenciaPago'+
                                               '&fechaInicio=$fechaInicio'+
                                               '&contacto1=$contacto1'+
                                               '&telefono1=$telefono1'+
                                               '&contacto2=$contacto2'+
                                               '&telefono2=$telefono2'
                                location.href = '/quoteAssistant/paymentConfirmed.php?'+urlPay
                                var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                                modal.show();
                            }
                        </script>
                     ";
            }
        ?>
    </div>
</div><br>

<script>
    OpenPay.setSandboxMode(true);
    var deviceDataId = OpenPay.deviceData.setup("formId");
    console.log(deviceDataId)
</script>

<script>//Boton de Regresar
    function regresar() {
        window.history.back()
    }
</script>
