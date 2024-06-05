<script>
    addRange();
</script>
<div class="step">
    <div id='range' style='display: none;'>
        <h4 class="text-center mb-4">Datos del lugar:</h4>
        <div class="mb-3">
            <label for="cantidad_habitaciones">¿Cuántas habitaciones tiene? (incluye cocina, sala, baño, etc.)</label>
            <input id='rooms' type="number" placeholder="" oninput="this.className = ''" name="cantidad_habitaciones" min=0>
        </div>
        <div class="mb-3">
            <label for="metros_dimension">¿Cuáles son las dimensiones de tu propiedad? (m²)</label>
            <input id='meters' type="number" placeholder="" oninput="this.className = ''" name="metros_dimension"min=0>
        </div>
        <div class="mb-3">
            <label for="pisos">¿Cuántos pisos tiene? (contando azotea)</label>
            <input id='levels' type="number" placeholder="" oninput="this.className = ''" name="cantidad_pisos"min=0>
        </div>
    
        <div class="mb-3">
            <center>
                <label for="interior">¿Tipo de instalación?</label>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="form-check d-flex  align-items-center">
                        <label class="form-check-label" for="basico" >
                            Básico
                        </label>
                        <input class="form-check-input radio ms-2" type="radio" value="1" onchange="instalaciones(1)" name="instalacion" id="basico" checked>
                    </div>
                    <div class="form-check d-flex align-items-center">
                        <label class="form-check-label justify-content-cente aling-items-center" for="premium">
                            Prémium
                        </label>
                        <input class="form-check-input radio ms-2" type="radio" value="0" name="instalacion" onchange="instalaciones(2)" id="premium" >
                    </div>
                </div>
            </center>
        </div>
    
        <div class="mb-3 premium d-none">
            <label for="canaletas">¿Cuántos lotes de tuberia necesita? (cada lote son de 100m)</label>
            <input type="number" class="cantidad_canaleta " placeholder="" oninput="this.className = ''" name="cantidad_lotes" min=0>
        </div>
    </div>
    <div id='comboUnits'>
        <div class="mb-3">
            <label for="units">¿Cuántos kits deseas cotizar?</label>
            <input id='units' type="number" placeholder="" min='1' oninput="this.className = ''" name="cantidad_combo" value='1'>
        </div>
    </div>
</div>