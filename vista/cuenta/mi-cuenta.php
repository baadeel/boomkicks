<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/pedidos/PedidoControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/pagina/Cabecera.php";

$pedidoControlador = new PedidoControlador();

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
    <link rel="stylesheet" href="/recursos/css/mi-cuenta.css">
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
        <div id="toast-container"></div>
        <div id="capa-superior"></div>
        <section id="cuenta-contenedor">
            <h1>Mi cuenta</h1>
            <section id="datos">
                <div id="nombre-cuenta">
                    <p>Nombre:</p>
                    <p><?php echo $_SESSION["nombre"] ?></p>
                </div>
                <div id="email-cuenta">
                    <p>Email:</p>
                    <p><?php echo $_SESSION["email"] ?></p>
                </div>
            </section>
            <section id="configuracion">
                <div>
                    <button id="actualizar">Actualizar datos</button>
                </div>
                <div>
                    <button id="cambiar-pass">Cambiar contraseña</button>
                </div>
                <div>
                    <button id="eliminar">Eliminar cuenta</button>
                </div>
            </section>
        </section>
        <section id="formulario1">
            <form method="post" action="/controlador/usuarios/actualizar_datos.php">
                <div class="campo">
                    <label for="name">Nombre completo</label><br>
                    <input type="text" id="name" name="name" value="<?php echo $_SESSION["nombre"] ?>"><br>
                    <svg viewBox="0 0 512 512" class="icon">
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                    </svg>
                    <span class="error"></span>
                </div>
                <div class="campo">
                    <label for="email">Email</label><br>
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION["email"] ?>"><br>
                    <svg viewBox="0 0 512 512" class="icon">
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                    </svg>
                    <span class="error"></span>
                </div>
                <div id="actualizar-contenedor">
                    <button id="actualizar-boton">Actualizar datos</button>
                    <span id="contadorErrores"></span>
                </div>
                <div id="cancelar-contenedor">
                    <button type="button" id="cancelar-boton">Cancelar</button>
                </div>
            </form>
        </section>
        <section id="formulario2">
            <form method="post" action="/controlador/usuarios/actualizar-pass.php">
                <div class="campo">
                    <label for="passVieja">Contraseña actual</label><br>
                    <input type="password" id="passVieja" name="passVieja"><br>
                    <svg viewBox="0 0 512 512" class="icon">
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                    </svg>
                    <span class="error"></span>
                </div>
                <div class="campo">
                    <label for="pass">Nueva contraseña</label><br>
                    <input type="password" id="pass" name="pass"><br>
                    <svg viewBox="0 0 512 512" class="icon">
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                    </svg>
                    <span class="error"></span>
                </div>
                <div class="campo">
                    <label for="pass2">Repetir nueva contraseña</label><br>
                    <input type="password" id="pass2" name="pass2"><br>
                    <svg viewBox="0 0 512 512" class="icon">
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                    </svg>
                    <span class="error"></span>
                </div>
                <div id="actualizar-pass-contenedor">
                    <button id="actualizar-pass">Actualizar contraseña</button>
                    <span id="contadorErrores2"></span>
                </div>
                <div id="cancelar-pass-contenedor">
                    <button type="button" id="cancelar-pass">Cancelar</button>
                </div>
            </form>
        </section>
        <section id="modal">
            <p>¿Estás segur@ de que deseas eliminar tu cuenta?</p>
            <div>
                <button id="si">Borrar cuenta</button>
                <button id="no">Cancelar</button>
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
<script src="/recursos/scripts/miCuenta.js"></script>
<script src="/recursos/scripts/configuracion-cuenta.js"></script>
<script src="/recursos/scripts/cambiar-pass.js"></script>
<script src="/recursos/scripts/toast.js"></script>

<script>
        //Lógica de notificaciones
    <?php if (isset($_SESSION["actualizar_datos"])): ?>
        let actualizarDatos = <?php echo json_encode($_SESSION["actualizar_datos"]); ?>;

        if (actualizarDatos) {
            toastNotificacion("Has actualizado tus datos con éxito", "var(--color-verde)", "tick.png");
            <?php $_SESSION["actualizar_datos"] = false; ?>
        }
    <?php endif; ?>
    <?php if (isset($_SESSION["actualizar_pass"])): ?>
        let actualizarPass = <?php echo json_encode($_SESSION["actualizar_pass"]); ?>;

        if (actualizarPass) {
            toastNotificacion("Has actualizado tu contraseña con éxito", "var(--color-verde)", "tick.png");
            <?php $_SESSION["actualizar_pass"] = false; ?>
        }
    <?php endif; ?>
</script>

</html>