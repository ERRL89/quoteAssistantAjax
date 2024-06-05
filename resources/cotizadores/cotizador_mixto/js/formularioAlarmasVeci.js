const Arrayproductos = document.querySelectorAll('.productos_input');
const btnAdicionales = document.querySelector('#adicionales');
const principal = document.querySelectorAll('#preguntas_principales');
const contenedorAdicional = document.querySelector('#preguntaAdicional');
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

/**** Eventos principales *****/

function controlesFisicos(){
    const decision = document.querySelector('input[name="decision"]:checked');
    if(decision.value === "si"){
        contenedorAdicional.classList.remove('d-none');
        document.querySelector('#cantidad_controles').required = true;
    }else{
        contenedorAdicional.classList.add('d-none');
        document.querySelector('#cantidad_controles_MP_cBdLN29i2').required = false;
        resetContador();
    }

}

function resetContador(){
    var element = document.getElementById('cantidad_controles');
        $(element).val('');
}

function resetearFormulario(){
    const adicionales = document.querySelector('#adicionales_principal')
    const formulario = document.querySelector('#cotizar-producto');
    const adicionalesPreguntas = document.querySelector('#adicionales')
       adicionales.classList.add('d-none');
       adicionalesPreguntas.classList.add('d-none');
       formulario.reset();
  
}





