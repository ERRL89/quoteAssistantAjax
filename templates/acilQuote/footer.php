<?php
	if(isset($datatables))
	{
		echo '
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.7/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js"></script>
		';
	}
?>

<footer class="contenedor-footer">
<section class="row g-0">
    <div class="col-3 footer-contain">
        <a href="https://acil.mx/conocenos.php" class="footer-links">Conócenos</a>
        <a href="https://acil.mx/contactanos.php" class="footer-links">Contáctanos</a>
        <a href="https://acil.mx/legal.php" class="footer-links">Legal</a>
    </div>
    <div class="col-5 footer-contain">
        <a href="https://acil.mx/bolsatrabajo.php" class="footer-links">Bolsa de trabajo</a>
        <a href="https://acil.mx/intranet/recursos_graficos/catalogo.pdf" target='_blank' class="footer-links">Conoce nuestro catálogo</a>
        <a href="tel:8008082245" class="footer-links">LLAMA AL 800 808 2245</a>
    </div>
    <div class="col-3 footer-contain">
        <a href="https://acil.mx/sucursales.php" class="footer-links">Sucursales</a>
        <a href="https://acil.mx/intranet/index.php" class="footer-links">Intranet</a>
        <a href="https://acil.mx/clientes.php" class="footer-links">Clientes</a>
    </div>
    <div class="col-1 footer-contain">
        <a href="https://www.facebook.com/acil.mexico.seguridad" target="_blank" class="text-reset links footer-links"><img src="images/logos/FACEBOOK.svg" class="me-2" width="20"></a>
        <a href="https://www.instagram.com/acil_mexico/" target="_blank" class="text-reset links footer-links"><img src="images/logos/INSTAGRAM.svg" class="me-2" width="20"></a>
        <a href="https://www.linkedin.com/company/acil-mexico" target="_blank" class="text-reset links footer-links"><img src="images/logos/LINKEDIN.svg" class=" me-2" width="20"></a>
        <a href="https://www.tiktok.com/@acil_mexico?lang=es" target="_blank" class="text-reset links footer-links"><img src="images/logos/TIKTOK.svg" class="me-2" width="20"></a>
    </div>
    <div class="col-12 footer-contain">
        <div class="footer-links-derechos">
            ACIL México, Todos los derechos reservados 2023
        </div>
    </div>
</section>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->

<?php echo "<script  src='/" . $folderBase . "js/" . $theme . "/onload.js'></script>";?>
<?php echo "<script  src='/" . $folderBase . "js/" . $theme . "/boostrapFunction.js'></script>";?>
<?php echo "<script  src='/" . $folderBase . "js/" . $theme . "/generalFunctions.js'></script>";?>

<?php echo "<script  src='/" . $folderBase . "js/" . $theme . "/form.js'></script>";?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>

</body>

</html>