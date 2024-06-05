<?php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    $rootCotizador = $root."resources/cotizadores/cotizador_mixto/";
    $folderBaseCotizador = "/".$folderBase."resources/cotizadores/cotizador_mixto/";
    $quoteMakerPromos = "/".$folderBase."areas/quoteMakerPromos.php";

    echo "
    <link href='/{$folderBase}css/acil/cssCotizador.css' rel='stylesheet' type='text/css' />
    <script src='$folderBaseCotizador/js/cotizador_servicio_aot.js'></script>
    <script>
        function addRange()
        {
            if($('#combo1').is(':checked'))
            {
                //console.log('Se detectó el combo 1');
                $('#range').hide();
                $('#comboUnits').show();
                $('#rooms').removeClass('valid');
                $('#meters').removeClass('valid');
                $('#levels').removeClass('valid');
            }
            if($('#combo2').is(':checked'))
            {
                //console.log('Se detectó el combo 2');
                $('#range').hide();
                $('#comboUnits').show();
                $('#rooms').removeClass('valid');
                $('#meters').removeClass('valid');
                $('#levels').removeClass('valid');
            }
            if($('#combo3').is(':checked'))
            {
                //console.log('Se detectó el combo 2');
                $('#range').hide();
                $('#comboUnits').show();
                $('#rooms').removeClass('valid');
                $('#meters').removeClass('valid');
                $('#levels').removeClass('valid');
            }
            if($('#combo4').is(':checked'))
            {
                //console.log('Se detectó el combo 2');
                $('#range').hide();
                $('#comboUnits').show();
                $('#rooms').removeClass('valid');
                $('#meters').removeClass('valid');
                $('#levels').removeClass('valid');
            }
            
        }
    </script>
    ";
?>

<div class="container-sm px-5 border">
    <h3 class="text-center">Asistente de Cotización</h3>
    <form id="signUpForm" action="<?php echo $folderBaseCotizador; ?>crea_cotizacion.php" method="POST" name="signUpForm" target="_blank" class="p-4">
    <input type='hidden' name='servicio' value='8'>
    <!-- start step indicators -->
    <div class="form-header d-flex mb-4">
        <span class="stepIndicator">Paso 1</span>
        <span class="stepIndicator">Paso 2</span>
        <span class="stepIndicator">Paso 3</span>
        <span class="stepIndicator">Paso 4</span>
    </div>
    <!-- end step indicators -->
    <?php include 'includes/camaras_preguntas/seccion_datos.php' ?>
    <!-- step 1 Seccion de camaras -->
    <?php include 'includes/camaras_preguntas/seccion_kit.php' ?>
    <?php include 'includes/camaras_preguntas/seccion_dimensiones.php' ?>
    <?php //include 'includes/camaras_preguntas/seccion_extras.php' ?>
    <?php include 'includes/camaras_preguntas/seccion_final.php' ?>

    <!-- start previous / next buttons -->
    <div class="form-footer d-flex">
        <button type="button" id="prevBtn" class="firstNext next" onclick="nextPrev(-1)">Anterior</button>
        <button type="button" id="nextBtn" onclick="nextPrev(1)">Siguiente</button>
        <button type="button" id="submitBtn" onclick="enviarForm()">Mostrar Cotización</button>
        <button type="button" id="reload" onclick="reloader()" class="reiniciar">Reiniciar Formulario</button>
    </div>
    <!-- end previous / next buttons -->
    </form>
</div>


<script>cotizadorCOMBOS()</script>