<?php
    session_start();
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

//Recibir parámetro y guardar el contador de artículos en el carrito
    if(isset($_POST["cantidad"])){
        $_SESSION["carrito_contador"] = $_POST["cantidad"];
    }
?>