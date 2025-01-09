<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/pagina/Cabecera.php";

$productoControlador = new ProductoControlador();
$cabecera = new Cabecera();

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
    <link rel="stylesheet" href="/recursos/css/formularios.css">
    <link rel="stylesheet" href="/recursos/css/cabecera-cuenta.css">
    

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
        <section id="formulario">
            <h1>Añadir una nueva dirección</h1>
            <form id="form" action="/controlador/direcciones/nueva.php" method="POST">
                <div class="campo">
                        <label for="name">Nombre completo</label><br>
                        <input type="text" id="name" name="name"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="direccion">Dirección (incluido número, piso, etc..):</label><br>
                        <input type="text" id="direccion" name="direccion"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="cp">Código postal: </label><br>
                        <input type="number" id="cp" name="cp"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="localidad">Localidad:</label><br>
                        <input type="text" id="localidad" name="localidad"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="provincia">Provincia:</label><br>
                        <input type="text" id="provincia" name="provincia"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="pais">País:</label><br>
                        <input type="text" id="pais" name="pais"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="tel">Teléfono:</label><br>
                        <input type="tel" id="tel" name="tel"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>

                    <input type="hidden" name="pagina-referida" id="pagina-referida">
                    <input type="hidden" name="id" id="id">
                    <div id="container-boton">
                        <button id="boton">Añadir dirección</button>
                        <span id="contadorErrores"></span>
                    </div>
                    
            </form>
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
<script src="/recursos/scripts/validarFormularioDirecciones.js"></script>

</html>