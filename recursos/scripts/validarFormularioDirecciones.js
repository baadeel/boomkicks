//Documento para validar la información del formulario

//Seleccionar los input del formulario y poner en un array
const arrayCampos = Array.from(document.querySelectorAll("#formulario input"));
arrayCampos.pop(); //Sacamos el input hidden del idForm
arrayCampos.pop(); //Sacamos el input hidden del array


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

//Selecciona el input pagina referida
const paginaReferida = document.getElementById("pagina-referida");

//Seleccionar el input id
const idDireccion = document.getElementById("id");

//Contador
let contador;

//Expresiones regulares
const nombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s'-]{2,}$/;
    
const numero = /^\d{7,}/;


let errores = new Array(4);
console.log(arrayCampos);
if(boton){
    boton.addEventListener("click", function (e) {
        let focus = false;
        arrayCampos.forEach((element, index) => {
            //Comprobamos si hay campos vacíos
            if (element.value.trim() === "") {
                e.preventDefault();
                mostrarError(index, element, "Este campo no puede estar vacío");
            }
            if (index === 0){
                if (!nombre.test(element.value)) {
                    e.preventDefault();
                    mostrarError(index, element, "Introduce un nombre válido");
                }
            }
            //Comprobar tel
            if (index === 6) {
                if (!numero.test(element.value)) {
                    e.preventDefault();
                    mostrarError(index, element, "Introduce un número válido");
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
        //Comprobamos de donde venimos
        if(document.referrer.includes("confirmar-compra.php")){
            paginaReferida.value = true;
        }

        if(idFormulario){
            idDireccion.value = idFormulario;
        } 

    })
    }

//Comprobamos si se rellena bien cada campo
arrayCampos.forEach((element, index) => {
    if (index === 0) {
        element.addEventListener("input", function () {
            if (element.value.trim() !== "" && nombre.test(element.value)) {
                eliminarError(index, element);
            }
        })
    } else if (index === 6) {
        element.addEventListener("input", function () {
                console.log(numero.test(element.value))
            if (element.value.trim() !== "" && numero.test(element.value)) {
                console.log(element.value)
                eliminarError(index, element);
            }
        })
    } else {
        element.addEventListener("input", function () {
            if (element.value.trim() !== "") {
                eliminarError(index, element);
            }
        })
    }
});

//Comprobamos si hay que editar un formulario
const idFormulario = new URLSearchParams(window.location.search).get("id");
const form = document.getElementById("form");

if(idFormulario){
    let peticion = new XMLHttpRequest();
            peticion.open("GET", `/controlador/direcciones/editar.php?idDireccion=${idFormulario}`, true);
            peticion.send();
            peticion.onload = function () {
                if (peticion.status === 200) {
                    if(peticion.response){
                       const direccionEditar = JSON.parse(peticion.response);
                       arrayCampos.forEach(e => {
                        let campo = e.getAttribute("id");
                        e.value = direccionEditar[campo];
                       })

                       boton.innerText = "Actualizar datos";
                       
                    }
                }
            };

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
