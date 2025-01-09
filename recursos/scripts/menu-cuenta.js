const menuSandwich = document.getElementById("menu-sandwich");
const menu= document.getElementById("menu");
const main = document.querySelector("main");
const cerrarMenu = document.getElementById("cerrar-menu");

//Lógica de menún en móvil
menuSandwich.addEventListener("click", () =>{
    menu.classList.toggle("visible");
    main.style.display = "none";
});

