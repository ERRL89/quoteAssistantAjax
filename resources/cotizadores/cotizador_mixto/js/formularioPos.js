const Arrayproductos = document.querySelectorAll('.productos_input');
const btnAdicionales = document.querySelector('#adicionales');
const principal = document.querySelectorAll('#preguntas_principales');
const contenedorRestaurante = document.querySelector('#preguntas_restaurante');
const contenedorOtros = document.querySelector('#preguntas_otro');
var myModal = new bootstrap.Modal(document.getElementById('form_kit_camara')) // Returns a Bootstrap modal instance



///let sumaProductos = 0;

myModal.show();

function punto() {

    const posSeleccion = document.querySelector('input[name="tienda"]:checked');
    
    if(posSeleccion.value == 'restaurante'){
        /*Aparacen las preguntas */
        contenedorRestaurante.classList.remove('d-none');
        /*Quitar preguntas de otros */
        contenedorOtros.classList.add('d-none');
        document.querySelector('#cantidad_tablet_MP_cBdLN29i2').required= true;
        document.querySelector('#cantidad_puntos_MP_cBdLN29i2').required= true;
        resetContador();
    }else{
        /*Aparacen las preguntas de otros*/
        contenedorRestaurante.classList.add('d-none');
        document.querySelector('#cantidad_otros_MP_cBdLN29i2').required= true;
        
        /*Quitar preguntas de restaurante*/
        document.querySelector('#cantidad_tablet_MP_cBdLN29i2').required= false;
        document.querySelector('#cantidad_puntos_MP_cBdLN29i2').required= false;
        contenedorOtros.classList.remove('d-none');
        resetContador2() 
        resetContador3()
    }
}

function resetContador() {
    var element = document.getElementById('cantidad_otros');
    $(element).val('');
}

function resetContador2() {
    var element = document.getElementById('cantidad_tablet');
    $(element).val('');
}

function resetContador3() {
    var element = document.getElementById('cantidad_puntos');
    $(element).val('');
}