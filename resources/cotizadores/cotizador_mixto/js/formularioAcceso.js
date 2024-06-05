const Arrayproductos = document.querySelectorAll('.productos_input');
const btnAdicionales = document.querySelector('#adicionales');
const principal = document.querySelectorAll('#preguntas_principales');
const contenedorPeatonal = document.querySelector('#preguntas_peatonal');
const contenedorVehicular = document.querySelector('#preguntas_vehicular');
const contenedorPuerta = document.querySelector('#preguntas_puertas');

var myModal = new bootstrap.Modal(document.getElementById('form_kit_camara')) // Returns a Bootstrap modal instance



///let sumaProductos = 0;

myModal.show();

function tipoAcceso(){
    const preguntas_telescopica = document.querySelector('#preguntas_telescopica');
    const preguntas_articulados = document.querySelector('#preguntas_articulados');
    const acceso = document.querySelector('input[name="tipo_acceso"]:checked');
    if(acceso.value === "peatonal"){
        /* Aparece al seleccionar */
        contenedorPeatonal.classList.remove('d-none');
        document.querySelector('#cantidad_peatonal').required = true;
        document.querySelector('#accesos').required = true;
        /* se quitan las preguntas de vehicular si estan activas */
        contenedorVehicular.classList.add('d-none');
        document.querySelector('#telescopica').required = false;
        document.querySelector('#articular').required = false;
        preguntas_articulados.classList.add('d-none');
        preguntas_telescopica.classList.add('d-none');

        document.querySelectorAll('#preguntas_vehicular input[type=radio]').forEach(function (checkElement) {
            checkElement.checked = false;
        })

        /*Se quitan las preguntas de puertas */
        contenedorPuerta.classList.add('d-none');
        document.querySelector('#huella').required = false;
        document.querySelector('#facial').required = false;
        document.querySelectorAll('#preguntas_puertas input[type=radio]').forEach(function (checkElement) {
            checkElement.checked = false;
        })
    }else if( acceso.value === 'vehicular'){
        
        /*Aparecen las preguntas de vehicular */
        contenedorVehicular.classList.remove('d-none');
        document.querySelector('#telescopica').required = true;
        document.querySelector('#articular').required = true;

        /*Se quitan las preguntas de peatonal si estan activas */
        contenedorPeatonal.classList.add('d-none');
        document.querySelector('#cantidad_peatonal_MP_cBdLN29i2').required = false;
        document.querySelector('#accesos').required = false;

        const options = document.querySelectorAll('#preguntas_peatonal option');
        
        for (var i = 0, l = options.length; i < l; i++) {
            options[i].selected = options[i].defaultSelected;
        }
        resetContador();
        /*Se quitan las preguntas de puertas */
        contenedorPuerta.classList.add('d-none');
        document.querySelector('#huella').required = false;
        document.querySelector('#facial').required = false;
        document.querySelectorAll('#preguntas_puertas input[type=radio]').forEach(function (checkElement) {
            checkElement.checked = false;
        })
    }else{
         /*Aparecen las preguntas de puertas */
        contenedorPuerta.classList.remove('d-none');
        document.querySelector('#huella').required = true;
        document.querySelector('#facial').required = true;
         /*Se quitan las preguntas de peatonal si estan activas */
        contenedorPeatonal.classList.add('d-none');
        document.querySelector('#cantidad_peatonal_MP_cBdLN29i2').required = false;
        document.querySelector('#accesos').required = false;
        const options = document.querySelectorAll('#preguntas_peatonal option');

   
        
        for (var i = 0, l = options.length; i < l; i++) {
            options[i].selected = options[i].defaultSelected;
        }
        resetContador();

         /* se quitan las preguntas de vehicular si estan activas */
         contenedorVehicular.classList.add('d-none');
         document.querySelector('#telescopica').required = false;
         document.querySelector('#articular').required = false;
         preguntas_articulados.classList.add('d-none');
         preguntas_telescopica.classList.add('d-none');
 
         document.querySelectorAll('#preguntas_vehicular input[type=radio]').forEach(function (checkElement) {
             checkElement.checked = false;
         })
    }

}

function resetContador(){
    var element = document.getElementById('cantidad_peatonal');
        $(element).val('');
}

function tipoBarrera() {
    const preguntas_telescopica = document.querySelector('#preguntas_telescopica');
    const preguntas_articulados = document.querySelector('#preguntas_articulados');
    const barrera = document.querySelector('input[name="tipo_barrera"]:checked');
    if (barrera.value === 'telescopica') {
        preguntas_telescopica.classList.remove('d-none');
        preguntas_articulados.classList.add('d-none');
        document.querySelector('#brazo_articulado').required = false;
        document.querySelector('#brazo_telescopica').required = true;

        const options = document.querySelectorAll('#brazo_articulado option');

        for (var i = 0, l = options.length; i < l; i++) {
            options[i].selected = options[i].defaultSelected;
        }
    } else {
        preguntas_telescopica.classList.add('d-none');
        preguntas_articulados.classList.remove('d-none');
        document.querySelector('#brazo_telescopica').required = false;
        document.querySelector('#brazo_articulado').required = true;

        const options = document.querySelectorAll('#brazo_telescopica option');

        for (var i = 0, l = options.length; i < l; i++) {
            options[i].selected = options[i].defaultSelected;
        }
    }
}