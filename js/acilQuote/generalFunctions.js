
//Función que retorna la respuesta de un proceso especifico por medio de pantallas.
function getProcessForm (inputForm, routeProcess, generalCanvas, table = false, elementsToHide = false, optionalFunction = false){
    
    //Le añadimos al formulario la clase para que detecte todos los required
    const form = $(`#${inputForm}`).addClass("was-validated");

    //Revisar la validación del form, [0] es debido a que buscamos en el array de Jquery de todos los form
    if(form[0].checkValidity()){ 

        //Se deshabilitan los elementos disabled para que se envien en el formulario
        let disabledElements = form.find(":disabled").prop("disabled", false); 

        //Se crea un objeto FormData con los datos del formulario
        let formData = new FormData(form[0]); 

        //Se vuelven a habilitar los elementos disabled
        disabledElements.prop("disabled", true);

        // Crear una barra de progreso visible antes de hacer la solicitud AJAX (Si no existe no pasa nada)
        let progressBar = $('#progressBar');
        progressBar.show();
        
        // Ocultamos el formulario desde antes para permitir la visualización de la barra
        $(`#${inputForm}`).hide();  //Se oculta el formulario

        ////////OPCIONAL: Ocultar elementos al mostrar formulario/////////
        if(elementsToHide){ //Si detecta que se deben ocultar elementos

            let = elementsToHideArray = elementsToHide.split(", "); //Se convierte el string en array

            elementsToHideArray.forEach(element => { //Se recorre el array de elementos a ocultar
                $(`#${element}`).hide(); //Se oculta el elemento
            });
        }
        //////////////////////////////////////////////////////////////////

        //Hacemos el proceso Ajax correspondiente
        $.ajax({
            url: routeProcess,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            // Función que se ejecuta durante el proceso de envío AJAX
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                // Evento que actualiza la barra de progreso (Si no existe no hace nada)
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = (evt.loaded / evt.total) * 100;
                        // Actualiza la barra de progreso durante la carga
                        progressBar.find('.progress-bar').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            // # Fin de función

            success: function(result){

                // Ocultar la barra de progreso cuando la solicitud se completa con éxito
                progressBar.hide();

                $(`#${generalCanvas}`).append(result); //Se añade la ventana de exito o error al body
                
                /*$(`#${inputForm}`).hide();  //Se oculta el formulario 
                
                ////////OPCIONAL: Ocultar elementos al mostrar formulario/////////
                if(elementsToHide){ //Si detecta que se deben ocultar elementos

                    let = elementsToHideArray = elementsToHide.split(", "); //Se convierte el string en array

                    elementsToHideArray.forEach(element => { //Se recorre el array de elementos a ocultar
                        $(`#${element}`).hide(); //Se oculta el elemento
                    });
                }
                //////////////////////////////////////////////////////////////////
                (Se movió un paso antes, por la barra de progreso)
                */

                $(`#${inputForm}`).removeClass("was-validated"); //Se quita la clase para que se vuelva a evaluar
                $(`#${inputForm}`).get(0).reset(); //Se reinician los campos del formulario

                ///OPCIONAL: Reiniciar tabla para actualizar datos///
                if(table){ //Si detecta que se ingresa una tabla 
                    $("#" + table).DataTable().ajax.reload(); //Se reinicia la tabla para actualizar datos
                }
                /////////////////////////////////////////////////////
               
                //Si detecta que se debe mostrar el formulario
                setTimeout(function() { //Se espera un intervalo para ejecutar las siguientes acciones

                    $("#windowNotice").remove(); //Se elimina el elemento de ventana exito o error

                    ////////OPCIONAL: Ejecutar función opcional/////////
                    if(optionalFunction){ //Si detecta que se debe ejecutar una función opcional
                        optionalFunction(); //Se ejecuta la función opcional
                    }
                    ///////////////////////////////////////////////////

                    $(`#${inputForm}`).fadeIn(); //Se muestra de nuevo el formulario con animación
                    
                    ////////OPCIONAL: Mostrar elementos al mostrar formulario/////////
                    if(elementsToHide){ //Si detecta que se deben mostrar elementos
                        elementsToHideArray.forEach(element => { //Se recorre el array de elementos a mostrar
                            $(`#${element}`).fadeIn(); //Se muestra el elemento
                        });
                    }
                    //////////////////////////////////////////////////////////////////

                }, 3000);        
                 
            },
            error: function() { 
                // Ocultar la barra de progreso.
                progressBar.hide();

                $(`#${inputForm}`).fadeIn(); //Se muestra de nuevo el formulario con animación
                
                ////////OPCIONAL: Mostrar elementos al mostrar formulario/////////
                if(elementsToHide){ //Si detecta que se deben mostrar elementos
                    elementsToHideArray.forEach(element => { //Se recorre el array de elementos a mostrar
                        $(`#${element}`).fadeIn(); //Se muestra el elemento
                    });
                }
                //////////////////////////////////////////////////////////////////
                setTimeout(function() {
                    alert("Error: Hubo un problema al cargar la información");         
                },500);
                
            }
        });
    }
}

// Objeto que administra registros de una tabla, su uso es prinicipalmente para procesos
// que requieran recargar formularios o elementos de la página con los datos ya actualizados
var RecordManager = {
    
    ///////////VARIABLES////////////////////////
    currentRecord: null, //Variable que almacena el registro actual
    currentRouteAction: null, //Variable que almacena la ruta de la acción actual
    currentCanvaUpdate: null, //Variable que almacena el canvas a actualizar
    currentData: null, //Variable que almacena los datos del registro actual
    currentDestinedAction: null,// Variable almacena la url de destino para una nueva pestaña
    ///////////////////////////////////////////

    /////////SETTERS///////////////////////////
    //Función para establecer el registro actual
    setCurrentRecord: function(recordId) {
        this.currentRecord = recordId;
    },

    //Función para establecer la ruta de la acción actual
    setCurrentRouteAction: function(routeAction) {
        this.currentRouteAction = routeAction;
    },

    //Función para establecer el canvas a actualizar
    setCurrentCanvaUpdate: function(canvaUpdate) {
        this.currentCanvaUpdate = canvaUpdate;
    },
    //Función para establecer los datos del registro actual
    setCurrentData: function(data) {
        this.currentData = data;
    },
    //Función para establecer la url del archivo en una nueva pestaña
    setCurrentDestinedUrl: function(routeDestined){
        this.currentDestinedAction = routeDestined;
    },
    ///////////////////////////////////////////

    /////////GETTERS///////////////////////////
    //Función para obtener el registro actual
    getCurrentRecord: function() {
        return this.currentRecord;
    },

    //Función para obtener la ruta de la acción actual
    getCurrentRouteAction: function() {
        return this.currentRouteAction;
    },

    //Función para obtener el canvas a actualizar
    getCurrentCanvaUpdate: function() {
        return this.currentCanvaUpdate;
    },

    //Función para obtener los datos del registro actual
    getCurrentData: function() {
        return this.currentData;
    },

    getCurrentDestinedUrl(){
        return this.currentDestinedAction;
    },

    ///////////////////////////////////////////

    ////////////MÉTODOS////////////////////////
    //Función para enviar el registro actual a un proceso (eliminar, actualizar, etc)
    //El argumento es un objeto para hacer más fácil el uso de parámetros opcionales
    sendRecordId: function(options = {}) { 
                
        let self = this; //Se almacena el objeto en una variable para poder acceder a sus métodos

        //Si no se establecieron los parámetros, se toman los valores de las variables actuales
        if(options.recordId){
            self.setCurrentRecord(options.recordId); //Se establece el registro actual
        }
        if(options.routeAction){
            self.setCurrentRouteAction(options.routeAction); //Se establece la ruta de la acción actual
        }
        if(options.canvaUpdate){
            self.setCurrentCanvaUpdate(options.canvaUpdate); //Se establece el canvas a actualizar
        }
        if(options.data){
            self.setCurrentData(options.data); //Se establecen los datos del registro actual
        }

        
        return $.ajax({
            url: self.getCurrentRouteAction(),
            type:'POST',
            data:{recordId:self.getCurrentRecord(), data:self.getCurrentData()},
            success: function(result){
                $(`#${self.getCurrentCanvaUpdate()}`).html(result);
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText + "\n" + status + "\n" +error);
            }
        });
        
    },
    ///////////////////////////////////////////

    ///Nueva funcion para abrir en un nueva pestaña una unica vez

    sendRecordUrl: function(options = {}) { 

        let self = this; //Se almacena el objeto en una variable para poder acceder a sus métodos

        //Si no se establecieron los parámetros, se toman los valores de las variables actuales
        if(options.recordId){
            self.setCurrentRecord(options.recordId); //Se establece el registro actual
        }
        if(options.routeAction){
            self.setCurrentRouteAction(options.routeAction); //Se establece la ruta de la acción actual
        }

        if(options.routeDestined){
            self.setCurrentDestinedUrl(options.routeDestined)
        }

        if(options.canvaUpdate){
            self.setCurrentCanvaUpdate(options.canvaUpdate); //Se establece el canvas a actualizar
        }
        if(options.data){
            self.setCurrentData(options.data); //Se establecen los datos del registro actual
        }

        
        return $.ajax({
          url: self.getCurrentRouteAction(), // Cambia 'tuphpfile.php' por el nombre de tu archivo PHP
          method: 'POST',
          data: {recordId:self.getCurrentRecord(), data:self.getCurrentData()},
          success: function(response) {
            // Abrir una nueva pestaña con la respuesta del servidor
            var nuevaPestana = window.open(`${self.getCurrentDestinedUrl()}`,"_blank" );
            nuevaPestana.onload = function(){
                nuevaPestana.document.write(response);
            }
          },
          error: function(error) {
            console.error('Error al realizar la petición AJAX', error);
          }
        });

    },

}

//Cierra un modal
function closeModal(modalId){
    $(`#${modalId}`).modal('hide');
}

//Añade texto a el titulo de un modal
function addTextToModalTitle(modalId, text){
    $(`#${modalId}-title-append`).html(text);
}

function fixTable()
{
    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    //console.log('Cargó');
}