//Lógica del buscador
const buscador = document.getElementById("input-buscador");
if (!main) {
    const main = document.querySelector("main");
}
const contenidoOriginal = main.innerHTML;

buscador.addEventListener('input', (event) => {
    if(window.location.href.includes("carrito") || window.location.href.includes("producto.php")){
        location.href = "/vista/productos/lista-productos.php"
    }

    const query = buscador.value;

    if (query.length > 1) {
        let peticion = new XMLHttpRequest();
        peticion.open("GET", "/controlador/productos/buscar.php?query=" + encodeURIComponent(query), true);

        peticion.setRequestHeader('Content-Type', 'application/json');
        peticion.send();

        peticion.onload = function () {
            if (peticion.status == 200) {
                main.innerHTML = peticion.response;
                logicaLikes();
            }
        }
    } else if (query.length == 0) {
        main.innerHTML = contenidoOriginal;
        logicaLikes();
        if(window.location.href.includes("carrito")){
            location.reload();
        }
    }

});




