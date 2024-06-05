<?php
    header('Cache-Control: no-cache, no-store, must-revalidate');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" sizes="120x120" href="../../recursos/favicons/apple-icon-120x120.png">
    <!-- Llamado a los estilos necesarios  -->

    <link href="css/cotizadorcamaras.css" rel="stylesheet" type="text/css" />
    <link href="css/form.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/r-2.2.9/sc-2.0.5/datatables.min.css" />
    <script src="https://kit.fontawesome.com/b56eda6614.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <!-- Fin de llamado a los estilos necesarios  -->

    <title>Cotizador Kits</title>

    <style>
        #menu_lateral a {
            color: white !important;
        }

        #menu_lateral a:hover {
            color: orange !important;
        }

        #menu_lateral a:active {
            color: orange !important;
        }

        @media(max-width: 991px) {
            #menu_lateral {
                height: auto !important;
            }

            #boton_menu {
                color: red;
            }
        }

        .cajacontenido {
            display: block;
            width: 80vw;
            height: 75vh;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <?php include 'biblioteca_nuevo.php' ?>
    <div class="row" style="padding:0px; margin:0px;">
        <!--header-->
        <?php include 'includes/header_nuevo.php' ?>
        <!-- Llamada a menú lateral  -->
        <div  id="menu_lateral">
            <!-- Menu -->
            <div class="row">
                <!--MENU -->
                <?php // include 'includes/menu_nuevo.php' ?>
                <!-- Termina llamada a menú lateral  -->
                <!-- Comienza contenido principal  -->
                <!--<div class="container" style="width:75%; border: 1px solid red;" >-->
                
                    <form id="signUpForm" action="crea_cotizacion.php" method="POST" name="signUpForm" target="_blank">
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
        </div>
    </div>
    <!--Js-->
    <!-- Comienzan scripts necesarios  -->

    <script  >
        var url = 'cotizador_servicio_aot.js';
        var time = new Date().getTime();
        var urlTime = 'js/' + url + '?t=' + time;
        let script = document.createElement('script');
        script.src = urlTime;
        document.head.append(script);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!-- Terminan scripts necesarios  -->
</body>

</html>