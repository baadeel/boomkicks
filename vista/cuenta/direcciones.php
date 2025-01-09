<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/direcciones/DireccionControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/pagina/Cabecera.php";

$cabecera = new Cabecera();
$direccionControlador = new DireccionControlador();

if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true) {
    $likes = $_SESSION["likes"];
} else {
    header("Location: /index.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/recursos/css/body.css">
    <link rel="stylesheet" href="/recursos/css/cabecera-cuenta.css">
    <link rel="stylesheet" href="/recursos/css/direcciones.css">

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

        <a href="/index.php"><img src="/recursos/img/logo.png"></a>
        <nav>
            <ul id="menu-horizontal">
                <a href="/vista/cuenta/mi-cuenta.php">
                    <li>Mi cuenta</li>
                </a>
                <a href="/vista/cuenta/direcciones.php">
                    <li>Direcciones</li>
                </a>
                <a href="/vista/cuenta/historial-compras.php">
                    <li>Historial de compras</li>
                </a>
                <a href="/index.php">
                    <li>Volver a la tienda</li>
                </a>
        </nav>
        </ul>
    </header>
    <main>
        <section id="direcciones">
            <h1>Mis direcciones</h1>
            <button id="nueva-direccion">Añadir una nueva dirección</button>
            <div id="direcciones-container">
                <?php
                    //Pintar direcciones de usuario
                 $direccionControlador->pintarDirecciones($_SESSION["id"])  
                 ?>
            </div>
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
<script src="/recursos/scripts/menu-cuenta.js"></script>
<script src="/recursos/scripts/direcciones.js"></script>

</html>