<?php
  #RECIBIMOS INFORMACION INICIAL
  if(isset($_POST['root']))     { $root     = $_POST['root'];     } 
  if(isset($_POST['nombre']))   { $nombre   = $_POST['nombre'];   } 
  if(isset($_POST['calle']))    { $calle    = $_POST['calle'];    } 
  if(isset($_POST['numero']))   { $numero   = $_POST['numero'];   } 
  if(isset($_POST['colonia']))  { $colonia  = $_POST['colonia'];  } 
  if(isset($_POST['kitNum']))   { $kitNum   = $_POST['kitNum'];   } 
  if(isset($_POST['kitType']))  { $kitType  = $_POST['kitType'];  } 
  if(isset($_POST['kitPrice'])) { $kitPrice = $_POST['kitPrice']; } 
  if(isset($_POST['folioCot'])) { $folioCot = $_POST['folioCot']; } 
?>

<!-- ------------------------ PANTALLA DE AGRADECEMOS TU INTERES ---------------------------------- -->
<div class="container-md d-flex justify-content-center align-items-center flex-column text-center mt-3 container_form_custom2">
    <h4>¡ Agradecemos tu interes !</h4>
    <h1 class="mt-3 nombre-cliente"><?php echo $nombre; ?></h1>
    <h4 class="mt-3">Tu cotización ya esta lista,<br>¿gustas continuar con el proceso de contratación?</h4><br><br>
    
    <button class="btn btn-primary btn-custom text-center" onClick="acceptContract();">CONTRATAR</button>
</div>

<script>
  //AVANZA HACIA FORMULARIO DE CONTRATO CLOSE CONTRACT FORM
  function acceptContract()
  {
    $.ajax({
        url: './templates/acilQuote/closeContractForm.php',
        type: 'POST',
        data: 
        {
            root:     '<?php echo $root;     ?>',
            nombre:   '<?php echo $nombre;   ?>',
            calle:    '<?php echo $calle;    ?>',
            numero:   '<?php echo $numero;   ?>',
            colonia:  '<?php echo $colonia;  ?>',
            kitNum:   '<?php echo $kitNum;   ?>',
            kitType:  '<?php echo $kitType;  ?>',
            kitPrice: '<?php echo $kitPrice; ?>',
            folioCot: '<?php echo $folioCot; ?>'
        },
        success: function(result)
        {
            $('#principal').html(result);
        }
    });
  }
</script>