var currentTab = 0; // Current tab is set to be the first tab (0) // Display the current tab

function cotizadorCOMBOS()
{
    showTab();
}


function showTab(n = 0) {
    // This function will display the specified tab of the form...
    let x = document.getElementsByClassName("step");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
}

function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("step");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
   /* if (currentTab == (x.length - 1)) {
        // ... the form gets submitted:
        //x[4].style.display = "block";
        
        
        async function asyncCall() {
          console.log('calling');
          document.getElementById("signUpForm").submit();
          const result = await resolveAfter2Seconds();
          console.log(result);
          // Expected output: "resolved"
        }
        
        asyncCall();

        
            
        
        
        return false;
    }*/

    removeStep(n)

    // Otherwise, display the correct tab:
    showTab(currentTab);
}

/*function resolveAfter2Seconds() {
          return new Promise((resolve) => {
            setTimeout(() => {
              resolve('resolved');
              window.location.reload();
            }, 2000);
          });
        }
*/

function reloader() {
    
            window.location.reload();
      
}     

function enviarForm(){
    document.getElementById("signUpForm").submit();
}
// function enviarFormulario(){
//     document.getElementById("signUpForm").submit();
// }

function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, z, select, valid = true;
    x = document.getElementsByClassName("step");
    y = x[currentTab].querySelectorAll(".valid");
    select = document.querySelector("select[name='cantidad_pixeles']");
    
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
            // add an "invalid" class to the field:
            y[i].className += " invalid";
            // and set the current valid status to false
            valid = false;
        }

        
    }

  
    if(!document.querySelector('input[name="instalacion"]:checked') && currentTab == 2){
        confirm('Seleccionar un tipo de inslatacion')
        valid = false;
        return false;
    }

    // if(!document.querySelector('input[name="conf_gabinete"]:checked') && currentTab == 2){
    //     confirm('Seleccionar si requiere gabinete')
    //     valid = false;
    //     return false;
    // }


    // for (z = 0; z < select.length; z++) {
    //     if (select[z].value == 0 || select[z].selected) {
    //         confirm('Seleccionar una opcion porfavor')
    //         return false;
    //     }
    // }

    //if (select.value == 0 && currentTab == 1) {
        //confirm('Seleccionar una opcion porfavor')
        //return false;
    //}



    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("stepIndicator")[currentTab].classList += " finish";
    }
    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("stepIndicator");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
}

function removeStep(n){
    if(n == -1){
        document.getElementsByClassName("stepIndicator")[currentTab].classList.remove('finish');

    }

}

function postes(opcion){

    if(opcion == 1){
        let mostrarPregunta = document.querySelector('#preguntaPoste');
        mostrarPregunta.classList.remove('d-none');
        
        let mostrarPregunta2 = document.querySelector('#preguntaPoste2');
        mostrarPregunta2.classList.remove('d-none');
        
    }else{
        let ocultarPregunta = document.querySelector('#preguntaPoste');
        ocultarPregunta.classList.add('d-none')
        
        let ocultarPregunta2 = document.querySelector('#preguntaPoste2');
        ocultarPregunta2.classList.add('d-none')
    }


}

function monitorAdd(opcion){

    if(opcion == 1){
        let mostrarPregunta = document.querySelector('#preguntaMonitor');
        mostrarPregunta.classList.remove('d-none')
    }else{
        let ocultarPregunta = document.querySelector('#preguntaMonitor');
        ocultarPregunta.classList.add('d-none')
    }

}


function microfonos(opcion){

    if(opcion == 1){
        // mostrar pregunta
        let mostrarPregunta = document.querySelector('.camaras_micro1');
        mostrarPregunta.classList.remove('d-none')
        let mostrarPregunta2 = document.querySelector('.camaras_micro2');
        mostrarPregunta2.classList.remove('d-none')

        //agregar required

        let agregarRequire = document.querySelector('.cam_ext_microfono');
        agregarRequire.classList.add('valid')


        let agregarRequire2 = document.querySelector('.cam_int_microfono');
        agregarRequire2.classList.add('valid')

    }else{
        //oculta las preguntas
        let ocultarPregunta = document.querySelector('.camaras_micro1');
        ocultarPregunta.classList.add('d-none');
        let ocultarPregunta2 = document.querySelector('.camaras_micro2');
        ocultarPregunta2.classList.add('d-none');

        //remuere los required

        let removerRequire = document.querySelector('.cam_ext_microfono');
        removerRequire.classList.remove('valid')


        let removerRequire2 = document.querySelector('.cam_int_microfono');
        removerRequire2.classList.remove('valid')

    }

}

function instalaciones(opcion){

    if(opcion == 2){
        //mostrar pregunta 
        let mostrarPregunta = document.querySelector('.premium');
        mostrarPregunta.classList.remove('d-none')

        //agregar required
        let agregarRequire = document.querySelector('.cantidad_canaleta');
        agregarRequire.classList.add('valid')

    }else{
        // ocultar pregunta
        let ocultarPregunta = document.querySelector('.premium');
        ocultarPregunta.classList.add('d-none')
        // eliminar required
        let removerRequire = document.querySelector('.cantidad_canaleta');
        removerRequire.classList.remove('valid')
    }

}

// let input1 = document.getElementById("cam_exterior");
// let input2 = document.getElementById("cam_interior");
// let input3 = document.getElementById("mic_exterior");
// let input4 = document.getElementById("mic_interior");

// // Agrega oyentes de eventos para el cambio en los valores de entrada
// input1.addEventListener("input", contador);
// input2.addEventListener("input", contador);
// input3.addEventListener("input", contador);
// input4.addEventListener("input", contador);

// function contador() {
//     const value1 = parseFloat(input1.value) || 0;
//     const value2 = parseFloat(input2.value) || 0;
//     const value3 = parseFloat(input3.value) || 0;
//     const value4 = parseFloat(input4.value) || 0;

//     const total = value1 + value2 + value3 + value4;

//     if (total > 32) {
//         const overflow = total - 32;

//         // Encuentra el valor máximo y resta el exceso de desbordamiento
//         const max = Math.max(value1, value2, value3, value4);

//         if (max === value1) {
//             input1.value = value1 - overflow;
//         } else if (max === value2) {
//             input2.value = value2 - overflow;
//         } else if (max === value3) {
//             input3.value = value3 - overflow;
//         } else {
//             input4.value = value4 - overflow;
//         }
//     }
// }




