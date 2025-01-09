<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../recursos/css/formularios.css">
</head>
<body>
    <header>
        <a href="../../index.php"><img src="../../recursos/img/logo.png"></a>
    </header>
    <main>
    <?php if(isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true):?>
        <section id="formulario">
            <h1>Ya te encuentras logueado</h1>
            <p>Si deseas cerrar sesión <a href="../../controlador/usuarios/cerrar_sesion.php"> haz click aquí</a></p>
        </section>
    <?php else: ?>
        <section id="formulario">
            <h1>Iniciar sesión</h1>
            <form id="form" action="/index.php" method="post"> 
                <div class="campo">
                    <label for="email">Email</label><br>
                    <input type="email" id="email" name="email" required><br>
                    <svg viewBox="0 0 512 512" class="icon">
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                    </svg>
                    <span class="error"></span>
                </div>
                <div class="campo">
                    <label for="pass">Contraseña</label><br>
                    <input type="password" id="pass" name="pass" required><br>
                    <svg viewBox="0 0 512 512" class="icon">
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
                    </svg>
                    <span class="error"></span>
                </div>
                
                <div id="container-boton-iniciar">
                    <button type="submit" id="boton">Acceder</button>
                    <span id="cuenta-incorrecta"></span>
                </div>
            </form>
            <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </section>
    <?php endif; ?>
    </main>

</body>
<script src="../../recursos/scripts/loguearUsuario.js"></script>
</html>