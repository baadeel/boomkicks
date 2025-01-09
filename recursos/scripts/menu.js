

//Seleccionar elementos del menú
const menuSandwich = document.getElementById("menu-sandwich");
const menuLateral = document.getElementById("menu-lateral");
const volverAtras = document.getElementById("volver-atras");
const cerrarMenu = document.getElementById("cerrar-menu");
const botonMarcas = document.getElementById("boton-marcas");
const menuLateralPrincipal = document.getElementById("menu-lateral-principal");
const menuLateralMarcas = document.getElementById("menu-lateral-marcas");
const main = document.querySelector("main");

//Funciones menú móvil
menuSandwich.addEventListener("click", function () {
    menuLateral.classList.toggle("visible");
    main.style.display = "none";
})

cerrarMenu.addEventListener("click", function () {
    menuLateral.classList.toggle("visible");
    main.style.display = "block";
})

botonMarcas.addEventListener("click", function () {
    menuLateralPrincipal.style.display = "none";
    menuLateralMarcas.style.display = "block";
    cerrarMenu.style.display = "none";
    volverAtras.style.display = "block";
})

volverAtras.addEventListener("click", function () {
    menuLateralPrincipal.style.display = "block";
    menuLateralMarcas.style.display = "none";
    cerrarMenu.style.display = "block";
    volverAtras.style.display = "none";
})

//Seleccionar elementos buscador y logo
const logo = document.getElementById("logo");
const inputBuscador = document.getElementById("input-buscador");
const botonLupa = document.getElementById("boton-lupa");
const containerBuscador = document.getElementById("container-buscador");
const cerrarBuscador = document.getElementById("cerrar-buscador");

//Función buscador móvil
let buscadorMovil = function () {
    logo.style.display = "none";
    inputBuscador.style.display = "block";
    botonLupa.style.backgroundColor = "var(--color-secundario)";
    botonLupa.style.width = "auto";
    containerBuscador.style.width = "65%";
    cerrarBuscador.style.display = "block";
    inputBuscador.focus();
}

botonLupa.addEventListener("click", function () {
    inputBuscador.focus();
})

botonLupa.addEventListener("click", buscadorMovil);


cerrarBuscador.addEventListener("click", function () {
    logo.style.display = "flex";
    inputBuscador.style.display = "none";
    botonLupa.style.backgroundColor = "white";
    botonLupa.style.width = "17%";
    containerBuscador.style.width = "auto";
    cerrarBuscador.style.display = "none";
})


//Navegación horizontal, seleccionar elemento
const nav = document.getElementById("menu-horizontal");
const enlaces = document.querySelectorAll("#menu-horizontal-principal a");
const linea = document.getElementById("menu-linea");
const header = document.querySelector("header");



//Función pasar la navegacion al sticky en pc
function navHeader() {
    nav.style.gridRow = "2/3";
    header.appendChild(nav);
}

function navMain() {
    nav.style.gridRow = "";
    main.insertBefore(nav, main.firstChild);
}

//Selecionar botones cabecera
const botones = document.getElementById("botones");



//Mostar/Ocultar elementos según el ancho
function reiniciarElementos() {
    let width = window.innerWidth;
    if (width >= 760) {
        logo.style.display = "flex";
        menuLateral.classList.remove("visible");
        inputBuscador.style.display = "block";
        botonLupa.style.backgroundColor = "var(--color-secundario)";
        botonLupa.removeEventListener("click", buscadorMovil);
        botonLupa.style.width = "";
        cerrarBuscador.style.display = "none";
        menuSandwich.style.display = "none";
        botones.style.display = "flex";
        navHeader();


    } else if (width < 760) {
        inputBuscador.style.display = "none";
        logo.style.display = "flex";
        botonLupa.style.backgroundColor = "white";
        containerBuscador.style.width = "auto";
        menuSandwich.style.display = "block";
        botones.style.display = "none";
        botonLupa.addEventListener("click", buscadorMovil);
        navMain();
    }
}

//Iconos y Navegación desplegable de User
const corazonIcon = document.getElementById("corazon-icon");
const userIcon = document.getElementById("user-icon");
const carritoIcon = document.getElementById("carrito-icon");
const carritoIconNoLogin = document.getElementById("carrito-icon-nologin");
const userNav = document.getElementById("user-nav");
const contadorLike = document.getElementById("like-contador");
const contadorCarrito = document.getElementById("carrito-contador")


if(contadorLike && contadorLike.innerText == "0"){
    contadorLike.style.display = "none";
}

if(contadorCarrito && contadorCarrito.innerText == "0"){
    contadorCarrito.style.display = "none";
}

if(carritoIcon != null){
    carritoIcon.addEventListener("mouseover", () => {
        if (contadorCarrito != null) {
            contadorCarrito.style.backgroundColor = "var(--color-principal)";
            contadorCarrito.style.border = "0px solid #000"
        }
        carritoIcon.setAttribute("src", "/recursos/img/iconos/carrito-naranja.png")

    });

    carritoIcon.addEventListener("mouseout", () => {
        if (contadorCarrito != null && contadorCarrito.innerText.trim() != "0"){
            contadorCarrito.removeAttribute("style");
        }
        carritoIcon.setAttribute("src", "/recursos/img/iconos/carrito.png")
    })
}

if (corazonIcon != null && userIcon != null && carritoIcon != null) {
    corazonIcon.addEventListener("mouseover", () => {
        if (contadorLike != null) {
            contadorLike.style.backgroundColor = "var(--color-principal)";
            contadorLike.style.border = "0px solid #000"
        }
        corazonIcon.setAttribute("src", "/recursos/img/iconos/corazon-relleno.png")
    });

    corazonIcon.addEventListener("mouseout", () => {
        if (contadorLike != null && contadorLike.innerText != "0"){
            contadorLike.removeAttribute("style");
        }
        corazonIcon.setAttribute("src", "/recursos/img/iconos/corazon.png")
    })

    userIcon.addEventListener("mouseover", () => {
        userIcon.setAttribute("src", "/recursos/img/iconos/user_naranja.png")
        userNav.style.display = "block";
    });

    userIcon.addEventListener("mouseout", () => {
        userIcon.setAttribute("src", "/recursos/img/iconos/user.png")
        userNav.style.display = "none";
    })

    userNav.addEventListener("mouseover", () => {
        userIcon.setAttribute("src", "/recursos/img/iconos/user_naranja.png");
        userNav.style.display = "block";
    });

    userNav.addEventListener("mouseout", () => {
        userIcon.setAttribute("src", "/recursos/img/iconos/user.png")
        userNav.style.display = "none";
    })

    carritoIcon.addEventListener("mouseover", () => {
        carritoIcon.setAttribute("src", "/recursos/img/iconos/carrito-naranja.png")
    });

    carritoIcon.addEventListener("mouseout", () => {
        carritoIcon.setAttribute("src", "/recursos/img/iconos/carrito.png")
    })
}

window.addEventListener('resize', reiniciarElementos);
reiniciarElementos();


//Guardar el contador de productos del carrito
function sumarTotalCarrito() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    return carrito.reduce((total, producto) => total + parseInt(producto.cantidad), 0);
}

function guardarContador() {
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


document.addEventListener("DOMContentLoaded", () => {
    guardarContador();
});


//Cerrar sesión
let cerrarSesionCuenta = document.getElementById("cerrar-sesion");

if(cerrarSesionCuenta){
    cerrarSesionCuenta.addEventListener("click", () => {
        localStorage.clear();
        window.location.href = "/controlador/usuarios/cerrar_sesion.php"
    });
}






