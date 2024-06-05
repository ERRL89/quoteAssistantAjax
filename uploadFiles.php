<?php
    $pageTitle = "Upload your files";
    include_once('config/config.php');
	include_once('config/dbConf.php');
    include_once('functions.php');

	if(isset($_GET['nC'])){ $numContrato=base64_decode($_GET['nC']); }

    require $root."templates/$theme/header.php";// template header page

    //Realiza consulta para extraer informacion de acuerdo al numero de contrato recibido por GET
        $db=conexionPdo();
        $consultaStr="SELECT * FROM `precontratos` WHERE `num_contrato`=?";
        $consulta=$db->prepare($consultaStr);
        $consulta->execute([$numContrato]);
        $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
        $idPrecontrato=$dataConsulta["id_precontrato"];
        $folioCotizacion=$dataConsulta["folio_cotizacion"];
        $nombre=$dataConsulta["nombre"];
        $estatus=$dataConsulta["estatus"];  
?>

<script>
    <?php
        //Permite cargar documentos ya que el estatus es pendiente o rechazado
        if($estatus==1 || $estatus==3){
            echo "
                function launchForm(){
                
                    let numContrato='".$numContrato."'
                    let root='".$root."'
                        $.ajax({
                                url: './templates/acilQuote/uploadFilesForm.php',
                                type: 'POST',
                                data: 
                                {
                                    numContrato:numContrato,
                                    root:root
                                },
                                success: function(result)
                                {
                                    $('#principal').html(result);
                                }
                            });
                }
                 ";
        }

        //No permite cargar documentos ya que el estatus es en proceso de validación
        else if($estatus==2){
            echo "
                function launchForm(){
                    let nombre='".$nombre."'
                        $.ajax({
                                url: './templates/acilQuote/uploadFilesValidation.php',
                                type: 'POST',
                                data: 
                                {
                                    nombre:nombre
                                },
                                success: function(result)
                                {
                                    $('#principal').html(result);
                                }
                            });
                }
                 ";
        }
    ?>
</script>

<!-- Modal ENVIANDO correo electronico al area de validacion de contratos-->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <center><div class="loader"></div></center>
                <center><h2>Enviando...</h2></center>
            </div>
        </div>
    </div>
</div>

<!-- General Canvas-->
<div id=principal></div>

<script> launchForm() </script>

<?php require $root."templates/$theme/footer.php";?>

