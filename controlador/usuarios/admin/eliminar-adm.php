<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

//Borrar un usuario
 if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1 ){
     $usuarioControlador = new UsuarioControlador();
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $usuarioControlador->eliminarCuenta($id);
        $_SESSION["usuario_eliminado"] = true;
        header("Location: /vista/admin/usuarios-adm.php");
    }
 } else {
    header("Location: /vista/index.php");
 }
?>