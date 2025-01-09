//Guardar carrito en la sesión
export function guardarCarrito() {
    let carrito = localStorage.getItem("carrito") || [];

    let peticion = new XMLHttpRequest();
    peticion.open("POST", "/controlador/carrito/guardarCarrito.php", true);

    peticion.setRequestHeader('Content-Type', 'application/json');
    peticion.send(carrito);

    peticion.onload = function () {
        if (peticion.status != 200) {
            console.log("Error al enviar cantidad")
        }
    }
}

//Guardar carrito en el LocalStorage
export function guardarDatosEnLista(idProducto, tallaSeleccionada, cantidad, cantidadTotal) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    let productoExistente = carrito.find(producto => producto.idProducto === idProducto && producto.tallaSeleccionada === tallaSeleccionada);

    if (productoExistente) {
        productoExistente.cantidad = parseInt(productoExistente.cantidad) + parseInt(cantidad);
        productoExistente.cantidadTotal = cantidadTotal;
    } else {
        let producto = { idProducto, tallaSeleccionada, cantidad, cantidadTotal };
        carrito.push(producto);
    }

    localStorage.setItem("carrito", JSON.stringify(carrito));
}

export function borrarProductoLista(idProducto, tallaSeleccionada){
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    let productoBorrar = carrito.find(producto => producto.idProducto === idProducto && producto.tallaSeleccionada === tallaSeleccionada);
    const index = carrito.indexOf(productoBorrar);
    carrito.splice(index, 1);

    localStorage.setItem("carrito", JSON.stringify(carrito));
}

//Aumentar contador del carrito
export function notificacionCarrito(cantidadSeleccionada) {
    contadorCarrito.removeAttribute("style");
    contadorCarrito.innerText = parseInt(contadorCarrito.innerText.trim()) + parseInt(cantidadSeleccionada);
    contadorCarrito.classList.add("notificacion");
    setTimeout(() => {
        contadorCarrito.classList.remove("notificacion");
    }, 500);
}


//Guardar el contador de productos del carrito
function sumarTotalCarrito() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    return carrito.reduce((total, producto) => total + parseInt(producto.cantidad), 0);
}

export function guardarContador() {
    const carritoContador = sumarTotalCarrito();
    
    let peticion = new XMLHttpRequest();
    peticion.open("POST", "/controlador/carrito/guardarContadorCarrito.php", true);

    peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    peticion.send('cantidad=' + carritoContador);

    peticion.onload = function () {
        if (peticion.status != 200) {
            console.log("Error al enviar cantidad")
        }
    }

}


