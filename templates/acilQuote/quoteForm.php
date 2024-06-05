<?php
  #RECIBIMOS INFORMACION INICIAL
  if(isset($_POST['root']))     { $root    = $_POST['root'];     }     
  if(isset($_POST['kit']))      { $kit     = $_POST['kit'];      }
  if(isset($_POST['kitTxt']))   { $kitTxt  = $_POST['kitTxt'];   }
  if(isset($_POST['costo']))    { $costo   = $_POST['costo'];    }
  if(isset($_POST['folioCot'])) { $folioCot= $_POST['folioCot']; }
?>

<!-- FORMULARIO INICIAL -->
<div class="mb-5">
  <h2 class="text-center" id="texto">Asistente de Cotización</h2>
  <form id="form">
    <div class="container-sm container_form_custom">
      <div class="mb-3">
        <label for="nombre" class="form-label label-custom">Nombre del cliente:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" required>
        <div class="invalid-feedback">Introduce tu nombre</div>
      </div>
      <div class="mb-3">
        <label for="direccion" class="form-label label-custom">Dirección:</label>
        <div class="row mb-3">
          <div class="col-md-4 mb-2"> 
            <input type="text" class="form-control form-input" placeholder="Calle" id="calle" name="calle"  required>
            <div class="invalid-feedback">Introduce tu calle</div>
          </div>
          <div class="col-md-4 mb-2">
            <input type="text" class="form-control form-input" placeholder="Número" id="numero" name="numero" required>
            <div class="invalid-feedback">Introduce tu número</div>
          </div>
          <div class="col-md-4 mb-2">
            <input type="text" class="form-control form-input" placeholder="Colonia" id="colonia" name="colonia" required>
            <div class="invalid-feedback">Introduce tu colonia</div>
          </div>
      </div>
      </div>
      <div class="mb-3">
        <p class="label-custom">Tipo de kit:</p>
        <!-- Se colocan dos input para tipo de kit, una en modo oculta que es la que envia info en el formulario, la otra en disabled, no envia solo muestra informacion al usuario -->
        <input type="text" id="kitType" class="form-control" value="<?php if(isset($kitTxt)){echo $kitTxt;}?>" disabled>
        <input type="text" class="form-control input-custom" value="<?php if(isset($kitTxt)){echo $kitTxt;}?>" name="kit">
        <input type="text" id="kitNum" class="form-control input-custom" value="<?php if(isset($kit)){echo $kit;}?>" name="kitNum">
       <!-- Valor de kit oculto en input -->
        <input type="text" id="kitPrice" class="form-control input-custom" value="<?php if(isset($costo)){echo ceil($costo*1.16);}?>" name="kitPrice">
        <!-- Numero de cotizacion oculto en formulario, se coloca aqui para envio solamente -->
        <input type="text" id="folioCotizacion" class="form-control input-custom" value="<?php if(isset($folioCot)){echo $folioCot;}?>" name="folioCotizacion">
      </div>
      
      <div class="container-sm d-flex justify-content-center align-items-center mt-4">
         <button type='button' class='btn btn-primary btn-custom text-center' onclick='sendForm(); generateCot();'>COTIZAR</button>  
      </div>
    </div>
  </form>
</div>

<script>
  //ENVIA FORMULARIO A PANTALLA ACCEPT CONTRACT
  function sendForm()
  {
    $.ajax({
					url: './templates/acilQuote/acceptContractForm.php',
					type: 'POST',
					data: 
					{
            root:     '<?php echo $root; ?>',
						nombre:   $('#nombre').val(),
            calle:    $('#calle').val(),
            numero:   $('#numero').val(),
            colonia:  $('#colonia').val(),
            kitType:  $('#kitType').val(),
            kitNum:   $('#kitNum').val(),
            kitPrice: $('#kitPrice').val(),
            folioCot: '<?php echo $folioCot; ?>'
					},
					success: function(result)
					{
						$('#principal').html(result);
					}
		});
  }

  //GENERA COTIZACION
  function generateCot() 
  {
      let form = document.getElementById('form');
      if(form.checkValidity())
      {
        form.setAttribute("method", "post")
        form.setAttribute("action", "resources/cotizadores/cotizador_mixto/crea_cotizacion.php")
        form.target="blank"
        form.submit()
      }   
  }
</script>

  
 


