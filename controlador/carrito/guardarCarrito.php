<?php
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/carrito/Carrito.php";
$carrito = new Carrito();
session_start();

//Recibir el array del carrito y guardarlo
$carritoPeticion = file_get_contents("php://input");


$carritoArray = json_decode($carritoPeticion, true);

if (json_last_error() === JSON_ERROR_NONE) {
    $_SESSION["carrito"] = $carritoArray;

    if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true){
        $carrito->guardarCarrito($_SESSION["carrito"], $_SESSION["id"]);
    }
} else {
    $_SESSION["carrito"] = NULL;
}


?>