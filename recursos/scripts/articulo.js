
//Lógica y diseño de likes 
const corazon = document.querySelectorAll(".corazon");
let contadorLikes = document.getElementById("like-contador");
const div = document.getElementById("like");
corazon.forEach(e => {
    //Diseño
    e.addEventListener("mouseover", function () {
        e.setAttribute("src", "/recursos/img/iconos/corazon-relleno.png");
    });

    e.addEventListener("mouseout", function () {
        if (!e.classList.contains("like")) {
            e.setAttribute("src", "/recursos/img/iconos/corazon.png");
        }
    });

    //Diseño y petición DB
    e.addEventListener("click", function () {
        let idProducto = e.previousElementSibling.id.split("-")[1];

        //Enviar id del artículo, animación y modificar número en contador
        let peticion = new XMLHttpRequest();
        peticion.open("POST", "/controlador/productos/like.php", true);

        peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        peticion.send('id=' + idProducto);

        peticion.onload = function () {
            if (peticion.status === 200) {
                let respuesta = peticion.responseText.trim();

                if (respuesta === "registrar") {
                    window.location.href = "/vista/usuario/registro.php"
                } else if (respuesta === "ok") {
                    if (contadorLikes.style.display != "flex") {
                        contadorLikes.removeAttribute("style");
                    }
                    contadorLikes.innerText = parseInt(contadorLikes.innerText) + 1;
                    contadorLikes.classList.add("notificacion");
                    setTimeout(() => {
                        contadorLikes.classList.remove("notificacion");
                    }, 500);
                } else if (respuesta === "borrar") {
                    if (contadorLikes.innerHTML == "1") {
                        contadorLikes.innerHTML = "0";
                        contadorLike.style.display = "none";
                    } else {
                        contadorLikes.innerText = parseInt(contadorLikes.innerText) - 1;
                    }
                }
            } else {
                console.log('Error con la solicitud. Estado: ' + peticion.status);
            }
        };
        if (!e.classList.contains("like")) {
            let articulos = document.querySelectorAll(`#${e.previousElementSibling.id}`);
            articulos.forEach(articulo => {
                let corazonHijo = articulo.nextElementSibling;
                corazonHijo.setAttribute("src", "/recursos/img/iconos/corazon-relleno.png");
                corazonHijo.classList.add("like");
            })

        } else {
            let articulos = document.querySelectorAll(`#${e.previousElementSibling.id}`);
            articulos.forEach(articulo => {
                let corazonHijo = articulo.nextElementSibling;
                corazonHijo.setAttribute("src", "/recursos/img/iconos/corazon.png");
                corazonHijo.classList.remove("like");
            })
        }
    });
});