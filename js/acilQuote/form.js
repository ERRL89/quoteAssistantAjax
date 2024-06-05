var currentTab = 0; // Current tab is set to be the first tab (0) // Display the current tab
var myModal = new bootstrap.Modal(document.getElementById('exampleModal')) // Returns a Bootstrap modal instance
        showTab()

        function showTab(n=0) {
          // This function will display the specified tab of the form...
          let x = document.getElementsByClassName("step");
          x[n].style.display = "block";
          //... and fix the Previous/Next buttons:
          if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
          } else {
            document.getElementById("prevBtn").style.display = "inline";
          }
          if((n == (x.length - 1))){
            document.getElementById("nextBtn").innerHTML = "Pagar";
          }else {
              document.getElementById("nextBtn").innerHTML = "Siguiente";
          }
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
          if (currentTab >= x.length) {
            myModal.show();
            // ... the form gets submitted:
              //x[4].style.display = "block";
             setTimeout( () =>{
              enviarFormulario();
            }, 3000);

           
             
            return false;
          }
          // Otherwise, display the correct tab:
          showTab(currentTab);
        }

        function enviarFormulario(){
          document.getElementById("signUpForm").submit();
        }
        
        function validateForm() {
          // This function deals with validation of the form fields
          var x, y, i, z, select,  valid = true;
          x = document.getElementsByClassName("step");
          y = x[currentTab].getElementsByTagName("input");
          select = x[currentTab].getElementsByTagName("select");
          
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

         for(z=0; z <select.length ; z++){
            if(select[z].value == 0 || select[z].selected){
              confirm('Seleccionar una opcion porfavor')  
              return false;            
          }
        }

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
            x[i].className = x[i].className.replace("active","");
          }
          //... and adds the "active" class on the current step:
          x[n].className += " active";
        }
        
        function mostrarModal(){
            myModal.show();
        }

        