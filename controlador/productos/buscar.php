<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
session_start();

//------------------------------------------- CAPA DE PRESENTACIÓN Y CAPA LÓGICA ---------------------------------------------------------------------

if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true) {
    $likes = $_SESSION["likes"];
} else {
    $likes = [];
}

$productoControlador = new ProductoControlador();
//Buscar y mostrar los productos resultados de una query (buscador)
if (isset($_GET["query"])) {
    $query = $_GET["query"];

        $productosEncontrados = $productoControlador->buscarProducto($query);
        
        if(count($productosEncontrados) > 0){
            echo ' <section id="busqueda">
                            <article class="slider">';
            $productoControlador->pintarListasProductos($productosEncontrados, $likes);
            echo   '   </article>
                        </section>';
        } else {
            echo ' <section id="busqueda">
                    <article class="no-productos">
                        <h1> Lo sentimos, no se han encontrado productos que coincidan con tu búsqueda. </h1>
                    </article>
                </section>';
        }
}
