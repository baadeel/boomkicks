
//Seleccionar elementos
const arrayCampos = Array.from(document.querySelectorAll("#formulario input"));

const arrayErrores = Array.from(document.querySelectorAll("#formulario .error"))

const arrayLabel = Array.from(document.querySelectorAll("#formulario label"));

const boton = document.getElementById("boton");

const arraySvg = Array.from(document.querySelectorAll("#formulario svg"));

const cuentaIncorrecta = document.getElementById("cuenta-incorrecta");

const form = document.getElementById("form");

//Expresión regular
const email = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

//Contador
let contador;

//Array de errores
let errores = new Array(2);

if (form) {
    form.addEventListener("submit", function (e) {
        arrayCampos.forEach((element, index) => {
            //Comprobamos si hay campos vacíos
            if (element.value.trim() === "") {
                e.preventDefault();
                mostrarError(index, element, "Este campo no puede estar vacío");
            } else if (index === 0) {
                if (!email.test(element.value)) {
                    e.preventDefault();
                    mostrarError(index, element, "Introduce un email válido");
                } else {
                    eliminarError(index, element);
                }
            } else {
                eliminarError(index, element);
            }
        });
        if (contadorDeErrores(errores) != 0) {
            e.preventDefault();

        } else {
            //Verificar cuenta
            let peticion = new XMLHttpRequest();
            peticion.open("POST", "/controlador/usuarios/loguear_usuario.php", true);
            peticion.onload = function () {
                if (peticion.status === 200) {
                    let respuesta = peticion.responseText.trim();
                    console.log(respuesta);
                    if (respuesta === 'correcto0') {
                        cuentaIncorrecta.textContent = "";
                        form.submit();
                    } else if (respuesta === 'incorrecto') {
                        e.preventDefault();
                        cuentaIncorrecta.textContent = "Usuario o contraseña incorrecto."
                        arrayCampos[1].value = "";
                    } else if(respuesta === 'correcto1'){
                        window.location.href = "/vista/admin/panel-adm.php"
                    }
                } else {
                    e.preventDefault();
                    console.log('Error con la solicitud. Estado: ' + peticion.status);
                }
            };

            peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            peticion.send('email=' + encodeURIComponent(document.getElementById('email').value) +
                '&pass=' + encodeURIComponent(document.getElementById('pass').value));
        }
        e.preventDefault();
    });
}


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
    return contador;
}