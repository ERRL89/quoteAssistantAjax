<!--Pantalla de agradecimiento con redireccionamiento a formulario de contrato -->
<div id="formRegister">
    <div class="container-md d-flex justify-content-center align-items-center flex-column mt-4 mb-5 container_form_custom">
        <h3 class="text-center">Revisa tus datos</h3>
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
                if($metodoPago==3)
                {
                    $totalPagar=$pagoMensualidad*2;
                    echo "
                        <hr class='line_hr mt-4'>       
                        <h5 class='fw-bold'>DATOS DE PAGO</h5>
                        <hr class='line_hr'>
                        ";
                        if (isset($tarjeta))
                        {
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
            <?php
                echo "
                    <button class='btn btn-primary btn-custom text-center' onClick='paymentConfirmedProcess();'>CONFIRMAR</button>  
                    ";
            ?>   
        </div>
    </div><br>
</div>

<!-- BARRA DE PROGRESO -->
<div id="progressBar">
    <div class="">
        <div class="w-100 h-100">
            <div class="form-signin divCenter mt-4">
                <div class="cajalogin divCenter">
                    <div class="progress" style="width:75%;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="texto-sesion text-center">
                        <h3>Procesando ...</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    $("#progressBar").hide()
  })
</script>

<script>
    OpenPay.setSandboxMode(true);
    var deviceDataId = OpenPay.deviceData.setup("formId");
    console.log(deviceDataId)
</script>

<script>
    function paymentConfirmedProcess()
    {
        $('#formRegister').hide()
        $('#progressBar').show()
        $.ajax({
            url: 'paymentConfirmedProcess.php',
            type: 'POST',
            data: 
            {
                root:           '<?php echo $root;                                 ?>',
                idAPI:          '<?php echo isset($idAPI)      ? $idAPI      : ''; ?>',
                idPlan:         '<?php echo isset($id_plan)    ? $id_plan    : ''; ?>',
                tarjeta:        '<?php echo isset($id_tarjeta) ? $id_tarjeta : ''; ?>',
                deviceSessionId:'<?php echo $deviceSessionId;?>',
                metodoPago:     '<?php echo $metodoPago;     ?>',
                folioCot:       '<?php echo $folioCot;       ?>',
                nombre:         '<?php echo $nombre;         ?>',
                calle:          '<?php echo $calle;          ?>',
                numero:         '<?php echo $numero;         ?>',
                colonia:        '<?php echo $colonia;        ?>',
                codigoPostal:   '<?php echo $codigoPostal;   ?>',
                estado:         '<?php echo $estado;         ?>',
                municipio:      '<?php echo $municipio;      ?>',
                telefono:       '<?php echo $telefono;       ?>',
                email:          '<?php echo $email;          ?>',
                rfc:            '<?php echo $rfc;            ?>',
                direccionF:     '<?php echo $direccionF;     ?>',
                cpFiscal:       '<?php echo $cpFiscal;       ?>',
                regimen:        '<?php echo $regimen;        ?>',
                cfdi:           '<?php echo $cfdi;           ?>',
                kitNum:         '<?php echo $kitNum;         ?>',
                kitMensualidad: '<?php echo $kitMensualidad; ?>',
                acuerdoPago:    '<?php echo $acuerdoPago;    ?>',
                modalidad:      '<?php echo $modalidad;      ?>',
                frecuenciaPago: '<?php echo $frecuenciaPago; ?>',
                fechaInicio:    '<?php echo $fechaInicio;    ?>',
                contacto1:      '<?php echo $contacto1;      ?>',
                telefono1:      '<?php echo $telefono1;      ?>',
                contacto2:      '<?php echo $contacto2;      ?>',
                telefono2:      '<?php echo $telefono2;      ?>'
            },
            success: function(result)
            {
                $('#progressBar').hide()
                $('#principal').html(result);
            }
        });
    }
</script>
