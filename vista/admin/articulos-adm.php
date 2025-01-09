<?php
session_start();

if (
    isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true
    && isset($_SESSION["tipo"]) && $_SESSION["tipo"] === 1
) {
} else {
    header("Location: /index.php");
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
$productoControlador = new ProductoControlador();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/recursos/css/cabecera-cuenta.css">
    <link rel="stylesheet" href="/recursos/css/articulos-adm.css">
    <link rel="stylesheet" href="/recursos/css/toast.css">

</head>

<body>
    <header>
        <button id="menu-sandwich">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="25" viewBox="0 0 26 26">
                <path
                    d="M 0 4 L 0 6 L 26 6 L 26 4 Z M 0 12 L 0 14 L 26 14 L 26 12 Z M 0 20 L 0 22 L 26 22 L 26 20 Z">
                </path>
            </svg>

        </button>

        <a href="/vista/admin/panel-adm.php"><img id="logo-adm" src="/recursos/img/logo-adm.png"></a>
        <nav>
            <ul id="menu-horizontal">
                <a href="/vista/admin/usuarios-adm.php">
                    <li>Usuarios</li>
                </a>
                <a href="/vista/admin/articulos-adm.php">
                    <li>Artículos</li>
                </a>
                <a href="/index.php">
                    <li>Ir a la tienda</li>
                </a>
        </nav>
        </ul>
    </header>
    <main>
        <div id="toast-container"></div>
        <section id="articulos">
            <h1>Administración de artículos</h1>
            <div id="filtros-buscador">

            </div>
            <a id="link-articulo" href="/vista/admin/nuevo-articulo-adm.php">
                <div id="crear-articulo">
                    <img src="/recursos/img/iconos/add.png">
                    <p>Añadir nuev@ artículo</p>
                </div>
            </a>
            <div id="contenedor-tabla">
                <table id="tabla">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Color</th>
                            <th scope="col">Precio</th>
                            <th scope="col">N° Ventas</th>
                            <th scope="col">Fecha de subida</th>
                            <th scope="col">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    //Pintar los productos
                        $productos = $productoControlador->obtenerProductoTodosTablaAdm();
                        $productoControlador->pintarProductosTabla($productos);
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
<script src="/recursos/scripts/menu-cuenta.js"></script>
<script src="/recursos/scripts/toast.js"></script>
<script>
    //Lógica de notificaciones
    <?php if (isset($_SESSION["nuevo_articulo"])): ?>

        let nuevoArticulo = <?php echo json_encode($_SESSION["nuevo_articulo"]); ?>;

        if (nuevoArticulo) {
            toastNotificacion("Nuevo artículo subido correctamente", "var(--color-verde)", "tick.png");
            <?php $_SESSION["nuevo_articulo"] = false; ?>
        }
    <?php endif; ?>
    <?php if (isset($_SESSION["articulo_eliminado"])): ?>

        let articuloEliminado = <?php echo json_encode($_SESSION["articulo_eliminado"]); ?>;

        if (articuloEliminado) {
            toastNotificacion("Artículo eliminado correctamente", "var(--color-verde)", "tick.png");
            <?php $_SESSION["articulo_eliminado"] = false; ?>
        }
    <?php endif; ?>
</script>

</html>