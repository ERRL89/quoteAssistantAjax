const Arrayproductos = document.querySelectorAll('.productos_input');
const btnAdicionales = document.querySelector('#adicionales');
var myModal = new bootstrap.Modal(document.getElementById('form_kit_camara')) // Returns a Bootstrap modal instance



///let sumaProductos = 0;

myModal.show();


(function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()

eventListener();


function eventListener() {

    const formulario = document.querySelector('#cotizar-producto');
    formulario.addEventListener('submit', validarProducto);
}



function validarProducto(e) {
    e.preventDefault();
    // obtenemos todos los input radio del grupo horario que esten chequeados
    // si no hay ninguno lanzamos alerta
    const direccion = document.querySelector('input[name="direccion"]');

    if(direccion.value === ''){
        
        direccion.classList.add('error-text');

        setTimeout(() => {
            direccion.classList.remove('error-text')
        }, 3000)
        hasError = true;
    }

    if (document.querySelectorAll('.productos_input').checked == false){
        const cajaError = document.querySelector('#errores');
        const div = document.createElement('div');
        div.textContent = 'Debe seleccionar al menos un kit a cotizar';
        div.classList.add('error');

        cajaError.appendChild(div);

        setTimeout(() => {
            div.remove();
        }, 3000)
        hasError = true;
    }

    if (document.querySelectorAll('.adicionales_input').checked == false) {
        const cajaError = document.querySelector('#errores_adicional');
        const div = document.createElement('div');
        div.textContent = 'Debe seleccionar una opcion de adicional';
        div.classList.add('error');

        cajaError.appendChild(div);

        setTimeout(() => {
            div.remove();
        }, 3000)
        hasError = true;
    }


    // si hay algún error no efectuamos la acción submit del form
    if (hasError) e.preventDefault();
};






function seleccionandoProducto() {

    const kitSeleccionado = document.querySelector('input[name="kit"]:checked').value

    limpiarHtml();

   
    habilitarAdicionales();

}


function habilitarAdicionales(){
    for (let i = 0, j = Arrayproductos.length; i < j; i++) {

        if (Arrayproductos[i].checked == true) {
        
            const cajaAdicional = document.querySelector('#adicionales_principal');
            cajaAdicional.classList.remove('d-none');
        }
    }
}

function limpiarHtml() {
    const divDescripcion = document.querySelector('#descripcion');
    divDescripcion.innerHTML = '';
}


function resetearFormulario(){
    const adicionales = document.querySelector('#adicionales_principal')
    const formulario = document.querySelector('#cotizar-producto');
    const adicionalesPreguntas = document.querySelector('#adicionales')
       adicionales.classList.add('d-none');
       adicionalesPreguntas.classList.add('d-none');
       formulario.reset();
  
}








function agregarAdicionales() {

    const adicionalSeleccionado = document.querySelector('input[name="adicional"]:checked').value

    // mostrar formulario oculto

    if(adicionalSeleccionado === 'si'){
        const preguntaAdicional = document.querySelector('#adicionales')
        preguntaAdicional.classList.remove('d-none');
        preguntaAdicional.classList.add('d-block');
    }else{
        const preguntaAdicional = document.querySelector('#adicionales')
        preguntaAdicional.classList.remove('d-block');
        preguntaAdicional.classList.add('d-none');
    }

    

}


