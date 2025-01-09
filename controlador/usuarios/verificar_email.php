<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";
    //------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

    //Petición de verificación de email
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
        $usuarioControlador = new UsuarioControlador();
        $usuarioControlador->verificarEmailExistente();  
    } else {
        header("Location: /index.php");
    }

?>