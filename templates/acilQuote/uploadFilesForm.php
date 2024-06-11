<!-- Define llamado a ruta de proceso de carga de documentación -->
<?php

  if(isset($_POST['root'])){ $root=$_POST['root']; }

  include_once($root."config/config.php");
  include_once($root."config/dbConf.php");

  if(isset($_POST['numContrato'])){ $numContrato=$_POST['numContrato']; }

  $db=conexionPdo();
  //Consulta pa extraer id de cliente
  $consultaStr="SELECT cliente FROM precontratos WHERE num_contrato=?";
  $consulta=$db->prepare($consultaStr);
  $consulta->execute([$numContrato]);
  $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
  $cliente=$dataConsulta["cliente"];
    
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
  function validateFile($name, $numero)
  {
      global $numContrato, $root, $folderBase, $domicilio, $identificacion, $pago, $contrato, $constancia;
      $archivo = $name.$numContrato.".pdf";
          $rutaArchivo = $root."docs/digitalContracts/".$numContrato."/".$archivo;
          if (file_exists($rutaArchivo))
          {
              if($numero==0)
              {
                  echo "<a href='/".$folderBase."docs/digitalContracts/".$numContrato."/".$archivo."'target='_blank'>[".$name."".$numContrato.".pdf]</a>";
                  if($name=="comprobante_pago_"){ $pago=1; }
              }
              //Elimina leyenda de ADVERTENCIA Limite de Carga cuando ya se detecto la carga del archivo
              else if($numero==1){ echo ""; } 
          }
          else
          {
              if($numero==0)
              {
                  echo "No se ha cargado el archivo.";
              } 
              if($numero==1)
              {
                  //Agrega leyenda de ADVERTENCIA Limite de Carga cuando ya se detecto la carga del archivo
                  echo "¡ADVERTENCIA! Límite por archivo: 4MB - Archivos más pesados no se subirán.";
              } 
          } 
  }
?>

<!-- Formulario para carga de Documentos -->
<div class="mb-5" id=uploadForm><br>
  <h2 class="text-center" id="texto">Sube tu comprobante de pago</h2>
  <form id="form" class="mb-5" action="" method="post" enctype="multipart/form-data" onchange="checkFileSize(this)" novalidate>
    <div class="container-sm container_form_custom">

      <!-- -------  NUMERO DE CONTRATO y NUMERO DE CLIENTE EN FORM OCULTOS  ---------------------------- -->
      <input type="hidden" name="numContrato" id="nc" class="form-control" value="<?php echo $numContrato;?>"/>
      <input type="hidden" name="cliente" id="cliente" class="form-control" value="<?php echo $cliente;?>"/>
     
      <!-- --------------------------CARGA DE COMPROBANTE DE PAGO---------------------------- -->
      <label for="pago" class="form-label label-custom">Comprobante de Pago</label>
      <label id="pago_label_edit" class='form-label' style='color:#e25b19'>
        <?php validateFile("comprobante_pago_",0);?>
      </label>
      <input type="file" name="pago" id="pago" class="form-control" accept=".pdf"/>
      <div id='advertencia3' class='form-text' style='color: red;'>
        <?php validateFile("comprobante_pago_",1);?>
      </div><br>
      <!-- ---------Se asigna boton para subir archivos se actualiza de acuerdo a cada carga---------- -->
      <div class="container-fluid d-flex justify-content-center align-items-center flex-wrap mb-3">
        <?php
              //Se asigna boton para subir archivos se actualiza de acuerdo a cada carga
              $btn="
                      <center><input id='btnEnviar' class='btn btn-primary btn-custom text-center mr-3 mt-2' type='button' value='Actualizar información' 
                      onclick=\"{$functionParameters}\" disabled/></center>
              ";echo $btn;

              //Se asigna boton de enviar a validacion, se dibuja de acuerdo al siguiente IF
              if($pago==1){
                  $btn2="
                      <script> $('#btnValidacion').show()</script>
                      <div style='width: 10px;'></div>
                      <center><input id='btnValidacion' class='btn btn-primary btn-custom text-center mt-2' type='button'  onclick='sendValidation()' value='Enviar a validación'/></center>
                  ";echo $btn2;
              }
        ?>
      </div>
    
    </div>

  </form>
</div>

<div id="progressBar">
    <div class="">
        <div class="w-100 h-100">
            <div class="form-signin divCenter mt-4">
                <div class="cajalogin divCenter">
                    <div class="progress" style="width:75%;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="texto-sesion text-center">
                        <h3>Enviando ...</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ---------------- CONSTRUCCION DE BARRA DE PROGRESO ---------------------------- -->
<?php
    $messageProgress = "Actualizando ...";
    include_once($root."templates/acilQuote/progressBar.php");  
?>

<!-- Función de Boton Enviar a Validacion -->
<script>
  function sendValidation(){
    $('#uploadForm').hide()
    $('#progressBar').show()
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
                  $('#progressBar').hide()
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
        $("#progressBar").hide()
        $('input[type="file"]').change(function() {
            if (this.files && this.files.length > 0) {
                $('#btnEnviar').removeAttr('disabled');
                
            } else {
                console.log("No se ha seleccionado ningún archivo.");
            }
        });
    });
</script>
