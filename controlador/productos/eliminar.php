<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";

//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Eliminar un artículo
if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) {
    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["eliminar"]) && isset($_POST["idProducto"])) {
        $productoControlador = new ProductoControlador();
        $productoControlador->eliminarProducto($_POST["idProducto"]);
        
        $_SESSION["articulo_eliminado"] = true;
     }
}