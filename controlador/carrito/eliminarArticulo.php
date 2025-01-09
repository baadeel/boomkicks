<?php
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/carrito/Carrito.php";
    $carrito = new Carrito();
    session_start();
    //Recibir parámetros y eliminar un artículo de una talla
    if(isset($_POST["idProducto"]) && isset($_POST["talla"])){
        $carrito->borrarArticuloCarrito($_SESSION["id"], $_POST["idProducto"], $_POST["talla"]);

    }
?>