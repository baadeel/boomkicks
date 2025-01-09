const slider = document.querySelector(".slider");
const contenidoOriginalSlider = slider.innerHTML;
let selects = document.querySelectorAll("select");
let catFiltro = document.querySelector("#cat-filtro");
let marcaFiltro = document.querySelector("#marca-filtro");

//Lógica de los filtros (Categoría y marcas)
selects.forEach(e => {
    e.addEventListener("change", () => {

        if (catFiltro.value != "null" && marcaFiltro.value != "null") {
            let idCat = catFiltro.value;
            let idMarca = marcaFiltro.value;


            let peticion = new XMLHttpRequest();
            peticion.open("GET", "/controlador/productos/filtros.php?" +
                "cat=" + encodeURIComponent(idCat) +
                "&marca=" + encodeURIComponent(idMarca), true);

            peticion.setRequestHeader('Content-Type', 'application/json');
            peticion.send();

            peticion.onload = function () {
                if (peticion.status == 200) {
                    slider.innerHTML = peticion.response;
                }
            }


        } else if (catFiltro.value != "null") {
            let idCat = catFiltro.value;


            let peticion = new XMLHttpRequest();
            peticion.open("GET", "/controlador/productos/filtros.php?" +
                "cat=" + encodeURIComponent(idCat), true);

            peticion.setRequestHeader('Content-Type', 'application/json');
            peticion.send();

            peticion.onload = function () {
                if (peticion.status == 200) {
                    slider.innerHTML = peticion.response;
                }
            }


        } else if (marcaFiltro.value != "null") {

            let idMarca = marcaFiltro.value;

            let peticion = new XMLHttpRequest();
            peticion.open("GET", "/controlador/productos/filtros.php?" +
                "marca=" + encodeURIComponent(idMarca), true);

            peticion.setRequestHeader('Content-Type', 'application/json');
            peticion.send();

            peticion.onload = function () {
                if (peticion.status == 200) {
                    slider.innerHTML = peticion.response;
                }
            }
        } else {
            slider.innerHTML = contenidoOriginalSlider;
        }
    });

})

const idCat = new URLSearchParams(window.location.search).get("idCat") || null;
const idMarca = new URLSearchParams(window.location.search).get("idMarca") || null;

if(idCat){
    catFiltro.value = idCat;
    selects[0].dispatchEvent(new Event('change'));
}

if(idMarca) {
    marcaFiltro.value = idMarca;
    selects[1].dispatchEvent(new Event('change'));
}



