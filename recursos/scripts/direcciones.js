//Botón añadir dirección
const nueva = document.getElementById("nueva-direccion");

nueva.addEventListener("click", () => {
    location.href = "/vista/cuenta/nueva-direccion.php";
});

//Eliminar direccion
const eliminar = document.querySelectorAll(".eliminar");

eliminar.forEach(e => {
    const idDireccion = e.parentElement.getAttribute("id");
    const direccionSection = e.parentElement;

    e.addEventListener("click", () => {
        direccionSection.remove();

        let peticion = new XMLHttpRequest();
        peticion.open("POST", "/controlador/direcciones/eliminar.php", true);

        peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        peticion.send('idDireccion=' + idDireccion);

        peticion.onload = function () {
            console.log(peticion.response)
            if (peticion.status != 200) {
                console.log("Error al enviar idDireccion");
            }
        }
    });
})

//Editar dirección
const editar = document.querySelectorAll(".editar");

editar.forEach(e => {
    const idDireccion = e.parentElement.getAttribute("id");
    e.addEventListener("click", () => {
        window.location.href =`/vista/cuenta/nueva-direccion.php?id=${idDireccion}`;
    });
});
