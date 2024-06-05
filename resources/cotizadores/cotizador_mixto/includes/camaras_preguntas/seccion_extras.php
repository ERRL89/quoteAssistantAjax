<div class="step">
    <h4 class="text-center mb-4">Paso 3 extras:</h4>
  
    <div class="mb-3">
        <label for="dias_grabacion">¿Cuántos días de grabación quiere?</label>
        <input type="number" placeholder="" oninput="this.className = ''" name="dias_grabacion" min=0>
    </div>
    <div class="mb-3">
        <label for="housing">¿Cuántos housing requiere?</label>
        <input type="number" class="" placeholder="" oninput="this.className = ''" name="housing" min=0>
    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col-6">
                <center>
                    <label for="interior">¿Requiere poste?</label>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="form-check d-flex  align-items-center">
                            <label class="form-check-label" for="si_poste">
                                Si
                            </label>
                            <input class="form-check-input radio ms-2" type="radio" onchange="postes(1)" name="poste" value='1' id="si_poste">
        
                        </div>
                        <div class="form-check d-flex align-items-center">
                            <label class="form-check-label justify-content-cente aling-items-center" for="no_poste">
                                No
                            </label>
                            <input class="form-check-input radio ms-2" type="radio" onchange="postes(2)" value='0' name="poste" id="no_poste" checked>
                        </div>
                    </div>
                </center>
            </div>
            <div class="col-6">
                <center>
                    <label for="interior">¿Requiere gabinete?</label>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="form-check d-flex  align-items-center">
                            <label class="form-check-label" for="si">
                                Si
                            </label>
                            <input class="form-check-input radio ms-2" type="radio" name="conf_gabinete" value=1 id="si">
        
                        </div>
                        <div class="form-check d-flex align-items-center">
                            <label class="form-check-label justify-content-cente aling-items-center" for="no">
                               No
                            </label>
                            <input class="form-check-input radio ms-2" type="radio" value=0 name="conf_gabinete" id="no" checked>
        
                        </div>
                    </div>
                </center>
            </div>
        </div>
        
    </div>

    <div class="mb-3 d-none" id="preguntaPoste">
        <label for="poste_tamaño">¿Tamaño del poste?</label>
        <select class="form-select mb-4" id="poste_tamaño" aria-label="Seleccione una opcion" name="poste_tamaño">
            <option value="0">Selecccione una opcion</option>
            <option value="1 metro">1 Metro</option>
            <option value="2 metros">2 Metros</option>
        </select>
    </div>
    
    <div class="mb-3 d-none" id="preguntaPoste2">
        <label for="cantidad_poste">¿Cuántos postes requiere?</label>
        <input type="number" class="" placeholder="" oninput="this.className = ''" name="cantidad_poste" min=0>
    </div>



    <div class="mb-3">
        <div class="row">
            <div class="col-6">
                <center>
                    <label for="interior">¿Requiere monitor?</label>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="form-check d-flex  align-items-center">
                            <label class="form-check-label" for="si_monitor">
                                Si
                            </label>
                            <input class="form-check-input radio ms-2" type="radio" name="monitor" value="1" onchange="monitorAdd(1)" id="si_monitor">

                        </div>
                        <div class="form-check d-flex align-items-center">
                            <label class="form-check-label justify-content-cente aling-items-center" for="no_monitor">
                                No
                            </label>
                            <input class="form-check-input radio ms-2" type="radio" name="monitor" value="0" onchange="monitorAdd(2)" id="no_monitor" checked>

                        </div>
                    </div>
                </center>
            </div>
            <div class="col-6">
                <center>
                    <label for="interior">¿Requiere UPS?</label>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="form-check d-flex  align-items-center">
                            <label class="form-check-label" for="si_ups">
                                Si
                            </label>
                            <input class="form-check-input radio ms-2" type="radio" name="ups" value="1" id="si_ups">

                        </div>
                        <div class="form-check d-flex align-items-center">
                            <label class="form-check-label justify-content-cente aling-items-center" for="no_ups">
                                No
                            </label>
                            <input class="form-check-input radio ms-2" type="radio" name="ups" value="0" id="no_ups" checked>

                        </div>
                    </div>
                </center>
            </div>
        </div>

    </div>

    <div class="mb-3 d-none" id="preguntaMonitor">
        <center>
            <label for="interior">¿Requiere base?</label>
            <div class="d-flex align-items-center justify-content-center">
                <div class="form-check d-flex  align-items-center">
                    <label class="form-check-label" for="si_base">
                        Si
                    </label>
                    <input class="form-check-input radio ms-2" type="radio" name="base" value="1" id="si_base">

                </div>
                <div class="form-check d-flex align-items-center">
                    <label class="form-check-label justify-content-cente aling-items-center" for="no_base">
                        No
                    </label>
                    <input class="form-check-input radio ms-2" type="radio" name="base" value="0" id="no_base">

                </div>
            </div>
        </center>
    </div>


</div>