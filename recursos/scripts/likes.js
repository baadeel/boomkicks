//Diseño y lógica de los likes 
corazon.forEach( e =>{

    e.addEventListener("click", function(){
        let abuelo = e.parentElement.parentElement;
        let articulos = Array.from(abuelo.children);
        let padre = e.parentElement;
        padre.remove();
        console.log(articulos.length, padre)
        if (articulos.length == 1){
            abuelo.innerHTML = "<h1 style='color: #000'>No tienes productos favoritos</h1>";
        }        
    })
})
