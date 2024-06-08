<?php
	$pageTitle = "Quote Assistant";
	include_once('config/config.php');
	include_once('config/dbConf.php');
    include_once('functions.php');
    require $root."templates/$theme/header.php";

	#RECIBE KIT DESDE LANDING PAGE
	if (isset($_GET["kit"])){ $kit = $_GET["kit"]; } else{ $kit=""; }
	
	$db=conexion_pdo();
	$db2=conexionPdo();

	#EXTRAE DETALLE DEL KIT PARA ELABORAR COTIZACION
	$consultaStr="SELECT * FROM kits_combos WHERE id_kit=? ";
	$consulta=$db2->prepare($consultaStr);
	$consulta->execute([$kit]);
	$dataConsulta=$consulta->fetch(PDO::FETCH_ASSOC);
	$nombre=$dataConsulta["nombre"];
	$costo=$dataConsulta["costo"];
	
	$kitTxt=$nombre;
	$usuario=9979;
	
	$fecha_actual = date('Y-m-d');
	$dia          = date('d');
	$mes          = date('m');
	$anio         = date('y');
	$hora         = date('G');
	$minuto       = date('i');
	$segundo      = date('s');
	
	$folio_cotizacion = $usuario.$anio.$mes.$dia.$hora.$minuto.$segundo;
?>

<script>
	<?php
		echo "
			 function launchForm(menu)
			 {
				let root     = '".$root."'
				let kit      = '".$kit."'
				let kitTxt   = '".$kitTxt."'
				let costo    = '".$costo."'
				let folioCot = '".$folio_cotizacion."'
				
				//FORMULARIO INICIAL
				$.ajax({
					url: './templates/acilQuote/quoteForm.php',
					type: 'POST',
					data: 
					{
						root:root,
						kit:kit,
						kitTxt:kitTxt,
						costo:costo,
						folioCot:folioCot
					},
					success: function(result)
					{
						$('#principal').html(result);
					}
				});
			 }
			 ";
	?>
</script>

<!-- GENERAL CANVAS -->
<div id=principal></div>

<!-- LANZA VISTAS DE ACUERDO AL ARGUMENTO DE LA FUNCION -->
<script>
	//FORMULARIO INICIAL
	<?php echo "launchForm()"; ?> 
</script>

<?php require $root."templates/$theme/footer.php";?>