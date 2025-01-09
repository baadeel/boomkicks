<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Actualizar contraseña de mi cuenta (Usuario)
    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["pass"])) {
        $usuarioControlador = new UsuarioControlador();
        $usuarioControlador->actualizarPass($_POST["pass"], $_SESSION["id"]);
        $_SESSION["pass"] = $_POST["pass"];
        $_SESSION["actualizar_pass"] = true;
        header("Location: /vista/cuenta/mi-cuenta.php");
    } else {
        header("Location: /index.php");
    }
?>