<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";

//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Modificar un usuario
 if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1 ){
     $usuarioControlador = new UsuarioControlador();
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $usuario = $usuarioControlador->obtenerUsuarioPorId($id);
        
        echo json_encode($usuario);
    } else if (isset($_POST["name"])){
       
        if($usuarioControlador->actualizarUsuario($_POST["id"], $_POST["name"], $_POST["email"], $_POST["pass"], $_POST["tipo"])){
            $_SESSION["usuario_modificado"] = true;
            header("Location: /vista/admin/usuarios-adm.php");
        }
    }
 } else {
    header("Location: /vista/index.php");
 }
?>