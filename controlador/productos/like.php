<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";
    $usuarioControlador = new UsuarioControlador();
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

    //Redirigir registro
    if (!isset($_SESSION["usuario_logueado"])){
        echo "registrar";
    }
    
    //Petición dar like (Usuario registrado)
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $idProducto = $_POST["id"];

        //Dar o quitar like
        if (in_array($idProducto, $_SESSION["likes"])){
            $usuarioControlador->quitarLike();
            $likes = $usuarioControlador->listadoLikes($_SESSION["id"]);
            $contadorLike = count($likes);
            $_SESSION["likes"] = $likes;
            $_SESSION["likes_contador"] = $contadorLike;

        } else {
            //Registrar like, actualizar sesión
            $usuarioControlador->darLike();
            $likes = $usuarioControlador->listadoLikes($_SESSION["id"]);
            $contadorLike = count($likes);
            $_SESSION["likes"] = $likes;
            $_SESSION["likes_contador"] = $contadorLike;
        }
    }

?>
