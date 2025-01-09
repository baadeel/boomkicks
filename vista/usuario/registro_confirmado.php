<?php
    session_start();
    header("Refresh: 5; url=../../index.php");
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
        <section id="formulario">
            <?php
            //Lógica de registro de usuario
            require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/usuarios/UsuarioControlador.php";

            $nombre = $_POST["name"];
            $email = $_POST["email"];
            $pass = $_POST["pass"];
        
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $usuarioControlador = new UsuarioControlador();
                if($usuarioControlador->registrar($nombre, $email, $pass)){
                    $_SESSION["email"] = $email;
                    $_SESSION["pass"] = $pass;
                }
            }

            ?>
            <a href="registro.php"></a>
        </section>
    </main>
</body>
<script>
        //Petición para loguear al usuario
         let peticion = new XMLHttpRequest();
         peticion.open("POST", "/controlador/usuarios/loguear_usuario.php", true);
         
         peticion.onload = function() {
             if (peticion.status !== 200) {
                console.log("Error al enviar datos")
             }
         };
         
         peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         peticion.send('email=<?php echo $_SESSION["email"] ?>&pass=<?php echo $_SESSION["pass"]?>' );
</script>
</html>