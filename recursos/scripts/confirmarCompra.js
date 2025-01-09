const seleccionar = document.querySelectorAll(".seleccionar");
const nuevaDireccion = document.getElementById("nueva-direccion");
let seleccionado = false;
const confirmar = document.getElementById("confirmar");
let idDireccion = null;

//Diseño de seleccionar una dirección

seleccionar.forEach(e => {
    e.addEventListener("click", () =>{
        const direccion = e.parentElement;
        idDireccion= direccion.getAttribute("id");
       direccion.classList.toggle("seleccionado");
        if(direccion.classList.contains("seleccionado")){
            e.innerHTML = "Elegir otra";
            seleccionado = true;
            seleccionar.forEach(e => {
                if(!e.parentElement.classList.contains("seleccionado")){
                    e.parentElement.style.display = "none";
                    nuevaDireccion.style.display = "none";
                }
            })
        } else {
            e.innerHTML = "Seleccionar";
            seleccionado = false;
            seleccionar.forEach(e => {
                    e.parentElement.removeAttribute("style");
                    nuevaDireccion.removeAttribute("style");
                
            })
        }
        
        if(seleccionado){
            confirmar.removeAttribute("disabled");
            confirmar.style.cursor = "pointer";
        } else {
            confirmar.setAttribute("disabled", true);
            confirmar.style.cursor = "not-allowed";
        }
    })
});

//Lógica de confirmar una compra
confirmar.addEventListener("click", () =>{

    let peticion = new XMLHttpRequest();
    peticion.open("POST", "/controlador/carrito/confirmar.php", true);
    
    peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    peticion.send('idDireccion=' + idDireccion);

    peticion.onload = function () {
        console.log(peticion.response);
        if (peticion.status == 200) {
            if(peticion.response == "index"){
                location.href = "/index.php";
            } else if (peticion.response.trim() == "ok"){
                localStorage.setItem("carrito", null);
                location.href = "/vista/carrito/compra-realizada.php";
            }
        }
    }

    localStorage.setItem("carrito", null);
});