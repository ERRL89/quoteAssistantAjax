<!--Pantalla de agradecimiento con redireccionamiento a formulario de contrato -->
<div class="container-md text-center mt-2 container_form_custom3">
    <h1>¡ Muchas Gracias !</h1>
    <?php
        if($metodoPago==3 && $cardNumber!=""){
            echo "
                 <h4 class='mt-3'>Te hemos enviado tu comprobante de pago y el contrato de servicios al correo que nos proporcionaste.</h4><br>
                 <h6 class='mt-3'>* Si no te aparece revisa en tu bandeja de correo no deseado. *</h6><br>
                 ";
        }
        else if($metodoPago==3 && $cardNumber==""){
            echo "
                 <h4 class='mt-3'>Te hemos enviado el contrato de servicios y datos bancarios para tu depósito o transferencia al correo que nos proporcionaste.<br><br>*No procedio el pago con tarjeta*.</h4><br>
                 <h6 class='mt-3'>* Si no te aparece revisa en tu bandeja de correo no deseado. *</h6><br>
                 <button class='btn btn-primary btn-custom text-center' onClick='uploadFiles()'>SUBIR COMPROBANTE DE PAGO</button>
                 ";
        }
        else{
            echo "
                 <h4 class='mt-3'>Te hemos enviado el contrato de servicios y datos bancarios para tu depósito o transferencia al correo que nos proporcionaste.</h4><br>
                 <h5>DATOS BANCARIOS</h5>
                 <span class='mt-5'>Beneficiario: ACIL MÉXICO, SA DE CV</span><br>
                 <span>Banco: BBVA BANCOMER</span><br>
                 <span>No. Cuenta: 0112204991</span><br>
                 <span>Clabe: 012180001122049911</span><br>
                 <span>Referencia: ".$numContrato."</span><br>
                 <h6 class='mt-3'>* Si no te aparece revisa en tu bandeja de correo no deseado. *</h6><br>
                 <button class='btn btn-primary btn-custom text-center' onClick='uploadFiles()'>SUBIR COMPROBANTE DE PAGO</button>
                 ";
        }
    ?>
   

</div>

<script>
    <?php $nC=base64_encode($numContrato); ?>
    function uploadFiles(){
        location.href = "/<?php echo $folderBase; ?>uploadFiles.php?nC='<?php echo $nC; ?>'"
    }
</script>
