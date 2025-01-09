<?php
 session_start();
 require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Eliminar mi cuenta (Usuario)
 if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["eliminar"])) {
    $usuarioControlador = new UsuarioControlador();
    $usuarioControlador->eliminarCuenta($_SESSION["id"]);
    session_unset();
    session_destroy();
    session_start();
    $_SESSION["eliminar_cuenta"] = true;
    echo "ok";
 }
?>