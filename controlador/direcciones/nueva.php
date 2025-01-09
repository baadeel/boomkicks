<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/direcciones/DireccionControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Direccion.php";


//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Obtener datos de un formulario y crear una dirección
if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true) {
    $direccionControlador = new DireccionControlador();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {

        $direccionCompletaString = $_POST["direccion"] . "," . $_POST["cp"] . "," . $_POST["localidad"]
            . "," . $_POST["provincia"] . "," . $_POST["pais"];

        $direccion = new Direccion($_POST["id"], $_SESSION["id"], $direccionCompletaString, $_POST["name"], $_POST["tel"]);

        $direccionControlador->añadirDireccion($direccion);
        
        if (isset($_POST["pagina-referida"]) && $_POST["pagina-referida"] == true) {
                header("Location: /vista/carrito/confirmar-compra.php");
        } else {
            header("Location: /vista/cuenta/direcciones.php");
        }
    }
} else {
    header("Location: /index.php");
}
