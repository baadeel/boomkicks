
const buscador = document.getElementById("input-buscador");
if (!main) {
    const main = document.querySelector("main");
}
const contenidoOriginal = main.innerHTML;

//Lógicar del buscador
buscador.addEventListener('input', (event) => {
    let catFiltro = document.querySelector("#cat-filtro");
    let marcaFiltro = document.querySelector("#marca-filtro");

    const query = buscador.value;

    if (query.length > 1) {
        let peticion = new XMLHttpRequest();
        peticion.open("GET", "/controlador/productos/buscar.php?query=" + encodeURIComponent(query), true);

        peticion.setRequestHeader('Content-Type', 'application/json');
        peticion.send();

        peticion.onload = function () {
            console.log(peticion.response);
            if (peticion.status == 200) {
                main.innerHTML = peticion.response;
            }
        }
    } else if (query.length == 0) {
        main.innerHTML = contenidoOriginal;
    }

});



