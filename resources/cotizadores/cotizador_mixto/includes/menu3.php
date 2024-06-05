<!-- Sidebar Holder -->
   
            <nav id="sidebar">

                <div class="sidebar-header">
                    <img src="recursos/acil1.png">
                </div>
                <div class="sidebar-header header2">
                    <h3>Bienvenido</h3>
                        <?php 
                        echo "$nombre_contrato";
                        ?>

                </div>
                  
                <ul class="list-unstyled components">
                   
                    <li>
                       <li><a href="index.php">Inicio</a></li>
                    </li>
                    <li>
                        <a href="#pageSubmenu2" data-bs-toggle="collapse" aria-expanded="false">Clientes</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu2">
                            <li><a href="clientes_aot_a.php">Acil On time</a></li>
                            <li><a href="clientes_biotime_a.php">bio security/ bio time</a></li>
                            <li><a href="clientes_alarmas_a.php">alarmas vecinales</a></li>
                            <li><a href="leasing_a.php">leasing</a></li>
                            <li><a href="clientes_a.php">ventas</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#pageSubmenu3" data-bs-toggle="collapse" aria-expanded="false">Contratos / monitoreo</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu3">
                            <li><a href="monitoreo_alarmas_a.php">Alarmas</a></li>
                            <li><a href="monitoreo_camaras_a.php">Camaras</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#pageSubmenu4" data-bs-toggle="collapse" aria-expanded="false">Contrato nuevo</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu4">
                            <li><a href="contrato_aot_a.php">Acil on Time</a></li>
                            <li><a href="contrato_biotime_a.php">BioSecurity/BioTime</a></li>
                            <li><a href="contrato_alarmas_v_a.php">Alarmas vecinales</a></li>
                            <li><a href="contrato_renta_a.php">Leasing</a></li>
                            <li><a href="contrato_venta_a.php">Ventas</a></li>
                            <li><a href="contrato_alarmas_a.php">Monitoreo Alarmas</a></li>
                            <li><a href="contrato_camaras_a.php">Monitoreo Cámaras</a></li>
                            
                        </ul>
                    </li>
                </ul>

                <ul class="list-unstyled CTAs">
                    <li><a href="logout.php" class="download">Cerrar sesion</a></li>
                    
                </ul>
            </nav>
            
             <button type="button" id="sidebarCollapse" class="navbar-btn btn btn-info">
                <img src="recursos/icon_menu2.svg" width="20" height="20">
            </button>
