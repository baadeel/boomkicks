//Documento para validar la información del formulario

//Seleccionar los input del formulario y poner en un array
const arrayCampos = Array.from(document.querySelectorAll("#formulario1 input"));

//Seleccionar los span de cada campo y ponerlos en un array
const arrayErrores = Array.from(document.querySelectorAll("#formulario1 .error"))

//Seleccionar los label de cada campo y ponerlos en un array
const arrayLabel = Array.from(document.querySelectorAll("#formulario1 label"));

//Seleccionar span con contador de errores
const contadorErrores = document.querySelector("#contadorErrores");

//Seleccionar el botón actualizar
const actualizar = document.getElementById("actualizar-boton")

//Seleccionar el botón actualizar
const cancelar = document.getElementById("cancelar-boton")

//Seleccionar los svg(icono de error) de cada campo y ponerlos en un array
const arraySvg = Array.from(document.querySelectorAll("#formulario1 svg"));

//Contador
let contador;

//Expresiones regulares
const email = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;




let errores = new Array(2);

if(actualizar){
    actualizar.addEventListener("click", function (e) {
        let focus = false;
        arrayCampos.forEach((element, index) => {
            //Comprobamos si hay campos vacíos
            if (element.value.trim() === "") {
                e.preventDefault();
                mostrarError(index, element, "Este campo no puede estar vacío");
            }

            //Comprobar email
            if (index === 1) {
                if (!email.test(element.value)) {
                    e.preventDefault();
                    mostrarError(index, element, "Introduce un email válido");
                }
            } 
                       
            //Hacer focus donde esté el primer error del formulario
            if (arrayErrores[index].textContent != "") {
                if (!focus) {
                    arrayCampos[index].focus();
                    focus = true;
                }
            }
        });
        //Comprobamos si hay errores
        if (contadorDeErrores(errores) != 0) {
            e.preventDefault();
        }
    })
    }

    //Comprobamos si se rellena bien cada campo
arrayCampos.forEach((element, index) => {
    if (index === 1) {
       
        element.addEventListener("input", function () {
            if (email.test(element.value)) {
                eliminarError(index, element);
            }

            //Verificar si el email ya existe
            let peticion = new XMLHttpRequest();
            peticion.open("POST", "/controlador/usuarios/verificar_email_cuenta.php", true);
            
            peticion.onload = function() {
                if (peticion.status === 200) {
                    let respuesta = peticion.responseText;
                    if (respuesta === 'existe') {
                        mostrarError(index, element, "Este email ya pertenece a otra cuenta");
                    }
                } else {
                    console.log('Error con la solicitud. Estado: ' + peticion.status);
                }
            };

            peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            peticion.send('email=' + encodeURIComponent(document.getElementById('email').value));
        })
    } else if (index === 0) {
        element.addEventListener("input", function () {
            if (element.value.trim() !== "") {
                eliminarError(index, element);
            }
        })
    }
});




    //Mostrar error en la interfaz
function mostrarError(index, element, mensaje) {
    errores[index] = true;
    arrayErrores[index].textContent = mensaje;
    element.setAttribute("style", "border: 1px solid var(--color-error);");
    arrayLabel[index].setAttribute("style", "color: var(--color-error");
    arraySvg[index].setAttribute("style", "display: block");
    contadorDeErrores(errores);
}

//Eliminar error de la interfaz
function eliminarError(index, element) {
    errores[index] = false;
    arrayErrores[index].textContent = "";
    element.removeAttribute("style");
    arrayLabel[index].removeAttribute("style");
    arraySvg[index].removeAttribute("style");
    contadorDeErrores(errores);
}

//Contador de errores
function contadorDeErrores(errores) {
    let contador = 0;
    errores.forEach((error) => {
        if (error == true) {
            contador++;
        }
    })
    if (contador > 0) {
        if (contador == 1) {
            contadorErrores.textContent = "Tienes " + contador + " error";
        } else { contadorErrores.textContent = "Tienes " + contador + " errores"; }
        contadorErrores.setAttribute("style", "color: red; display: block");
    } else {
        contadorErrores.textContent = "";
    }
    return contador;
}


cancelar.addEventListener("click", () =>  {
    form1.style.display = "none";
    datos.style.display = "flex";
})