import { guardarCarrito, guardarDatosEnLista, notificacionCarrito, guardarContador } from "./funcionesCarrito.js";

const confirmar = document.getElementById("confirmar");
const idProducto = document.querySelector(".zapatilla").getAttribute("id").split("-")[1];

//Funciones botón Agregar al carrito
confirmar.addEventListener("click", () => {
    let tallaSeleccionada = document.querySelector(".seleccionado");
    let cantidadSeleccionada = document.getElementById("cantidad").innerText;
    let numeroTalla = tallaSeleccionada.textContent;
    let maxCantidad = tallaSeleccionada.getAttribute("class").split(" ")[1];
    let maxCantidadActual = maxCantidad - cantidadSeleccionada;


    restarCantidadVista(tallaSeleccionada, cantidadSeleccionada);
    notificacionCarrito(cantidadSeleccionada);
    guardarDatosEnLista(idProducto, numeroTalla, cantidadSeleccionada, maxCantidadActual);
    guardarContador();
    guardarCarrito();
});

//Actualizar stock de los productos gráficamente
function restarCantidadVista(tallaSeleccionada, cantidadSeleccionada) {
    let maxCantidad = tallaSeleccionada.getAttribute("class").split(" ")[1];
    let cantidadActual = maxCantidad - cantidadSeleccionada;


    if (cantidadActual >= 0) {
        tallaSeleccionada.classList.remove(maxCantidad);
        tallaSeleccionada.classList.remove("seleccionado");
        tallaSeleccionada.classList.add(cantidadActual);
    }

    if (cantidadActual == 0) {
        tallaSeleccionada.remove();
    }

    info.textContent = "";
    boton.setAttribute("disabled", "true");
    contadorDiv.removeAttribute("style");
    contadorBotones.forEach(e => {
        e.removeAttribute("style");
        e.setAttribute("disabled", "true");
    })

    cantidad.style.color = "#bebebe";
}

//Recuperar el carrito y volver a restar el stock de los productos
function recuperarCarrito(idProducto){
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const productosEncontrados = carrito.filter(producto => producto.idProducto === idProducto); 

    productosEncontrados.forEach( e => {

        let numeroTalla = e.tallaSeleccionada;
        let talla = document.getElementById(`${numeroTalla}`);
        let cantidad = e.cantidad;

        restarCantidadVista(talla, cantidad);
    })
}


document.addEventListener("DOMContentLoaded", () => {
    recuperarCarrito(idProducto);
})

