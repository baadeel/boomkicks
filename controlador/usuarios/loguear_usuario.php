
<?php
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/carrito/Carrito.php";
    
    //Petición loguear usuario
    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["email"]) && isset($_POST["pass"])) {
        $usuarioControlador = new UsuarioControlador();
        $carrito = new Carrito();
        $infoCuenta = $usuarioControlador->loguearUsuario();
        
        if ($infoCuenta) {  
            
            //Valores SESSION
            $_SESSION["usuario_logueado"] = true;
            $_SESSION["id"] = $infoCuenta["id"];
            $_SESSION["nombre"] = $infoCuenta["nombre"];
            $_SESSION["email"] = $infoCuenta["email"];
            $_SESSION["pass"] = $infoCuenta["pass"];
            $_SESSION["primer_login"] = true;
            $_SESSION["tipo"] = $infoCuenta["tipo"];
            echo $_SESSION["tipo"];
            $likes = $usuarioControlador->listadoLikes($infoCuenta["id"]);
            $contadorLike = count($likes);
            $_SESSION["likes"] = $likes;
            $_SESSION["likes_contador"] = $contadorLike;

            if(!isset($_SESSION["carrito"])){
                $_SESSION["carrito"] = $carrito->recuperarCarrito($_SESSION["id"]);
                $_SESSION["carrito_contador"] = $carrito->sumarContadorCarrito($_SESSION["carrito"]);
            } else {
                $carrito->borrarCarrito($_SESSION["id"]);
            }
        }
        
    } else {
        header("Location: /index.php");
    }

?>


