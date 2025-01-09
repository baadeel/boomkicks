//Documento para validar la información del formulario

//Seleccionar los input del formulario y poner en un array
const arrayCampos = Array.from(document.querySelectorAll("#formulario input"));
arrayCampos.pop(); //Sacar el hidden

//Seleccionar campo select
const tipo = document.querySelector(".campo:nth-child(5)");

//Seleccionar select
const select = document.querySelector("select");

//Seleccionar hidden
const hidden = document.getElementById("id");

//Seleccionar los span de cada campo y ponerlos en un array
const arrayErrores = Array.from(document.querySelectorAll("#formulario .error"))

//Seleccionar los label de cada campo y ponerlos en un array
const arrayLabel = Array.from(document.querySelectorAll("#formulario label"));

//Seleccionar span con contador de errores
const contadorErrores = document.querySelector("#contadorErrores");

//Seleccionar el botón
const boton = document.getElementById("boton")

//Seleccionar los svg(icono de error) de cada campo y ponerlos en un array
const arraySvg = Array.from(document.querySelectorAll("#formulario svg"));

//Seleccionar el formulario
const form = document.getElementById("form");

//Contador
let contador;

//Expresiones regulares
const email = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const pass = /^(?=.*\d).{6,}$/



let errores = new Array(4);

//Comprobamos de donde venimos
if (document.referrer.includes("usuarios-adm.php")) {
    const link = document.getElementById("link-iniciar");
    const formulario = document.querySelector("#formulario");
    form.setAttribute("action", "/controlador/usuarios/admin/registrar-adm.php");
    boton.innerText = "Crear usuario";
    formulario.style.paddingBottom = 0;
    link.style.display = "none";
    tipo.style.display = "block";

    const parametros = new URLSearchParams(window.location.search);

    if (parametros.has("id")) {
        const id = parametros.get("id");

        let peticion = new XMLHttpRequest();

        let url = '/controlador/usuarios/admin/modificar-adm.php?id=' + encodeURIComponent(id);

        peticion.open("GET", url, true);
        peticion.send();

        peticion.onload = function () {
            if (peticion.status === 200) {
                form.setAttribute("action", "/controlador/usuarios/admin/modificar-adm.php");
                hidden.value = id;
                let usuario = JSON.parse(peticion.responseText);
                console.log(usuario)
                arrayCampos[0].value = usuario["nombre"];
                arrayCampos[1].value = usuario["email"];
                arrayCampos[2].setAttribute("type", "text");
                arrayCampos[3].setAttribute("type", "text");
                arrayCampos[2].value = usuario["pass"];
                arrayCampos[3].value = usuario["pass"];
                select.value = usuario["tipo"];

                document.querySelector("h1").textContent = "Modificar usuario";
                boton.textContent = "Actualizar datos";
            }
        };
    }

}

//Función: Comprobar si los campos estan vacíos
if (boton) {
    boton.addEventListener("click", function (e) {
        let focus = false;
        arrayCampos.forEach((element, index) => {
            //Comprobamos si hay campos vacíos
            if (element.value.trim() === "") {
                e.preventDefault();
                mostrarError(index, element, "Este campo no puede estar vacío");
            }
            //Comprobar contraseñas 
            else if (index === 2 || index === 3) {
                if (!pass.test(element.value)) {
                    mostrarError(index, element, "Debe tener al menos 6 carácteres y entre ellos 1 número.")
                } else if (arrayCampos[2].value !== arrayCampos[3].value) {
                    mostrarError(index, element, "Las contraseñas no son iguales");
                }
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
            peticion.open("POST", "/controlador/usuarios/verificar_email.php", true);

            peticion.onload = function () {
                if (peticion.status === 200) {
                    let respuesta = peticion.responseText;
                    if (respuesta === 'existe') {
                        mostrarError(index, element, "Este email ya pertenece a una cuenta");
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
    } else if (index === 3) {
        element.addEventListener("input", function () {
            if (pass.test(element.value)) {
                if (arrayCampos[2].value !== arrayCampos[3].value) {
                    mostrarError(index, element, "Las contraseñas no son iguales");
                } else {
                    eliminarError(2, arrayCampos[2]);
                    eliminarError(3, arrayCampos[3]);
                }
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