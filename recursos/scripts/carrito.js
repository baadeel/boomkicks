import { guardarDatosEnLista, guardarCarrito, borrarProductoLista, notificacionCarrito } from "./funcionesCarrito.js";


const sumar = document.querySelectorAll(".sumar");
const restar = document.querySelectorAll(".restar");

//Sumar un artículo al carrito
sumar.forEach(e => {
    let producto = e.closest(".producto");
    let idProducto = producto.getAttribute("id").split("-")[0];
    let talla = producto.getAttribute("id").split("-")[1];
    let cantidad = e.parentElement.querySelector("#cantidad");
    let precio = e.parentElement.parentElement.querySelector("#precio");
    let total = document.getElementById("total");
    let restar = e.parentElement.querySelector(".restar");


    if (cantidad.className == 0) {
        e.setAttribute("disabled", "true");
        e.style.cursor = "not-allowed";
    }

    e.addEventListener("click", () => {
        let cantidadTotal = parseInt(cantidad.className);
        cantidad.className = cantidadTotal - 1;
        cantidad.innerHTML = parseInt(cantidad.innerHTML) + 1;
        precio.innerText = parseInt(precio.classList) * parseInt(cantidad.innerHTML) + " €";
        total.innerText = parseInt(total.innerText) + parseInt(precio.classList) + " €";


        if (cantidad.className == 0) {
            e.setAttribute("disabled", "true");
            e.style.cursor = "not-allowed";
        }

        if (cantidad.innerText > 1) {
            restar.removeAttribute("style");
            restar.innerHTML = "-";
        }

        notificacionCarrito(1);
        guardarDatosEnLista(idProducto, talla, 1, cantidad.className);
        guardarCarrito();
        guardarContador();

    });
})

//Restar un artículo al carrito
restar.forEach(e => {
    let producto = e.closest(".producto");
    let idProducto = producto.getAttribute("id").split("-")[0];
    let talla = producto.getAttribute("id").split("-")[1];
    let cantidad = e.parentElement.querySelector("#cantidad");
    let precio = e.parentElement.parentElement.querySelector("#precio");
    let total = document.getElementById("total");
    let sumar = e.parentElement.querySelector(".sumar");

    if (cantidad.innerText == 1) {
        e.innerText = "";
        e.innerHTML = "<img width='20px' src='/recursos/img/iconos/delete.png'></img>";
        e.style.backgroundColor = "#ff5b5b";
    }

    e.addEventListener("click", () => {
        contadorCarrito.innerText = parseInt(contadorCarrito.innerText.trim()) - 1;
        total.innerText = parseInt(total.innerText) - parseInt(precio.classList) + " €";

        if (cantidad.innerText == 1) {
            e.innerText = "";
            e.innerHTML = "<img width='20px' src='/recursos/img/iconos/delete.png'></img>";
            e.style.backgroundColor = "#ff5b5b";

            //Eliminar producto del carrito
            producto.remove();
            borrarProductoLista(idProducto, talla);
            let peticion = new XMLHttpRequest();
            peticion.open("POST", "/controlador/carrito/eliminarArticulo.php", true);
            
            peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            peticion.send('idProducto=' + idProducto + '&talla=' + talla);

            peticion.onload = function () {
                console.log(peticion.response);
                if (peticion.status != 200) {
                   console.log("error");
                }
            }

        } else {
            let cantidadTotal = parseInt(cantidad.className);
            cantidad.className = cantidadTotal + 1;
            cantidad.innerHTML = parseInt(cantidad.innerHTML) - 1;
            precio.innerText = parseInt(precio.classList) * parseInt(cantidad.innerHTML) + " €";

            if (cantidad.innerText == 1) {
                e.innerText = "";
                e.innerHTML = "<img width='20px' src='/recursos/img/iconos/delete.png'></img>";
                e.style.backgroundColor = "#ff5b5b";
            }

            if (cantidad.className > 0) {
                sumar.removeAttribute("style");
                sumar.removeAttribute("disabled");
            }

            guardarDatosEnLista(idProducto, talla, -1, cantidad.className);
        }

        guardarContador();
        guardarCarrito();

        if (contadorCarrito.innerText == 0) {

            setTimeout(() => {
                window.location.reload();
            }, 500);

        }
    });


});

//Confirmar compra

const confirmar = document.getElementById("confirmar");
if (confirmar) {
    confirmar.addEventListener("click", () => {
        let peticion = new XMLHttpRequest();
        peticion.open("POST", "/controlador/carrito/confirmar.php", true);

        peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        peticion.send('total=' + total.innerText.split(" ")[0]);
        peticion.onload = function () {
            if (peticion.status == 200) {
                if (peticion.response == "registro") {
                    location.href = "/vista/usuario/registro.php";
                } else if (peticion.response == "confirmar") {
                    location.href = "/vista/carrito/confirmar-compra.php"
                }
            }
        }
    });
}


