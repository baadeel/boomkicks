<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Usuarios.php";
 
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Registrar un usuario
 if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1 ){
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $nombre = $_POST["name"];
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $tipo = $_POST["tipo"];
        $usuario = new Usuario($nombre, $email, $pass, $tipo);

        if($usuario->guardar()){
            $_SESSION["nuevo_registro"] = true;
            header("Location: /vista/admin/usuarios-adm.php");
        }

    }
 } else {
    header("Location: /vista/index.php");
 }
?>