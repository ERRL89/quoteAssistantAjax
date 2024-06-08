<!-- Define llamado a ruta de proceso de carga de documentación -->
<?php

  if(isset($_POST['root'])){
    $root=$_POST['root'];
  }

  include_once($root."config/config.php");
  include_once($root."config/dbConf.php");

  if(isset($_POST['numContrato'])){
    $numContrato=$_POST['numContrato'];
  }

  $db=conexionPdo();
  //Consulta pa extraer id de cliente
  $consultaStr="SELECT cliente FROM precontratos WHERE num_contrato=?";
  $consulta=$db->prepare($consultaStr);
  $consulta->execute([$numContrato]);
  $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
    $cliente=$dataConsulta["cliente"];

  //Consulta para extraer datos fiscales de cliente
  $consultaStr="SELECT * FROM clientes WHERE id_cliente=?";
  $consulta=$db->prepare($consultaStr);
  $consulta->execute([$cliente]);
  $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
    $rfc=$dataConsulta["rfc"];
    $direccionFiscal=$dataConsulta["direccion_fiscal"];
    $cp=$dataConsulta["codigo_postal"];
    $regimenFiscal=$dataConsulta["regimen_fiscal"];
    $usoCFDI=$dataConsulta["uso_cfdi"];

  //Consulta para extraer tabla de regimen fiscal
  $consultaStr="SELECT * FROM cfdi_regimen_fiscal";
  $consulta=$db->prepare($consultaStr);
  $consulta->execute();
  if ($consulta->rowCount() > 0) {
    $numRegimen=0;
    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC))
    {
        $claveRegimen[$numRegimen] = $fila['clave'];
        $descripcionRegimen[$numRegimen] = $fila['descripcion'];
        $numRegimen+=1;
    }
  }

    //Consulta para extraer tabla de uso de CFDI
    $consultaStr="SELECT * FROM cfdi_uso";
    $consulta=$db->prepare($consultaStr);
    $consulta->execute();
    if ($consulta->rowCount() > 0) {
      $numCFDI=0;
      while ($fila = $consulta->fetch(PDO::FETCH_ASSOC))
      {
          $claveCFDI[$numCFDI] = $fila['clave'];
          $descripcionCFDI[$numCFDI] = $fila['descripcion'];
          $numCFDI+=1;
      }
    }

    
#DEFINICION DE PARAMETROS A ENVIAR EN FUNCIÓN
  $inputForm = "form";
  $routeProcess = "/{$folderBase}uploadFilesProcess.php";
  $generalCanvas = "principal";
  $table = "";
  $elementsToHide = "texto"; //Se deben separar con comas los elementos debido a que se ingresan en un array
  $optionalFunction = "function() { launchForm(); }";

#CONSTRUCCIÓN DE FUNCIÓN
  $functionParameters = " 
    getProcessForm(
        '{$inputForm}',  
        '{$routeProcess}', 
        '{$generalCanvas}', 
        '{$table}', 
        '{$elementsToHide}', 
        {$optionalFunction}
     );
                        ";

  //Variables que reciban si ya fue cargado el archivo correspondiente para control de boton Validacion
  $constancia=0;
  $domicilio=0;
  $identificacion=0;
  $pago=0;
  $contrato=0;

  //Funcion que valida ruta de documentos, asigna enlace a documentos 7 retira leyendas de advertencia 
  function validateFile($name, $numero){
        global $numContrato, $root, $folderBase, $domicilio, $identificacion, $pago, $contrato, $constancia;
        $archivo = $name.$numContrato.".pdf";
            $rutaArchivo = $root."docs/digitalContracts/".$numContrato."/".$archivo;
            if (file_exists($rutaArchivo)) {
                if($numero==0){
                    echo "<a href='/".$folderBase."docs/digitalContracts/".$numContrato."/".$archivo."'target='_blank'>[".$name."".$numContrato.".pdf]</a>";

                    if($name=="comprobante_domicilio_"){ $domicilio=1; }
                    //if($name=="identificacion_oficial_"){ $identificacion=1; }
                    if($name=="comprobante_pago_"){ $pago=1; }
                    //if($name=="contrato_"){ $contrato=1; }
                    if($name=="constancia_situacion_fiscal_"){ $constancia=1; }
                }
                //Elimina leyenda de ADVERTENCIA Limite de Carga cuando ya se detecto la carga del archivo
                else if($numero==1){ echo ""; }
                
            } else {
                if($numero==0){
                    echo "No se ha cargado el archivo.";
                } 
                if($numero==1){
                    //Agrega leyenda de ADVERTENCIA Limite de Carga cuando ya se detecto la carga del archivo
                    echo "¡ADVERTENCIA! Límite por archivo: 4MB - Archivos más pesados no se subirán.";
                } 
            } 
    }
?>

<!-- Formulario para carga de Documentos -->
<div class="mb-5" id=uploadForm><br>
  <h2 class="text-center" id="texto">Sube tus Documentos</h2>
  <form id="form" class="mb-5" action="" method="post" enctype="multipart/form-data" onchange="checkFileSize(this)" novalidate>
    <div class="container-sm container_form_custom">

      <!-- -------  NUMERO DE CONTRATO y NUMERO DE CLIENTE EN FORM OCULTOS  ---------------------------- -->
      <input type="hidden" name="numContrato" id="nc" class="form-control" value="<?php echo $numContrato;?>"/>
      <input type="hidden" name="cliente" id="cliente" class="form-control" value="<?php echo $cliente;?>"/>

      <!-- ------------------------CARGA DE COMPROBANTE DE DOMICILIO---------------------------- -->
      <label for="domicilio" class="form-label label-custom">Comprobante de Domicilio</label>
      <label id="comprobante_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("comprobante_domicilio_",0);?>
      </label>
      <input type="file" name="domicilio" id="domicilio" class="form-control" accept=".pdf"/>
      <div id='advertencia1' class='form-text' style='color: red;'>
        <?php validateFile("comprobante_domicilio_",1);?>
      </div><br>
     
      <!-- --------------------------CARGA DE COMPROBANTE DE PAGO---------------------------- -->
      <label for="pago" class="form-label label-custom">Comprobante de Pago</label>
      <label id="pago_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("comprobante_pago_",0);?>
      </label>
      <input type="file" name="pago" id="pago" class="form-control" accept=".pdf"/>
      <div id='advertencia3' class='form-text' style='color: red;'>
        <?php validateFile("comprobante_pago_",1);?>
      </div><br>
      
      <!-- Leyenda Datos Fiscales -->
      <div class="text-center">
        <div class="row">
            <div class="col-md-12">
                <hr class="line_hr"><p class="label-custom fs-5">DATOS FISCALES</p><hr class="line_hr">
            </div>
        </div>
      </div>

      <!-- Checkbox EDITAR -->
      <div class="container-fluid d-flex justify-content-end align-items-center">
        <label class="mt-1 form-label label-custom" for="editar">Editar</label>
        <div class="form-check">
          <input class="text-center check-custom" type="checkbox" id="editar" value="1">
        </div>
      </div>

      <div class="mb-3"><!-- RFC/Direccion -->
        <div class="row mb-3">
            <div class="col-md-6"><!-- RFC -->
              <label for="rfc" class="form-label label-custom">RFC:</label>
              <input type="text" class="form-control sinBotonera" id="rfc" name="rfc" value="<?php if(isset($rfc)){echo $rfc;}?>" disabled required>
              <div class="invalid-feedback">Introduce RFC debe contener 13 digitos</div>
            </div>
            <div class="col-md-6"><!-- Dirección -->
              <label for="direccion" class="form-label label-custom">Dirección:</label>
              <input type="text" class="form-control" id="direccion" name="direccion" value="<?php if(isset($direccionFiscal)){echo $direccionFiscal;}?>" disabled required>
              <div class="invalid-feedback">Introduce tu dirección</div>
            </div>
        </div>
      </div>

      <div class="mb-3"><!-- CP/Regimen Fiscal/CP -->
        <div class="row mb-3">
            <div class="col-md-4"><!-- CP -->
                <p class="label-custom">Codigo Postal:</p>
                <input type="number" id="cp" name="cp" class="form-control" value="<?php if(isset($cp)){echo $cp;}?>" minlength="5" disabled required>
            </div>
            <div class="col-md-4"><!-- Regimen Fiscal -->
                <p class="label-custom">Regimen Fiscal:</p>
                <select class="form-select" name="regimenFiscal" id="regimen" aria-label="Default select example" disabled required>
                </select>
            </div>
            <div class="col-md-4"><!-- Uso de CFDI -->
                <p class="label-custom">Uso de CFDI:</p>
                <select class="form-select" name="usoCFDI" id="cfdi" aria-label="Default select example" disabled required>
                </select>
            </div>
        </div>
      </div>

    <!-- --------------------------CARGA DE CONSTANCIA DE SITUACION FISCAL---------------------------- -->
      <div id="constancia"><label for="file" class="mt-3 form-label label-custom">Constancia de Situación Fiscal</label>
      <label id="constancia_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("constancia_situacion_fiscal_",0);?>
      </label>
      <input type="file" name="constanciaFiscal" id="constanciaFiscal" class="form-control" accept=".pdf"/>
      <div id='advertencia5' class='form-text' style='color: red;'>
        <?php validateFile("constancia_situacion_fiscal_",1);?>
      </div></div><br><br>
      <!-- ---------Se asigna boton para subir archivos se actualiza de acuerdo a cada carga---------- -->
      <div class="container-fluid d-flex justify-content-center align-items-center flex-wrap mb-3">
        <?php
              //Se asigna boton para subir archivos se actualiza de acuerdo a cada carga
              $btn="
                      <center><input id='btnEnviar' class='btn btn-primary btn-custom text-center mr-3 mt-2' type='button' value='Actualizar información' 
                      onclick=\"{$functionParameters}\" disabled/></center>
              ";echo $btn;

              //Se asigna boton de enviar a validacion, se dibuja de acuerdo al siguiente IF
              if($domicilio==1 && $pago==1){
                  $btn2="
                      <div style='width: 10px;'></div>
                      <center><input id='btnValidacion' class='btn btn-primary btn-custom text-center mt-2' type='button'  onclick='sendValidation()' value='Enviar a validación'/></center>
                  ";echo $btn2;
              }
        ?>
      </div>
    
    </div>

  </form>
</div>

<!-- ---------------- CONSTRUCCION DE BARRA DE PROGRESO ---------------------------- -->
<?php
    $messageProgress = "Actualizando ...";
    include_once($root."templates/acil/progressBar.php");  
?>

<!-- Función de Boton Enviar a Validacion -->
<script>
  function sendValidation(){
    var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();
    let btnValidation=1
    let numContrato='<?php echo $numContrato;?>'
    let root='<?php echo $root;?>'
      $.ajax({
            url: './templates/acilQuote/uploadFilesValidation.php',
            type: 'POST',
            data: 
                {
                  numContrato:numContrato,
                  btnValidation:btnValidation,
                  root:root
                },
            success: function(result)
                {
                  modal.hide();
                  $('#principal').html(result);
                }
            });       
  }
</script>

<!-- Calcula el tamaño de los archivos a cargar -->
<script>
    function checkFileSize(form) 
    {
        var inputs = form.querySelectorAll('input[type="file"]');
        //console.log(inputs);
        var maxSize = 30*1024*1024; // Tamaño máximo permitido en bytes

        for (var i = 0; i < inputs.length; i++) 
        {
            if(inputs[i].value != '')
            {
                var fileSize = inputs[i].files[0].size; // Tamaño del archivo en bytes
                if (fileSize > maxSize) 
                {
                    alert("El archivo es demasiado grande. Por favor, sube un archivo más pequeño.");
                    inputs[i].value = '';
                }
            }
        }
        //return true; // Envía el formulario si todo está bien
    }
</script>

<!-- Control de selector Editar Datos Fiscales -->
<script>
    $(document).ready(function(){
      $('#constancia').hide()

        $('#editar').change(function() {
          if($(this).prop('checked')) {
            $('#rfc').prop('disabled', false);
            $('#direccion').prop('disabled', false);
            $('#cp').prop('disabled', false);
            $('#regimen').prop('disabled', false);
            $('#cfdi').prop('disabled', false);
            $('#constancia').show()
          }else{
            $(this).prop('checked', false);
            $('#rfc').prop('disabled', true);
            $('#direccion').prop('disabled', true);
            $('#cp').prop('disabled', true);
            $('#regimen').prop('disabled', true);
            $('#cfdi').prop('disabled', true);
            $('#constancia').hide()
          }
        });

        $('input[type="file"]').change(function() {
            if (this.files && this.files.length > 0) {
                $('#btnEnviar').removeAttr('disabled');
            } else {
                console.log("No se ha seleccionado ningún archivo.");
            }
        });

        //Cuando detecta cambios en inputs de datos fiscales se habilita BTN Actualizar Informacion
        $('#rfc').on('input', function() {
          $('#btnEnviar').removeAttr('disabled');
          $(this).val($(this).val().toUpperCase());
        });

        $('#rfc').change(function() {
          let rfcValue = $('#rfc').val();
          if (rfcValue.length >= 13) {
             $('#btnEnviar').removeAttr('disabled');
          }else{
            alert("El RFC debe contener al menos 13 digitos")
            $('#btnEnviar').prop('disabled', true);
          }
        });

        $('#direccion').on('input', function() {
          if($('#rfc').val()!="XAXX010101000"){
            $('#btnEnviar').removeAttr('disabled');
          }else{
            alert("Para hacer cualquier cambio ingrese primero su RFC")
            $(this).val('<?php echo $direccionFiscal?>')
          } 
        });

        $('#cp').on('input', function() {
          if($('#rfc').val()!="XAXX010101000"){
            $('#btnEnviar').removeAttr('disabled');
          }else{
            alert("Para hacer cualquier cambio ingrese primero su RFC")
            $(this).val('<?php echo $cp?>')
          } 
        });

        $('#cp').change(function() {
          let cpValue = $('#cp').val();
          if (cpValue.length >= 5) {
             $('#btnEnviar').removeAttr('disabled');
          }else{
            alert("El CP debe contener al menos 5 digitos")
            $('#btnEnviar').prop('disabled', true);
          }
        });

        $('#regimen').on('input', function() {
          if($('#rfc').val()!="XAXX010101000"){
            $('#btnEnviar').removeAttr('disabled');
          }else{
            alert("Para hacer cualquier cambio ingrese primero su RFC")
          } 
        });

        $('#cfdi').on('input', function() {
          if($('#rfc').val()!="XAXX010101000"){
            $('#btnEnviar').removeAttr('disabled');
          }else{
            alert("Para hacer cualquier cambio ingrese primero su RFC")
          } 
        });

        //Agrega Options a Select de Regimen Fiscal
        <?php
            for ($i = 0; $i < $numRegimen-1; $i++) {
                $clave = $claveRegimen[$i];
                $descripcion = $claveRegimen[$i].'-'. $descripcionRegimen[$i]; 

                if($regimenFiscal!=$claveRegimen[$i]){
                  echo "
                  var nuevaOpcion = $('<option>', {
                      value: '{$clave}',
                      text: '{$descripcion}'
                  });
                  $('#regimen').append(nuevaOpcion);
                  "; 
                }
                else{
                 
                echo "
                var nuevaOpcion = $('<option>', {
                    value: '{$clave}',
                    text: '{$descripcion}'
                });
                nuevaOpcion.attr('selected', 'selected');
                $('#regimen').append(nuevaOpcion);
                "; 
                }   
            }
        ?>

        //Agrega Options a Select de Uso de CFDI
        <?php
            for ($i = 0; $i < $numCFDI-1; $i++) {
                $clave = $claveCFDI[$i];
                $descripcion = $claveCFDI[$i].'-'. $descripcionCFDI[$i]; 

                if($usoCFDI!=$claveCFDI[$i]){
                  echo "
                  var nuevaOpcion = $('<option>', {
                      value: '{$clave}',
                      text: '{$descripcion}'
                  });
                  $('#cfdi').append(nuevaOpcion);
                  ";
                }else{
                  echo "
                  var nuevaOpcion = $('<option>', {
                      value: '{$clave}',
                      text: '{$descripcion}'
                  });
                  nuevaOpcion.attr('selected', 'selected');
                  $('#cfdi').append(nuevaOpcion);
                  ";
                 

                }
                
            }
        ?>

    });
</script>
