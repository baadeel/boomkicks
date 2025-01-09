<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Actualizar datos de mi cuenta (Cliente)
    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["email"]) && isset($_POST["name"])) {
        $usuarioControlador = new UsuarioControlador();
        $usuarioControlador->actualizarDatos($_POST["name"], $_POST["email"], $_SESSION["id"]); 
        $_SESSION["nombre"] = $_POST["name"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["actualizar_datos"] = true;
        header("Location: /vista/cuenta/mi-cuenta.php");
    } else {
        header("Location: /index.php");
    }
?>