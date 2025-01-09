<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/pagina/Cabecera.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/carrito/Carrito.php";

$productoControlador = new ProductoControlador();
$cabecera = new Cabecera();
$carrito = new Carrito();


if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true) {
} else {
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="/recursos/css/buscar-producto.css">
    <link rel="stylesheet" href="/recursos/css/cabecera.css">
    <link rel="stylesheet" href="/recursos/css/body.css">
    <link rel="stylesheet" href="/recursos/css/carrito.css">
    
</head>

<body>
    <header>
        <?php
        $cabecera->generarCabecera();
        ?>
        <div id="botones">
            <?php if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true): ?>
                <a href="/vista/productos/likes.php">
                    <div id="like">
                        <img id="corazon-icon" width="41px" class="icono" src="/recursos/img/iconos/corazon.png">
                        <span id="like-contador"><?php echo $_SESSION["likes_contador"] ?></span>
                    </div>
                </a>
                <a href="/vista/carrito/carrito.php">
                    <div id="carrito">
                        <img id="carrito-icon" width="38px" class="icono" src="/recursos/img/iconos/carrito.png">
                        <span id="carrito-contador">
                            <?php if (isset($_SESSION["carrito_contador"])) {
                                echo $_SESSION["carrito_contador"];
                            } else {
                                echo "0";
                            } ?>
                        </span>
                    </div>
                </a>
                <div id="user">
                    <a href="/vista/cuenta/mi-cuenta.php">
                        <img id="user-icon" width="40px" class="icono" src="/recursos/img/iconos/user.png">
                    </a>
                    <nav style="display: none;" id="user-nav">
                        <ul>
                            <a href="/vista/admin/panel-adm.php">
                                <?php if ($_SESSION["tipo"] === 1): ?>
                                    <li>
                                        <img width="30px" src="/recursos/img/iconos/admin.png">
                                        Panel de administración
                                    </li>
                            </a>
                        <?php endif; ?>
                        <a href="/vista/cuenta/historial-compras.php">
                            <li>
                                <img width="25px" src="/recursos/img/iconos/historial.png">
                                Historial de compras
                            </li>
                        </a>
                        <a href="/vista/cuenta/direcciones.php">
                            <li>
                                <img width="27px" src="/recursos/img/iconos/direcciones.png">
                                Direcciones
                            </li>
                        </a>
                        <a href="/vista/cuenta/mi-cuenta.php">
                            <li>
                                <img width="25px" src="/recursos/img/iconos/miCuenta.png">
                                Mi cuenta
                            </li>
                        </a>
                        <li id="cerrar-sesion">
                            <img width="22px" src="/recursos/img/iconos/cerrarSesion.png">
                            Cerrar sesión
                        </li>
                        </ul>
                    </nav>

                </div>
            <?php else: ?>
                <a href="/vista/carrito/carrito.php">
                    <div id="carrito">
                        <img id="carrito-icon" width="38px" class="icono" src="/recursos/img/iconos/carrito.png">
                        <span id="carrito-contador">
                            <?php if (isset($_SESSION["carrito_contador"])) {
                                echo $_SESSION["carrito_contador"];
                            } else {
                                echo "0";
                            } ?>
                        </span>
                    </div>
                </a>
                <a href="/vista/usuario/registro.php">
                    <button id="registrarse">
                        Registrarse
                    </button>
                </a>
                <a href="/vista/usuario/iniciar_sesion.php">
                    <button id="iniciar-sesion">
                        Iniciar Sesión
                    </button>
                </a>
            <?php endif; ?>
        </div>
        <?php
        $cabecera->generarMenuHorizontal();
        ?>
    </header>
    <main>
        <div id="container">
            <div id="titulo">
                <h1>Mi carrito</h1>
            </div>

            <?php
            //Pintar el carrito (si hay)
            $carritoConProductos = false;
            if (isset($_SESSION["carrito"])){
                $carritoConProductos = $carrito->pintarCarrito($_SESSION["carrito"]);
            }
            ?>

        </div>

    <?php
        if(!$carritoConProductos){
            echo "<section id='no-carrito'>
                    <h1>No hay productos en tu carrito</h1>
                  </section>";
        }
    ?>
    </main>
    <footer>
    <p>
            Copyright © 2025
        </p>
        <p>|</p>
        <p>También puedes visitarnos en </p>
        <div>
            <a href="https://facebook.com/" target="_blank"><img with="25px" height="25px" src="/recursos/img/iconos/facebook.svg"></a>
            <a href="https://instagram.com/" target="_blank"><img with="32px" height="32px" src="/recursos/img/iconos/instagram.svg"></a>
            <a href="https://x.com/home" target="_blank"><img with="20px" height="20px" src="/recursos/img/iconos/twitter.png"></a>
        </div>
    </footer>
</body>

<script src="/recursos/scripts/menu.js"></script>
<script src="/recursos/scripts/articulo.js"></script>
<script type="module" src="/recursos/scripts/carrito.js"></script>
<script src="/recursos/scripts/buscar-producto.js"></script>

</html>