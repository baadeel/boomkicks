//Lógica de configuración de cuenta para modificar datos o borrar cuenta
const actualizar_boton = document.getElementById("actualizar");

const cambiar_pass = document.getElementById("cambiar-pass");

const datos = document.getElementById("cuenta-contenedor");

const form1 = document.getElementById("formulario1");

const form2 = document.getElementById("formulario2");

const eliminar = document.getElementById("eliminar");

const modal = document.getElementById("modal");

const capaSuperior = document.getElementById("capa-superior");

const si = document.getElementById("si");

const no = document.getElementById("no");

actualizar_boton.addEventListener("click", () => {
    datos.style.display = "none";
    form1.style.display = "flex";
    form2.style.display = "none";
})

cambiar_pass.addEventListener("click", () => {
    datos.style.display = "none";
    form1.style.display = "none";
    form2.style.display = "flex";
})

eliminar.addEventListener("click", () => {
    modal.style.display = "block";
    capaSuperior.style.display = "block";
    no.focus();
})

no.addEventListener("click", () => {
    modal.style.display = "none";
    capaSuperior.style.display = "none";
})

si.addEventListener("click", () => {
    let peticion = new XMLHttpRequest();
    peticion.open("POST", "/controlador/usuarios/eliminar.php", true);

    peticion.onload = function () {
        if (peticion.status === 200) {
            let respuesta = peticion.responseText;
            if (respuesta == 'ok') {
                window.location.href = "/index.php";
            }
        } 
    };

    peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    peticion.send('eliminar=true');
})

