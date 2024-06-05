<!--Pantalla de error en tarjeta -->
<div class='container-md d-flex justify-content-center align-items-center flex-column text-center mt-5 mb-5 container_form_custom'>
<h1>¡ Lo sentimos !</h1>

<?php
    if($codigoError==3001){
        echo "
              <h4 class='mt-3'>La tarjeta fue rechazada.</h4><br>
             ";
    }
    else if($codigoError==3002){
        echo "
              <h4 class='mt-3'>La tarjeta ha expirado.</h4><br>
             ";
    }
    else if($codigoError==3003){
        echo "
              <h4 class='mt-3'>La tarjeta no tiene fondos suficientes.</h4><br>
             ";
    }
    else if($codigoError==3004){
        echo "
              <h4 class='mt-3'>La tarjeta ha sido identificada como una tarjeta robada.</h4><br>
             ";
    }
    else if($codigoError==3005){
        echo "
              <h4 class='mt-3'>La tarjeta ha sido rechazada por el sistema antifraudes.</h4><br>
             ";
    }
    else{
        echo "
              <h4 class='mt-3'>Error con Tarjeta.</h4><br>
             ";
    }
?>

<h6 class='mt-3'>* Comunicate con tu Banco o vuelve a intentarlo *</h6><br>
<button class='btn btn-primary btn-custom text-center' onClick='retryPay()'>REGRESAR</button>
</div><br><div class='mt-3'></div>

<script>
    function retryPay(){
        window.history.back()
    }
</script>
