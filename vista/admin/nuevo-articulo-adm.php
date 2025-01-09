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
    <link rel="stylesheet" href="/recursos/css/nuevo-articulo-adm.css">
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
        <section id="formulario-articulo">
            <h1>Añadir nuevo artículo</h1>
            <form id="form" action="/controlador/productos/nuevo-articulo-adm.php" method="post" enctype="multipart/form-data">
                <fieldset id="fieldset-informacion">
                    <legend>Información</legend>
                    <div class="campo">
                        <label for="name">Nombre:</label><br>
                        <input type="text" id="name" name="name"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="marca">Marca:</label><br>
                        <select name="marca" id="marca">
                            <?php $productoControlador->pintarMarcasFormulario() ?>
                        </select><br>
                       <input type="text" id="nueva-marca" name="nueva-marca" placeholder="Nombre de la nueva marca">
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="categoria">Categoría:</label><br>
                        <select name="categoria" id="categoria">
                        <?php $productoControlador->pintarCategoriasFormulario() ?>
                        </select>
                        <br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="color">Color:</label><br>
                        <input type="text" id="color" name="color"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo">
                        <label for="precio">Precio:</label><br>
                        <input type="number" id="precio" name="precio" step="0.01"><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                    <div class="campo desc">
                        <label for="descripcion">Descripción:</label><br>
                        <textarea id="descripcion" name="descripcion" cols="40" rows="17" resize>Estos zapatos no necesitan presentación. ¡Simplemente irresistibles!</textarea><br>
                        <svg viewBox="0 0 512 512" class="icon">
                            <path
                                d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                        </svg>
                        <span class="error"></span>
                    </div>
                </fieldset>
                <fieldset id="fieldset-imagen">
                    <legend>Imagen</legend>
                    <div class="campo">
                        <label for="imagen">Imagen:</label>
                        <input type="file" id="imagen" name="imagen" accept="image/*" ><br>
                        <svg viewBox="0 0 512 512" class="icon">
                                <path
                                    d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                            </svg>
                            <span class="error"></span>
                    </div>
                    
                    <img id="preview-imagen" src="" alt="Vista previa">

                </fieldset>
                <fieldset id="fieldset-tallas">
                    <legend>Tallas</legend>
                    <div class="campo">
                        <div id="contenedor-tallas">

                        </div>
                        <button type="button" id="add-talla">Añadir Talla</button>
                    </div>
                </fieldset>
                <input type="hidden" name="id" id="id">
                <div id="container-boton">
                    <button id="boton">Añadir artículo</button>
                    <span id="contadorErrores"></span>
                </div>
            </form>
        </section>
    </main>
</body>
<script src="/recursos/scripts/menu-cuenta.js"></script>
<script src="/recursos/scripts/validarFormularioNuevoArticulo.js"></script>


</html>