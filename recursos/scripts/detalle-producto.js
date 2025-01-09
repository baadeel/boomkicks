//Modal que aparece al querer eliminar un producto (Adm)
const modal = document.getElementById("modal");

const capaSuperior = document.getElementById("capa-superior");

const eliminar = document.getElementById("eliminar");

const idProducto = new URLSearchParams(window.location.search).get("id") || null;


const si = document.getElementById("si");

const no = document.getElementById("no");

eliminar.addEventListener("click", () => {
    modal.style.display = "block";
    capaSuperior.style.display = "block";
    no.focus();
})

no.addEventListener("click", () => {
    modal.style.display = "none";
    capaSuperior.style.display = "none";
})

//Lógica de elimar un producto
si.addEventListener("click", () => {
    let peticion = new XMLHttpRequest();
    peticion.open("POST", "/controlador/productos/eliminar.php", true);

    peticion.onload = function () {
        if (peticion.status === 200) {
            let respuesta = peticion.responseText;

            if (respuesta.trim() == 'ok') {
                window.location.href = "/vista/admin/articulos-adm.php";
            }
        } 
    };

    peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    peticion.send(`eliminar=true&idProducto=${idProducto}`);
})