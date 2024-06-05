const Arrayproductos = document.querySelectorAll('.productos_input');
const btnAdicionales = document.querySelector('#adicionales');
const principal = document.querySelectorAll('#preguntas_principales');
const contenedorVideoportero = document.querySelector('#preguntas_video');
const contenedorSecundario = document.querySelector('#preguntas_ip');
const contenedorSecundario2 = document.querySelector('#preguntas_analogo');
const contenedorSecundarioVideo = document.querySelector('#adicional_ip');
const contenedorSecundarioVideo2 = document.querySelector('#adicional_domestico');
const contenedorPrincipalInterfon = document.querySelector('#preguntas_intefon');
const contenedorAdicionalInterfon = document.querySelector('#adicional_interfon');
const contenedorAdicionalInterfon2 = document.querySelector('#adicional_interfon2');
var myModal = new bootstrap.Modal(document.getElementById('form_kit_camara')) // Returns a Bootstrap modal instance



///let sumaProductos = 0;

myModal.show();

function portero() {
    const portero = document.querySelector('input[name="tipo_portero"]:checked');
    if (portero.value == 'videoportero') {
        /* Aparece al seleccionar */
        contenedorVideoportero.classList.remove('d-none');
        document.querySelector('#video').required = true;
        document.querySelector('#interfon').required = true;
        document.querySelector('#analogo').required = true;
        document.querySelector('#cantidad_contestadores_ip').required = false;
        document.querySelector('#ip').required = true;

        /* Se quitan las preguntas de interfon  */
        contenedorPrincipalInterfon.classList.add('d-none');
        contenedorAdicionalInterfon.classList.add('d-none');
        contenedorAdicionalInterfon2.classList.add('d-none');
        document.querySelector('#casas').required = false;
        document.querySelector('#otro').required = false;
        document.querySelector('#cantidad_contestadores_interfon').required = false;
        document.querySelectorAll('#preguntas_intefon input[type=radio]').forEach(function (checkElement) {
            checkElement.checked = false;
        })
        resetContador2();
    } else {
        /*Se agregan las preguntas de interfon */
        contenedorPrincipalInterfon.classList.remove('d-none');
        document.querySelector('#casas').required = true;
        document.querySelector('#otro').required = true;
        /*Se quitan las preguntas de videportero */
        document.querySelectorAll('#preguntas_video input[type=radio]').forEach(function (checkElement) {
            checkElement.checked = false;
        })
        contenedorVideoportero.classList.add('d-none');
        contenedorSecundario.classList.add('d-none');
        contenedorSecundarioVideo.classList.add('d-none');
        contenedorSecundarioVideo2.classList.add('d-none');
        document.querySelector('#video').required = false;
        document.querySelector('#interfon').required = false;
        document.querySelector('#analogo').required = false;
        document.querySelector('#ip').required = false;
        document.querySelector('#casa').required = false;
        document.querySelector('#departamento').required = false;
        document.querySelector('#cantidad_contestadores_analogo').required = false;
        document.querySelector('#departamentos_ip_MP_cBdLN29i2').required = false;
        document.querySelector('#cantidad_contestadores_ip').required = false;
        resetContador()
    }
}

function tecnologiaSeleccion() {

    const seleccionTecnologia = document.querySelector('input[name="tecnologia"]:checked');
    if (seleccionTecnologia.value == 'ip') {
        contenedorSecundario2.classList.add('d-none');
        contenedorSecundario.classList.remove('d-none');
        document.querySelector('#casa').required = true;
        document.querySelector('#departamento').required = true;
        document.querySelector('#cantidad_contestadores_analogo').required = false;
        const options = document.querySelectorAll('#cantidad_contestadores_analogo option');
        for (var i = 0, l = options.length; i < l; i++) {
            options[i].selected = options[i].defaultSelected;
        }
    }
    else {
        contenedorSecundario2.classList.remove('d-none');
        contenedorSecundario.classList.add('d-none');
        contenedorSecundarioVideo.classList.add('d-none');
        contenedorSecundarioVideo2.classList.add('d-none');
        document.querySelector('#cantidad_contestadores_analogo').required = true;
        document.querySelector('#cantidad_contestadores_interfon').required = false;
        document.querySelector('#cantidad_contestadores_ip').required = false;
        document.querySelector('#casa').required = false;
        document.querySelector('#departamento').required = false;
        document.querySelector('#departamentos_ip_MP_cBdLN29i2').required = false;
        document.querySelectorAll('#preguntas_ip input[type=radio]').forEach(function (checkElement) {
            checkElement.checked = false;
        })
        resetContador()
    }
}

function lugarIp() {
    const seleccionaLugarip = document.querySelector('input[name="lugar_ip"]:checked');
    if (seleccionaLugarip.value == 'departamento') {
        contenedorSecundarioVideo.classList.remove('d-none');
        contenedorSecundarioVideo2.classList.add('d-none');
        document.querySelector('#departamentos_ip_MP_cBdLN29i2').required = true;
        document.querySelector('#cantidad_contestadores_ip').required = false;
        const options = document.querySelectorAll('#cantidad_contestadores_ip option');
        for (var i = 0, l = options.length; i < l; i++) {
            options[i].selected = options[i].defaultSelected;
        }
    } else {
        contenedorSecundarioVideo.classList.add('d-none');
        contenedorSecundarioVideo2.classList.remove('d-none');
        document.querySelector('#cantidad_contestadores_ip').required = true;
        document.querySelector('#departamentos_ip_MP_cBdLN29i2').required = false;
        resetContador();
    }
}

function lugarInterfon() {
    const interfon = document.querySelector('input[name="lugar_interfon"]:checked');
    if (interfon.value == 'otro') {
        contenedorAdicionalInterfon.classList.remove('d-none');
        contenedorAdicionalInterfon2.classList.add('d-none');
        document.querySelector('#cantidad_contestadores_interfon').required = false;
        document.querySelector('#cantidad_casas_MP_cBdLN29i2').required = true;
        const options = document.querySelectorAll('#cantidad_contestadores_interfon option');

        for (var i = 0, l = options.length; i < l; i++) {
            options[i].selected = options[i].defaultSelected;
        }
    } else {
        contenedorAdicionalInterfon.classList.add('d-none');
        contenedorAdicionalInterfon2.classList.remove('d-none');
        document.querySelector('#cantidad_contestadores_interfon').required = true;
        document.querySelector('#cantidad_casas_MP_cBdLN29i2').required = false;
        resetContador2();
    }
}

function resetContador() {
    var element = document.getElementById('departamentos_ip');
    $(element).val('');
}

function resetContador2() {
    var element = document.getElementById('cantidad_casas');
    $(element).val('');
}