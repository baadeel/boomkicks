<?php
    session_start();
    //------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

    //Petición de verificación de email
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['passVieja'])) {
        if($_POST['passVieja'] == $_SESSION['pass']){
            echo "ok";
        } else {
            echo "error";
        }
    } else {
        header("Location: /index.php");
    }
?>