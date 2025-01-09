<?php
    session_start();
    //------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/direcciones/DireccionControlador.php";
    
//Obtener idDirección y eliminar la dirección
    if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true){
        $direccionControlador = new DireccionControlador();
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDireccion'])){
            $id_direccion = $_POST["idDireccion"];

            $direccionControlador->eliminarDireccion($id_direccion);
        }
    }
?>