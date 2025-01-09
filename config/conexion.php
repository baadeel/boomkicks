<?php

//Capa de acceso a datos: Conexión a la DB
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "boomkicks";

    $mysqli = new mysqli($host, $username, $password, $dbname);
    $mysqli->set_charset('utf8');
    
    if($mysqli->connect_error){
        die("No se pudo conectar") . $mysqli->connect_error;
    } 
?>