<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/direcciones/DireccionControlador.php";

    session_start();

//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Obtener el idDirección y editar la dirección
if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true) {
    $direccionControlador = new DireccionControlador();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idDireccion'])) {

        $direccionEditar = $direccionControlador->obtenerDireccionId($_SESSION["id"], $_GET["idDireccion"]);
        if($direccionEditar){
            echo json_encode($direccionEditar);
        } else {
            echo null;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDireccion'])){
        
        $direccionCompletaString = $_POST["direccion"] . "," . $_POST["cp"] . "," . $_POST["localidad"]
            . "," . $_POST["provincia"] . "," . $_POST["pais"];
        $direccion = new Direccion($_POST["idDireccion"], $_SESSION["id"], $direccionCompletaString, $_POST["name"], $_POST["tel"]);

        
    }
} else {
    header("Location: /index.php");
}
    ?>
