<?php
	$pageTitle = "Quote Assistant";
	include_once('config/config.php');
	include_once('config/dbConf.php');
    include_once('functions.php');
    require $root."templates/$theme/header.php";

	$db=conexion_pdo();
	$db2=conexionPdo();

	#RECIBE KIT DESDE LANDING PAGE
	if (isset($_GET["kit"]) && !isset($_GET["folioCotizacion"]))
	{ 
		$menu=0;
		$kit = $_GET["kit"]; 
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
	} 
	else
	{ 
		$kit=""; 
	}

	#RECIBE VALORES DESDE "BTN CONTRATAR --> COTIZACION PDF
	if (isset($_GET["kit"            ]) && 
	    isset($_GET["kitNum"         ]) && 
		isset($_GET["kitPrice"       ]) && 
		isset($_GET["nombre"         ]) && 
		isset($_GET["calle"          ]) && 
		isset($_GET["numero"         ]) && 
		isset($_GET["colonia"        ]) && 
		isset($_GET["folioCotizacion"]))
		{
		   $menu=1;
		   $kitType=   base64_decode($_GET["kit"            ]);
		   $kitNum=    base64_decode($_GET["kitNum"         ]);
		   $kitPrice=  base64_decode($_GET["kitPrice"       ]);
		   $nombre=    base64_decode($_GET["nombre"         ]);
		   $calle=     base64_decode($_GET["calle"          ]);
		   $numero=    base64_decode($_GET["numero"         ]);
		   $colonia=   base64_decode($_GET["colonia"        ]);
		   $folioCot=                $_GET["folioCotizacion"];
		}

?>

<script>
	<?php
		if($menu==0)
		{
			echo "
				function launchForm()
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
		}
		if($menu==1)
		{
			echo "
				function launchCloseContract()
				{
					let root      = '".$root."'
					let kitType   = '".$kitType."'
					let kitNum    = '".$kitNum."'
					let kitPrice  = '".$kitPrice."'
					let nombre    = '".$nombre."'
					let calle     = '".$calle."'
					let numero    = '".$numero."'
					let colonia   = '".$colonia."'
					let folioCot  = '".$folioCot."'
					
					//CLOSE CONTRACT
					$.ajax({
						url: 'closeContractProcess.php',
						type: 'POST',
						data: 
						{
							root:root,
							nombre:nombre,
							calle:calle,
							numero:numero,
							colonia:colonia,
							kitType:kitType,
							kitNum:kitNum,
							kitPrice:kitPrice,
							folioCot:folioCot
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

<!-- GENERAL CANVAS -->
<div id=principal></div>

<!-- LANZA VISTAS DE ACUERDO AL ARGUMENTO DE LA FUNCION -->
<script>
	
	<?php
	   #FORMULARIO INICIAL
	   if($menu==0){ echo "launchForm()";         }
	   
	   #FORMULARIO CLOSE CONTRACT
	   if($menu==1){ echo "launchCloseContract()"; }
    ?> 
</script>

<?php require $root."templates/$theme/footer.php";?>