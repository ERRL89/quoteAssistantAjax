<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
// Aquí puedes insertar código necesario para enviar las variables iniciales como es el "folderBase" hacia JS o hacia donde requieras.
$imageLoad = '/' . $folderBase . 'images/favicons/apple-icon-180x180.png';
$logo = '/' . $folderBase . 'images/logos/logoacilblanco.png';
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href='<?php echo $imageLoad?>' type="image/x-icon">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://www.momstudio.es/img/img-elmaquetadorweb/hamburgers.min.css">

	<?php //CDN de Data Tables
		if(isset($datatables))
		{
			echo'
			<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.7/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">
 
			';
		}
	?>

    <?php	
		echo "<link rel='stylesheet' href='/" . $folderBase . "css/" . $theme . "/styles.css'>";
    echo "<link rel='stylesheet' href='/" . $folderBase . "css/" . $theme . "/pago.css'>";

	?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
	<script src="https://kit.fontawesome.com/b56eda6614.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	
	<?php
	if(isset($graphs)){ //CDN de Chart.js para implementar graficas
	echo '
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/helpers.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>';
	}
	?>

	<title><?php echo $pageTitle ?></title>
</head>

<body>

<header>
<nav class="navbar navbar-expand-lg bg-white">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://acil.mx/"><img src="images/logos/logoacilsimple.png" alt="ACIL México" class="logo"></a>
    <button class="navbar-toggler nav-menu" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <input type="checkbox" id="checkbox1" class="checkbox1 visuallyHidden">
      <label for="checkbox1">
        <div class="hamburger hamburger1">
          <span class="bar bar1"></span>
          <span class="bar bar2"></span>
          <span class="bar bar3"></span>
          <span class="bar bar4"></span>
        </div>
      </label>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link nav-acil" href="https://acil.com.mx/sglanding/">ACIL Contigo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-acil" href="https://acil.mx/conocenos.php">Nosotros</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link nav-acil dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Soluciones
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item nav-acil" href="https://acil.mx/productos.php">Productos</a></li>
              <li><a class="dropdown-item nav-acil" href="https://acil.mx/servicios.php">Servicios</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-acil" href="https://acil.mx/contactanos.php">Contacto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-acil " href="https://acil.mx/blog">Blog</a>
          </li>

        </ul>
      </div>
    </div>
  </div>
</nav>
</header>
	