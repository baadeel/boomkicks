<?php

//Generar una cabecera común en muchos documentos
class Cabecera{
    public function generarCabecera(){
        echo '<div id="header-top">
            <button id="menu-sandwich">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="25" viewBox="0 0 26 26">
                    <path
                        d="M 0 4 L 0 6 L 26 6 L 26 4 Z M 0 12 L 0 14 L 26 14 L 26 12 Z M 0 20 L 0 22 L 26 22 L 26 20 Z">
                    </path>
                </svg>
            </button>
            <nav id="menu-lateral" class="menu-lateral">
                <header id="menu-lateral-top">
                    <button id="cerrar-menu">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="25"
                            viewBox="0 0 50 50">
                            <path
                                d="M 9.15625 6.3125 L 6.3125 9.15625 L 22.15625 25 L 6.21875 40.96875 L 9.03125 43.78125 L 25 27.84375 L 40.9375 43.78125 L 43.78125 40.9375 L 27.84375 25 L 43.6875 9.15625 L 40.84375 6.3125 L 25 22.15625 Z">
                            </path>
                        </svg>
                        <button id="volver-atras">
                            <svg width="13px" height="20px" viewBox="0 0 13 20" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g troke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-581.000000, -3434.000000)">
                                        <g transform="translate(100.000000, 3378.000000)">
                                            <g transform="translate(476.000000, 54.000000)">
                                                <g>
                                                    <polygon id="Path" opacity="0.87" points="0 0 24 0 24 24 0 24">
                                                    </polygon>
                                                    <polygon fill="#1D1D1D"
                                                        points="17.51 3.87 15.73 2.1 5.84 12 15.74 21.9 17.51 20.13 9.38 12">
                                                    </polygon>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </button>
                        <img src="/recursos/img/logo.png" alt="Logo">
                </header>
                 <ul id="menu-lateral-principal">
                    <li><a href="/vista/usuario/iniciar_sesion.php">Iniciar sesión</a></li>
                    <li><a href="/vista/usuario/registro.php">Registrarse</a></li>
                    <li><a href="">Tienda</a></li>
                    <li id="boton-marcas"> Marcas
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="20">
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z" />
                        </svg>
                    </li>
                    <li><a href="/vista/productos/lista-productos.php?idCat=1">Sneakers</a></li>
                    <li><a href="/vista/productos/lista-productos.php?idCat=1">Baloncesto</a></li>
                    <li><a href="/vista/productos/lista-productos.php?idCat=1">Fútbol</a></li>
                    <li><a href="/vista/productos/lista-productos.php?idCat=1">Fútbol Sala</a></li>
                    <li><a href="/vista/productos/lista-productos.php?idCat=1">Running</a></li>
                    <li><a href="/vista/productos/lista-productos.php?idCat=1">Skateboarding</a></li>
                    <li><a href="/vista/productos/lista-productos.php?idCat=1">Senderismo</a></li>
                </ul>
                <ul id="menu-lateral-marcas">
                    <li><a href="">Nike</a></li>
                    <li><a href="">Adidas</a></li>
                    <li><a href="">Nike</a></li>
                    <li><a href="">Nike</a></li>
                    <li><a href="">Nike</a></li>
                    <li><a href="">Nike</a></li>
                </ul>
            </nav>
            <div id="logo">
                <a href="/index.php"><img src="/recursos/img/logo.png" alt="Logo d"></a>
            </div>
            <div id="container-buscador">
                <button id="boton-lupa">
                    <svg id="lupa" xmlns="http://www.w3.org/2000/svg" width="40" height="25" viewBox="0 0 50 50">
                        <path
                            d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                        </path>
                    </svg>
                </button>
                <input id="input-buscador" class="invisible" type="search" name="q" autocapitalize="off"
                    autocomplete="off" placeholder="Busca por marca, color, etc..." size="100">
                <div id="cerrar-buscador">
                    <svg width="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 78.667 78.67"
                        style="enable-background:new 0 0 78.667 78.67;" xml:space="preserve">
                        <g>
                            <path style="fill:#231F20;" d="M55.182,24.972c-1.219-1.218-3.191-1.217-4.408,0L39.335,36.411L27.9,24.972
                                c-1.218-1.217-3.19-1.218-4.408,0c-1.217,1.217-1.217,3.19,0,4.408l11.436,11.439L23.492,52.253c-1.217,1.218-1.217,3.19,0,4.408
                                c0.608,0.608,1.406,0.912,2.204,0.912c0.797,0,1.595-0.304,2.204-0.912l11.435-11.435l11.431,11.434
                                c0.608,0.609,1.406,0.913,2.204,0.913s1.595-0.304,2.203-0.912c1.218-1.217,1.218-3.19,0.001-4.407L43.742,40.819l11.44-11.44
                                C56.399,28.163,56.399,26.189,55.182,24.972z"></path>
                            <path style="fill:#231F20;"
                                d="M39.34,0C17.648,0,0,17.648,0,39.34C0,61.027,17.648,78.67,39.34,78.67
                                c21.685,0,39.327-17.644,39.327-39.331C78.667,17.648,61.025,0,39.34,0z M39.34,72.438c-18.255,0-33.106-14.848-33.106-33.098
                                c0-18.255,14.852-33.106,33.106-33.106c18.249,0,33.094,14.852,33.094,33.106C72.434,57.59,57.588,72.438,39.34,72.438z">
                            </path>
                        </g>
                    </svg>
                </div>
            </div>';
    }

    public function generarMenuHorizontal(){
        echo '<nav id="menu-horizontal">
            <ul id="menu-horizontal-principal">
                <li><a href="/vista/productos/lista-productos.php?idCat=1">Sneakers</a></li>
                <li><a href="/vista/productos/lista-productos.php?idCat=3">Baloncesto</a></li>
                <li><a href="/vista/productos/lista-productos.php?idCat=4">Fútbol</a></li>
                <li><a href="/vista/productos/lista-productos.php?idCat=5">Fútbol Sala</a></li>
                <li><a href="/vista/productos/lista-productos.php?idCat=2">Running</a></li>
                <li><a href="/vista/productos/lista-productos.php?idCat=6">Skateboarding</a></li>
                <li><a href="/vista/productos/lista-productos.php?idCat=7">Senderismo</a></li>
                <div id="menu-linea"></div>
            </ul>
            <ul id="menu-horizontal-marcas" hidden>
                <li><a href="">Nike</a></li>
                <li><a href="">Adidas</a></li>
                <li><a href="">Nike</a></li>
                <li><a href="">Nike</a></li>
                <li><a href="">Nike</a></li>
                <li><a href="">Nike</a></li>
                <li><a href="">Nike</a></li>
                <li><a href="">Adidas</a></li>
                <li><a href="">Nike</a></li>
                <li><a href="">Nike</a></li>
            </ul>
        </nav>';
    }
}



?>