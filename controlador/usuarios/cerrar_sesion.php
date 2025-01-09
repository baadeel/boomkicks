<?php
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

//Cerrar sesión
    session_start();
    session_unset();
    session_destroy();

    session_start();
    $_SESSION["cerrar_sesion"] = true;
    
    header("Location: /index.php");

?>