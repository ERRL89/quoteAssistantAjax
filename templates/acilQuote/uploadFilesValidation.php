<!--Pantalla de agradecimiento con redireccionamiento a formulario de contrato -->
<?php

    if(isset($_POST['root'])){
        $root=$_POST['root'];
        include_once($root."config/config.php");
        include_once($root."config/dbConf.php");
        include_once($root."functions.php");

        include $root."resources/PHPMailer/src/Exception.php";
        include $root."resources/PHPMailer/src/PHPMailer.php";
        include $root."resources/PHPMailer/src/SMTP.php";
    }

    if(isset($_POST['nombre'])){ $nombre=$_POST['nombre']; }
    if(isset($_POST['numContrato'])){ $numContrato=$_POST['numContrato']; }

    if(isset($_POST['btnValidation'])){ 
        $btnValidation=$_POST['btnValidation']; 

        //Se entra a la condicion cuando se da click en el boton Enviar a Validacion _Envio de correo a Validación
        if($btnValidation==1){

            $db=conexionPdo();

            //Actualiza estatus de precontrato
            $consultaStr="UPDATE precontratos SET estatus=2 WHERE num_contrato=?";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$numContrato]);

            //Extrae nombre para envio de correo
            $consultaStr="SELECT nombre FROM precontratos WHERE num_contrato=?";
            $consulta=$db->prepare($consultaStr);
            $consulta->execute([$numContrato]);
            $dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
            $nombre=$dataConsulta["nombre"];

            require($root.'sendMailValidation.php');
        }
    }
?>

<script>
     $("#exampleModal").hide()
</script>
<!-- Mensaje de Espera por Validación -->
<br><br><div class="container-md d-flex justify-content-center align-items-center flex-column text-center mt-4 mb-5 container_form_custom">
    <h3>¡ Muchas Gracias !</h3>
    <h4 class='mt-3'>Tus documentos fueron cargados correctamente y se encuentran en proceso de validacíon.</h4><br>
    <h6 class='mt-3'>* Nos comunicaremos contigo en un plazo máximo de 72 hrs. *</h6><br>
</div><br><br><br><br>

