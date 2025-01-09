<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/pagina/Cabecera.php";

$productoControlador = new ProductoControlador();
$cabecera = new Cabecera();

if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true):
    $likes = $_SESSION["likes"];
?>
    <script>
        let carrito = <?php echo json_encode($_SESSION["carrito"]); ?>;
        localStorage.setItem("carrito", JSON.stringify(carrito));
    </script>
<?php else :
    $likes = [];
endif;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/recursos/css/buscar-producto.css">
    <link rel="stylesheet" href="/recursos/css/cabecera.css">
    <link rel="stylesheet" href="/recursos/css/index.css">
    <link rel="stylesheet" href="/recursos/css/toast.css">
    <link rel="stylesheet" href="/recursos/css/articulos.css">
    <link rel="stylesheet" href="/recursos/css/body.css">


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
        <div id="toast-container"></div>
        <section id="novedades">
            <h1>Novedades ✨</h1>
            <article class="slider">
                <?php
                $listaNuevos = $productoControlador->obtenerNuevosProductos();
                $productoControlador->pintarListasProductos($listaNuevos, $likes);
                ?>
                <img class="derecha" src="/recursos/img/iconos/derecha.png" width="35px" height="35px">
                <img class="izquierda" src="/recursos/img/iconos/izquierda.png" width="30px" height="35px">
            </article>
        </section>
        <section id="categorias">
            <h1>Marcas populares 🔖</h1>
            <section id="categorias-grid">
                <a href="/vista/productos/lista-productos.php?idMarca=1">
                    <article class="cat">
                        <img src="/recursos/img/marcas/nike.svg">
                    </article>
                </a>
                <a href="/vista/productos/lista-productos.php?idMarca=2">
                    <article class="cat">
                        <img src="/recursos/img/marcas/adidas.svg">
                    </article>
                </a>
                <a href="/vista/productos/lista-productos.php?idMarca=6">
                    <article class="cat">
                        <img src="/recursos/img/marcas/asics.svg">
                    </article>
                </a>
                <a href="/vista/productos/lista-productos.php?idMarca=3">
                    <article class="cat">
                        <img src="/recursos/img/marcas/jordan.svg">
                    </article>
                </a>
            </section>
        </section>
        <section id="top-ventas">
            <h1>Top ventas 🏆</h1>
            <article class="slider">
                <?php
                $listaTop = $productoControlador->obtenerTopProductos();
                $productoControlador->pintarListasProductos($listaTop, $likes);
                ?>
                <img class="derecha" src="/recursos/img/iconos/derecha.png" width="35px" height="35px">
                <img class="izquierda" src="/recursos/img/iconos/izquierda.png" width="30px" height="35px">
            </article>
        </section>

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
<script src="/recursos/scripts/toast.js"></script>
<script src="/recursos/scripts/buscar-producto.js"></script>

<script>
    <?php if (isset($_SESSION["primer_login"])): ?>
        let login = <?php echo json_encode($_SESSION["primer_login"]); ?>;

        if (login) {
            toastNotificacion("Te has logueado con éxito", "var(--color-verde)", "tick.png");
            <?php $_SESSION["primer_login"] = false; ?>
        }
    <?php endif; ?>
    <?php if (isset($_SESSION["cerrar_sesion"])): ?>

        let cerrarSesionToast = <?php echo json_encode($_SESSION["cerrar_sesion"]); ?>;

        if (cerrarSesionToast) {
            toastNotificacion("Has cerrado sesión", "var(--color-rojo)", "x.png");
            <?php session_unset();
            session_destroy(); ?>
        }
    <?php endif; ?>
    <?php if (isset($_SESSION["eliminar_cuenta"])): ?>

        let eliminarCuentaToast = <?php echo json_encode($_SESSION["eliminar_cuenta"]); ?>;

        if (eliminarCuentaToast) {
            toastNotificacion("Has eliminado tu cuenta", "var(--color-rojo)", "x.png");
            <?php session_unset();
            session_destroy(); ?>
        }
    <?php endif; ?>
</script>

</html>