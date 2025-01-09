const tallas = document.querySelectorAll(".talla");
const boton = document.getElementById("confirmar");
const contadorDiv = document.getElementById("contador");
const contadorBotones = document.querySelectorAll("#contador button");
const cantidad = document.getElementById("cantidad");
const info = document.getElementById("info");

//Logicas de las tallas permitidas de seleccionar en la pantalla del producto
tallas.forEach(e => {

    e.addEventListener("click", () =>{
        let flag = false;
        cantidad.textContent = 1;
        if(e.classList.contains("seleccionado")){
            flag = true;
        } 

        tallas.forEach(e => {
            e.classList.remove("seleccionado");
        });
        
        if(!flag){
            e.classList.add("seleccionado");
            boton.removeAttribute("disabled");
            contadorDiv.style.border = "#000 2px solid";
            contadorBotones[1].style.cursor = "pointer";
            contadorBotones[1].removeAttribute("disabled");
            cantidad.style.color = "black";

            let tallaSeleccionada = document.querySelector(".seleccionado");
            let maxCantidad = tallaSeleccionada.getAttribute("class").split(" ")[1];
            if(maxCantidad == 1){
                contadorBotones.forEach(e => {
                    e.setAttribute("disabled", "true");
                    e.style.cursor = "not-allowed";
                })
                info.textContent = "Solo hay " + maxCantidad + " unidad de esta talla";
            } else {
                info.textContent = "Quedan " + maxCantidad + " unidades de esta talla";
            }
        } else {
            info.textContent = "";
            boton.setAttribute("disabled", "true");
            contadorDiv.removeAttribute("style");
            contadorBotones.forEach(e => {
                e.removeAttribute("style");
                e.setAttribute("disabled", "true");
            })
            cantidad.style.color = "#bebebe";
        }
    });
});

boton.addEventListener("mouseover", () => {
    if(!boton.hasAttribute("disabled")){
        boton.setAttribute("style","cursor: pointer; background-color: #e7ad00; color: white;");
    } else {
        boton.setAttribute("style","cursor: not-allowed;")
    }
})

boton.addEventListener("mouseout", () => {
    boton.removeAttribute("style");
})

//Diseño al sumar
function sumar(){
    let tallaSeleccionada = document.querySelector(".seleccionado");
    let maxCantidad = tallaSeleccionada.getAttribute("class").split(" ")[1];
    let numero = parseInt(cantidad.textContent) + 1;

     if (numero > 1){
        contadorBotones[0].removeAttribute("disabled");
        contadorBotones[0].style.cursor = "pointer";
    }
    if(numero == maxCantidad){
        contadorBotones[1].setAttribute("disabled", "true");
        contadorBotones[1].style.cursor = "not-allowed";
    }

    if (numero <= maxCantidad){
        cantidad.textContent = numero;
    }
}

//Diseño al restar
function restar(){
    let tallaSeleccionada = document.querySelector(".seleccionado");
    let maxCantidad = tallaSeleccionada.getAttribute("class").split(" ")[1];

    numero = parseInt(cantidad.textContent) - 1;
    if(numero === 1){
        contadorBotones[0].setAttribute("disabled", "true");
        contadorBotones[0].style.cursor = "not-allowed";
    } else if (numero > 1){
        contadorBotones[0].removeAttribute("disabled");
    }

    if(numero < maxCantidad){
        contadorBotones[1].removeAttribute("disabled");
        contadorBotones[1].style.cursor = "pointer";
    }

    if(numero >= 1){
        cantidad.textContent = numero;
    }
}