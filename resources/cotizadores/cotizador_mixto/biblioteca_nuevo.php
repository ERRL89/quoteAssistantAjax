<?php
/////////////////////Biblioteca de intranet

$imagen_izq='<img style="height: 15vh;"  src="recursos/trio1.svg" alt="izquierda ">';
$imagen_centro='<img style="height: 15vh;" class="img-fluid" src="recursos/LOGO.svg" alt="ACIL logo">';
$imagen_der='<img style="height: 15vh;" class="float-end" src="recursos/trio2.svg" alt="derecha">';

$barranavegadora_intra1='<nav style="background-color:#000; color:#fff; font-size:2.5vh; width:101.2vw;" class="navbar navbar-expand-lg navbar-dark">
<div style="width:80vw;"><a class="navbar-brand" href="index.php"><img style="margin-left:4vh; width:18vh; height:7vh;" class="img-fluid" src="../../../recursos/acil.png" alt="ACIL logo"></a></div>


</nav>';

$barranavegadora_intra_carpeta1='<nav style="background-color:#000; color:#fff; font-size:2.5vh; width:101.2vw;" class="navbar navbar-expand-lg navbar-dark">
<div style="width:80vw;"><a class="navbar-brand" href="index.php"><img style="margin-left:4vh; width:18vh; height:7vh;" class="img-fluid" src="../../../recursos/acil.png" alt="ACIL logo"></a></div>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown" style="margin-right:4vh;">
    <ul class="navbar-nav ">
    <li class="nav-item active" style="margin-right:4vh;">
        <a class="nav-link" href="../nosotros.php"><b>Nosotros</b></a>
    </li>
    <li class="nav-item" style="margin-right:4vh;">
        <a class="nav-link" href="../servicios.php"><b>Servicios</b></a>
    </li>
    <li class="nav-item" style="margin-right:4vh;">
        <a class="nav-link" href="../promociones.php"><b>Promociones</b></a>
    </li>
    <li class="nav-item" style="margin-right:4vh;">
        <a class="nav-link" href="../contacto.php"><b>Contacto</b></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../bolsadetrabajo.php"><b>Bolsa de trabajo</b></a>
    </li>
    </ul>
</div>
</nav>';




$menuintra1='<div class="col-sm-12 col-md-12 col-lg-12" style="font-size:2.5vh; min-vh-80">
            <div id="navegador" class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white" min-vh-81>
            <a href="#" data-bs-toggle="collapse" class="nav-link  d-md-none" data-bs-target="#menu" aria-expanded="true" aria-controls="menu">
                            <i class="fa-solid fa-users-viewfinder" style="font-size:2.85vh;"></i><span style=" padding-bottom:0.5vh;" class="ms-1  d-sm-inline">Clientes</span> </a>
                            
                <ul class="nav col-sm-12 col-md-12 col-lg-12 accordion-collapse collapse show "id="menu">
                    <li class="nav-item" style="width:100%;">
                        <a href="index.php" class="nav-link px-0"> <i class="far fa-user-circle"  style="font-size:3.65vh;"></i><span style="padding-bottom:0.5vh;" class="ms-1 d-sm-inline">Inicio</span> </a>
                    </li>
                    <li class="nav-item" style="width:100%;">
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fa-solid fa-children" style="font-size:3vh;"></i><span class="ms-1  d-sm-inline">Onboarding</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            <li class="w-100" >
                                <a href="onboarding_resultados.php" class="nav-link px-0"> <span class=" d-sm-inline">Resultados</span></a>
                            </li>
                            <li>
                                <a href="onboarding_estadisticas.php" class="nav-link px-0"> <span class=" d-sm-inline">Estadisticas</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" style="width:100%;">
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fa-solid fa-layer-group" style="font-size:3.65vh;"></i><span class="ms-1  d-sm-inline">Productos</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100" >
                                <a href="productos_resultados.php" class="nav-link px-0"> <span class=" d-sm-inline">Resultados</span></a>
                            </li>
                            <li>
                                <a href="productos_estadisticas.php" class="nav-link px-0"> <span class=" d-sm-inline">Estadisticas</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" style="width:100%;">
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fas fa-globe" style="font-size:3.65vh;"></i><span class="ms-1  d-sm-inline">Servicios</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                            <li class="w-100" >
                                <a href="servicios_resultados.php" class="nav-link px-0"> <span class=" d-sm-inline">Resultados</span></a>
                            </li>
                            <li>
                                <a href="servicios_estadisticas.php" class="nav-link px-0"> <span class=" d-sm-inline">Estadisticas</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" style="width:100%;">
                        <a href="#submenu4" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fa-solid fa-tv" style="font-size:3.25vh;"></i><span class="ms-1  d-sm-inline">Monitoreo</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu4" data-bs-parent="#menu">
                            <li class="w-100" >
                                <a href="monitoreo_resultados.php" class="nav-link px-0"> <span class=" d-sm-inline">Resultados</span></a>
                            </li>
                            <li>
                                <a href="monitoreo_estadisticas.php" class="nav-link px-0"> <span class=" d-sm-inline">Estadisticas</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" style="width:100%;">
                        <a href="logout.php" class="nav-link px-0"> <i class="fa-solid fa-power-off" style="font-size:3.65vh;"></i><span style="padding-bottom:0.5vh;" class="ms-1  d-sm-inline">Cerrar Sesion</span> </a>
                    </li>
                </ul>    
            </div>
        </div>';
?>