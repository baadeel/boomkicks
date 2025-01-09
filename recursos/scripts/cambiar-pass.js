//Documento para validar la información del formulario

//Seleccionar los input del formulario y poner en un array
const arrayCampos2 = Array.from(document.querySelectorAll("#formulario2 input"));

//Seleccionar los span de cada campo y ponerlos en un array
const arrayErrores2 = Array.from(document.querySelectorAll("#formulario2 .error"))

//Seleccionar los label de cada campo y ponerlos en un array
const arrayLabel2 = Array.from(document.querySelectorAll("#formulario2 label"));

//Seleccionar span con contador de errores
const contadorErrores2 = document.querySelector("#contadorErrores2");

//Seleccionar el botón actualizar
const actualizar2 = document.getElementById("actualizar-pass")

//Seleccionar el botón actualizar
const cancelar2 = document.getElementById("cancelar-pass")

//Seleccionar los svg(icono de error) de cada campo y ponerlos en un array
const arraySvg2 = Array.from(document.querySelectorAll("#formulario2 svg"));

//Contador
let contador2;

//Expresiones regulares
const pass = /^(?=.*\d).{6,}$/



let errores2 = new Array(3);

if (actualizar2) {
    actualizar2.addEventListener("click", function (e) {
        let focus = false;
        arrayCampos2.forEach((element, index) => {
            //Comprobamos si hay campos vacíos
            if (element.value.trim() === "") {
                e.preventDefault();
                mostrarError(index, element, "Este campo no puede estar vacío");
            }

            //Comprobar contraseñas 
            else if (index === 2) {
                if (!pass.test(element.value)) {
                    mostrarError(index, element, "Debe tener al menos 6 carácteres y entre ellos 1 número.")
                } else if (arrayCampos2[1].value !== arrayCampos2[2].value) {
                    mostrarError(index, element, "Las contraseñas no son iguales");
                }
            }

            else if (index === 0) {
                //Comprobar contraseña actual
                let peticion = new XMLHttpRequest();
                peticion.open("POST", "/controlador/usuarios/comprobar-pass.php", false);

                peticion.onload = function () {
                    if (peticion.status === 200) {
                        let respuesta = peticion.responseText;
                        console.log(respuesta);
                        if (respuesta === 'error') {
                            mostrarError(index, element, "Contraseña errónea");
                            e.preventDefault();
                        }
                    } else {
                        eliminarError(index, element);
                    }
                };

                peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                peticion.send('passVieja=' + encodeURIComponent(arrayCampos2[0].value));
            }

            //Hacer focus donde esté el primer error del formulario
            if (arrayErrores2[index].textContent != "") {
                if (!focus) {
                    arrayCampos2[index].focus();
                    focus = true;
                }
            }
        });
        //Comprobamos si hay errores
        if (contadorDeErrores(errores2) != 0) {
            e.preventDefault();
        }
    })
}

//Comprobamos si se rellena bien cada campo
arrayCampos2.forEach((element, index) => {
    element.addEventListener("input", function () {
        if (element.value.trim() !== "") {
            eliminarError(index, element);
        }
    })
});




//Mostrar error en la interfaz
function mostrarError(index, element, mensaje) {
    errores2[index] = true;
    arrayErrores2[index].textContent = mensaje;
    element.setAttribute("style", "border: 1px solid var(--color-error);");
    arrayLabel2[index].setAttribute("style", "color: var(--color-error");
    arraySvg2[index].setAttribute("style", "display: block");
    contadorDeErrores(errores2);
}

//Eliminar error de la interfaz
function eliminarError(index, element) {
    errores2[index] = false;
    arrayErrores2[index].textContent = "";
    element.removeAttribute("style");
    arrayLabel2[index].removeAttribute("style");
    arraySvg2[index].removeAttribute("style");
    contadorDeErrores(errores2);
}

//Contador de errores
function contadorDeErrores(errores) {
    let contador = 0;
    errores2.forEach((error) => {
        if (error == true) {
            contador++;
        }
    })
    if (contador > 0) {
        if (contador == 1) {
            contadorErrores2.textContent = "Tienes " + contador + " error";
        } else { contadorErrores2.textContent = "Tienes " + contador + " errores"; }
        contadorErrores2.setAttribute("style", "color: red; display: block");
    } else {
        contadorErrores2.textContent = "";
    }
    return contador;
}


cancelar2.addEventListener("click", () => {
    form2.style.display = "none";
    datos.style.display = "flex";
})