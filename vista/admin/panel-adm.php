<?php
session_start();
$_SESSION["primer_login"] = false;

if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true 
    && isset($_SESSION["tipo"]) && $_SESSION["tipo"] === 1 ) {
        
} else {
    header("Location: /index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/recursos/css/cabecera-cuenta.css">
    <link rel="stylesheet" href="/recursos/css/panel-adm.css">
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
        <h1>Bienvenid@, <?php echo $_SESSION["nombre"] ?>. ¿Qué desea hacer?</h1>
        <section id="funciones">
            <a href="/vista/admin/usuarios-adm.php">
                <article id="usuarios">
                    <img src="/recursos/img/iconos/usuarios.png">
                    <h3>Administrar usuarios</h3>
                </article>
            </a>
            <a href="/vista/admin/articulos-adm.php">
                <article id="articulos">
                    <img src="/recursos/img/iconos/zapatillas.png">
                    <h3>Administrar artículos</h3>
                </article>
            </a>
            <a href="/index.php">
                <article id="tienda">
                    <img src="/recursos/img/iconos/tienda.png">
                    <h3>Ir a la tienda</h3>
                </article>
            </a>
            <a href="/controlador/usuarios/cerrar_sesion.php">
                <article id="tienda">
                    <img src="/recursos/img/iconos/cerrarSesion.png">
                    <h3>Cerrar sesión</h3>
                </article>
            </a>
        </section>
    </main>
</body>
    <script src="/recursos/scripts/menu-cuenta.js"></script>
</html>