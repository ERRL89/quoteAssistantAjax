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

  include_once($root.'config/config.php');
  include_once($root.'config/dbConf.php');
  $db=conexionPdo();
  
  #TABLA DE REGIMEN FISCAL
  $regimenFiscal=616;
  $consultaStr="SELECT * FROM cfdi_regimen_fiscal";
  $consulta=$db->prepare($consultaStr);
  $consulta->execute();
  if($consulta->rowCount() > 0)
  {
    $numRegimen=0;
    while($fila = $consulta->fetch(PDO::FETCH_ASSOC))
    {
        $claveRegimen[$numRegimen] = $fila['clave'];
        $descripcionRegimen[$numRegimen] = $fila['descripcion'];
        $clave = $claveRegimen[$numRegimen];
        $descripcion = $claveRegimen[$numRegimen].'-'. $descripcionRegimen[$numRegimen]; 
        if($regimenFiscal!=$claveRegimen[$numRegimen])
        {
          echo "
                <script>
                  var nuevaOpcion = $('<option>', {
                      value: '{$clave}',
                      text: '{$descripcion}'
                  });
                  $('#regimen').append(nuevaOpcion);
                </script>
                "; 
        }
        else
        {
          echo "
                <script>
                  var nuevaOpcion = $('<option>', {
                      value: '{$clave}',
                      text: '{$descripcion}'
                  });
                  nuevaOpcion.attr('selected', 'selected');
                  $('#regimen').append(nuevaOpcion);
                </script>
                "; 
        }   
        $numRegimen+=1;
    }
  }

  #TABLA DE USO DE CFDI
  $usoCFDI="S01";
  $consultaStr="SELECT * FROM cfdi_uso";
  $consulta=$db->prepare($consultaStr);
  $consulta->execute();
  if ($consulta->rowCount() > 0)
  {
    $numCFDI=0;
    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC))
    {
        $claveCFDI[$numCFDI] = $fila['clave'];
        $descripcionCFDI[$numCFDI] = $fila['descripcion'];
        $clave = $claveCFDI[$numCFDI];
        $descripcion = $claveCFDI[$numCFDI].'-'. $descripcionCFDI[$numCFDI]; 

        if($usoCFDI!=$claveCFDI[$numCFDI])
        {
          echo "
                <script>
                  var nuevaOpcion = $('<option>', {
                      value: '{$clave}',
                      text: '{$descripcion}'
                  });
                  $('#cfdi').append(nuevaOpcion);
                </script>
                ";
        }
        else
        {
          echo "
                <script>
                  var nuevaOpcion = $('<option>', {
                    value: '{$clave}',
                    text: '{$descripcion}'
                  });
                  nuevaOpcion.attr('selected', 'selected');
                  $('#cfdi').append(nuevaOpcion);
                </script>";
        }
        $numCFDI+=1;
    }
  }
  #SE CARGA FORMULARIO DE CONTRATO
  include_once('templates/acilQuote/closeContractForm.php');
?>