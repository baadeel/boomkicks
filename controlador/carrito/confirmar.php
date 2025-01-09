<?php
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

session_start();

//Guardar el total de la compra o realizar el pedido
if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true){
    //La primera vez se guarda el total y redirige a elegir una dirección
    if(isset($_POST["total"])){
       $_SESSION["total_carrito"] = $_POST["total"];
       echo "confirmar";
    } else {
        //La segunda crea el pedido
        include($_SERVER['DOCUMENT_ROOT'] . '/controlador/pedidos/nuevo.php');
    }
} else {
    //Redirigir al registro
    echo "registro";
}
?>