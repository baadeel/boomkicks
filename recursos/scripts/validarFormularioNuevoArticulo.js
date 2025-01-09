//Documento para validar la información del formulario

//Seleccionar los input del formulario y poner en un array
const arrayCampos = Array.from(document.querySelectorAll("#fieldset-informacion input," +
    "#fieldset-informacion select, #fieldset-informacion textarea, #fieldset-imagen input"));
//arrayCampos.pop(); //Sacamos el input hidden del id
arrayCampos.splice(2, 1); //Sacamos el input de nueva marca

//Seleccionar nueva marca
const nuevaMarca = document.getElementById("nueva-marca");

//Seleccionar los span de cada campo y ponerlos en un array
const arrayErrores = Array.from(document.querySelectorAll("#formulario-articulo .error"))

//Seleccionar los label de cada campo y ponerlos en un array
const arrayLabel = Array.from(document.querySelectorAll("#formulario-articulo label"));

//Seleccionar span con contador de errores
const contadorErrores = document.querySelector("#contadorErrores");

//Seleccionar el botón
const boton = document.getElementById("boton")

//Seleccionar los svg(icono de error) de cada campo y ponerlos en un array
const arraySvg = Array.from(document.querySelectorAll("#formulario-articulo svg"));

//Seleccionar el input id
const id = document.getElementById("id");

//Form
const form = document.getElementById("form");

//Seleccionar preview imagen
const previewImagen = document.getElementById("preview-imagen");

//Bandera imagen
let imgFlag = false;

//Contador
let contador;

//Tamaño máximo de foto en bytes
const maxSize = 500 * 1024;

let errores = [];

console.log(arrayCampos);

if (boton) {
    boton.addEventListener("click", function (e) {
        let focus = false;
        arrayCampos.forEach((element, index) => {
            if (index === 1) {
                if (element.value == "null") {
                    e.preventDefault();
                    mostrarError(index, element, "Selecciona una marca o crea una nueva");
                }

                if (element.value == "nueva" && nuevaMarca.value.trim() === "") {
                    mostrarError(index, element, "Introduce el nombre de la nueva marca");
                    nuevaMarca.style.border = "1px solid var(--color-error)"
                }
            }

            if (index === 2) {
                if (element.value == "null") {
                    e.preventDefault();
                    mostrarError(index, element, "Selecciona una categoría");
                }
            }

            //No accedemos al input file
            if (index !== 6) {
                //Comprobamos si hay campos vacíos
                if (element.value.trim() === "") {
                    e.preventDefault();
                    mostrarError(index, element, "Este campo no puede estar vacío");
                }

            }
            if (index === 6) {
                if (element.files.length === 0 && !imgFlag) {
                    mostrarError(index, element, "Debes subir una imagen");
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
        //Cosas de editar producto?? comprobar
        if (idProducto) {
            id.value = idProducto;
        }
    })
}

//Comprobamos si se rellena bien cada campo
arrayCampos.forEach((element, index) => {
    if (index === 1 || index == 2) {
        element.addEventListener("change", function () {
            if (element.value !== "null") {
                eliminarError(index, element);
            }
        })

        if (index === 1) {
            element.addEventListener("change", function () {

                if (element.value == "nueva") {
                    nuevaMarca.style.display = "block";
                }

                console.log(element.value)
                if (element.value != "nueva") {
                    nuevaMarca.style.display = "none";
                    eliminarError(index, element);
                }
            })

            nuevaMarca.addEventListener("input", function () {
                if (element.value == "nueva" && nuevaMarca.value.trim() !== "") {
                    eliminarError(index, element);
                    nuevaMarca.style.removeProperty("border");
                }
            });
        }
    } else if (index === 6) {
        element.addEventListener("change", function () {

            if (element.files.length > 0) {
                eliminarError(index, element);
            }

            let file = element.files[0];

            if (file) {

                if (file.size > maxSize) {
                    mostrarError(index, element, "La foto ha superado el tamaño máximo de 500kb");
                } else {
                    eliminarError(index, element);
                }

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        previewImagen.src = e.target.result;
                        previewImagen.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                }
            }
        });

    } else {
        element.addEventListener("input", function () {
            if (element.value.trim() !== "") {
                eliminarError(index, element);
            }

        })
    }
});

//Comprobamos si hay que editar un formulario
const idProducto = new URLSearchParams(window.location.search).get("id");
const h1 = document.querySelector("h1");
const inputFile = document.getElementById("imagen");
if (idProducto) {
    id.value = idProducto;
    console.log(id.value);

    let peticion = new XMLHttpRequest();
    peticion.open("GET", `/controlador/productos/editar.php?id=${idProducto}`, true);
    peticion.send();
    peticion.onload = function () {
        if (peticion.status === 200) {
            if (peticion.response) {
                if (peticion.response.trim() != "") {
                    h1.innerText = "Modificar artículo";
                    boton.innerText = "Actualizar datos";
                    const productoEditar = JSON.parse(peticion.response);

                    arrayCampos[0].value = productoEditar["nombre"];
                    arrayCampos[1].value = productoEditar["marca"];
                    arrayCampos[2].value = productoEditar["categoria"];
                    arrayCampos[3].value = productoEditar["color"];
                    arrayCampos[4].value = productoEditar["precio"];
                    arrayCampos[5].value = productoEditar["descripcion"];
                    previewImagen.src = productoEditar["imagen"];
                    previewImagen.style.display = 'block';
                    imgFlag = true

                    form.setAttribute("action","/controlador/productos/editar.php");
                }

            }
        }
    };

    let peticion2 = new XMLHttpRequest();
    peticion2.open("GET", `/controlador/productos/editar.php?idProducto=${idProducto}&tallas=true`, true);
    peticion2.send();
    peticion2.onload = function () {
        if (peticion2.status === 200) {
            if (peticion2.response) {
                if (peticion2.response.trim() != "") {
                    const tallasCantidad = JSON.parse(peticion2.response);
                    for (const clave in tallasCantidad) {
                        if (tallasCantidad[clave] > 0) {
                            let tallaGrupo = document.createElement("div");
                            tallaGrupo.className = "talla-grupo";
                            tallaGrupo.innerHTML =
                                `<input value="${clave}" type="number" name="tallas[${tallaIndex}][talla]" placeholder="Talla (Ej: 40, 41,...)" min="1" required>` +
                                `<input value="${tallasCantidad[clave]}" type="number" name="tallas[${tallaIndex}][cantidad]" placeholder="Cantidad" min="1" required>` +
                                `<button class="eliminar" type="button" onClick="borrarTalla(this)">Eliminar</button>`;
                            contenedorTallas.appendChild(tallaGrupo);
                            tallaIndex++;
                        }
                    }
                }

            }
        }
    };


}

//Seleccionar boton añadir talla y contenedor tallas
const addTalla = document.getElementById("add-talla");
const contenedorTallas = document.getElementById("contenedor-tallas");
// Contador para identificar cada grupo de talla-cantidad
let tallaIndex = 0;

addTalla.addEventListener("click", () => {
    let tallaGrupo = document.createElement("div");
    tallaGrupo.className = "talla-grupo";
    tallaGrupo.innerHTML =
        `<input type="number" name="tallas[${tallaIndex}][talla]" placeholder="Talla (Ej: 40, 41,...)" min="1" required>` +
        `<input type="number" name="tallas[${tallaIndex}][cantidad]" placeholder="Cantidad" min="1" required>` +
        `<button class="eliminar" type="button" onClick="borrarTalla(this)">Eliminar</button>`;
    contenedorTallas.appendChild(tallaGrupo);
    tallaIndex++;
})

function borrarTalla(boton) {
    const tallaGrupo = boton.parentElement;
    tallaGrupo.remove();
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
