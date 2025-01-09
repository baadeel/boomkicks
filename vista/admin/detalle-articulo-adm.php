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

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
} else {
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/recursos/css/cabecera-cuenta.css">
    <link rel="stylesheet" href="/recursos/css/toast.css">
    <link rel="stylesheet" href="/recursos/css/modificar-articulo-adm.css">

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
        <div id="capa-superior"></div>
        <?php 
                if (!isset($error)) {
                    $productoControlador->pintarProductoDetalleAdm($id_producto);
                } else {
                    $productoControlador->productoNoEncontrado();
                }
        ?>
        <section id="modal">
            <p>¿Estás segur@ de que deseas eliminar este producto?</p>
            <div>
                <button id="si">Borrar producto</button>
                <button id="no">Cancelar</button>
            </div>
        </section>
    </main>
</body>
<script src="/recursos/scripts/menu-cuenta.js"></script>
<script src="/recursos/scripts/toast.js"></script>
<script src="/recursos/scripts/detalle-producto.js"></script>
<script>
        //Lógica de notificaciones
    <?php if (isset($_SESSION["articulo_modificado"])): ?>

        let articuloModificado = <?php echo json_encode($_SESSION["articulo_modificado"]); ?>;

        if (articuloModificado) {
            toastNotificacion("Artículo modificado correctamente", "var(--color-verde)", "tick.png");
            <?php $_SESSION["articulo_modificado"] = false; ?>
        }
    <?php endif; ?>
</script>

</html>