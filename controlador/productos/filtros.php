<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
session_start();

//------------------------------------------- CAPA LÓGICA Y DE PRESENTACIÓN ---------------------------------------------------------------------
if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true) {
    $likes = $_SESSION["likes"];
} else {
    $likes = [];
}

$productoControlador = new ProductoControlador();


//Recuperar los filtros seleccionado y mostrarlos
    if (isset($_GET["cat"]) && isset($_GET["marca"])) {
        $productosEncontrados = $productoControlador->buscarProductosCatMarca($_GET["cat"], $_GET["marca"]);

    } else if(isset($_GET["cat"])){
        $productosEncontrados = $productoControlador->buscarProductosCat($_GET["cat"]);

    } else if (isset($_GET["marca"])){
        $productosEncontrados = $productoControlador->buscarProductosMarca($_GET["marca"]);

    }

    if(count($productosEncontrados) > 0){
        echo $productoControlador->pintarListasProductos($productosEncontrados, $likes);
    } else {
        echo  '<h1> Lo sentimos, no se han encontrado productos con estos filtros.</h1>';
    }
    
?>


