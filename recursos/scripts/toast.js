
//Diseño de notificaciones 
function toastNotificacion(mensaje, color, icono){
    const toastContainer = document.getElementById("toast-container");
    const toast = document.createElement("div");
    const tick = document.createElement("img");
    const texto = document.createElement("p");
    tick.setAttribute("src","/recursos/img/iconos/" + icono);
    toast.className = "toast";
    toast.style.backgroundColor = color;
    toastContainer.appendChild(toast);
    texto.innerText = mensaje;


    setTimeout(() => {
        toastContainer.className = "esconder";
    }, 3000);

    toast.appendChild(tick);
    toast.appendChild(texto);
}
