<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Usuarios.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/conexion.php";

//Lógica Usuario DB
class UsuarioControlador
{
    //------------------------------------------- CAPA LÓGICA Y PRESENTACIÓN---------------------------------------------------------------------

    //Nuevo usuario
    public function registrar($nombre, $email, $pass)
    {

        $usuario = new Usuario($nombre, $email, $pass);
        if ($usuario->guardar()) {
            echo "<h1>Te has registrado correctamente</h1> 
                    <p> Vas a ser redirigido a la página principal en 5 segundos... Si no ocurre, 
                    haz click <a href='/index.php'>aquí<a/></p>";
            return true;
        } else {
            echo "Hubo un error al registrar el usuario.";
            return false;
        }
    }

    //------------------------------------------- CAPA DE ACCESO A DATOS ---------------------------------------------------------------------

    //Comprobar si el email está registrado
    public function verificarEmailExistente()
    {
        global $mysqli;

        $email = $_POST["email"];

        $stmt = $mysqli->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "existe";
        } else {
            echo "disponible";
        }

        $stmt->close();
        $mysqli->close();
    }

    //Login
    public function loguearUsuario()
    {
        global $mysqli;

        $email = $_POST["email"];
        $pass = $_POST["pass"];

        $stmt = $mysqli->prepare("SELECT id_usuario, nombre, tipo FROM usuarios WHERE email = ? AND pass = ?");
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $nombre, $tipo);

        $filas = [];

        while ($stmt->fetch()) {
            $filas = [
                "id" => $id,
                "nombre" => $nombre,
                "email" => $email,
                "pass" => $pass,
                "tipo" => $tipo
            ];
        }

        if ($stmt->num_rows > 0) {
            echo "correcto";
            return $filas;
        } else {
            echo "incorrecto";
            return false;
        }

        $stmt->close();
        $mysqli->close();
    }

    //Lista: Likes del usuario
    public function listadoLikes($id)
    {
        global $mysqli;
        $likes = [];

        if ($stmt = $mysqli->prepare("SELECT * FROM likes WHERE id_usuario = $id")) {
            $stmt->execute();

            $stmt->bind_result($id_producto, $id_usuario);

            while ($stmt->fetch()) {
                $likes[] = $id_producto;
            }

            $stmt->close();
            return $likes;
        }
        $mysqli->close();
    }

    //Dar like
    public function darLike()
    {
        global $mysqli;

        $id_usuario = $_SESSION["id"];
        $id_producto = $_POST["id"];

        $stmt = $mysqli->prepare("INSERT INTO likes (id_producto, id_usuario) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_producto, $id_usuario);

        if ($stmt->execute()) {
            echo "ok";
        } else {
            echo "Error al dar like";
        }


        $stmt->close();
    }

    //Quitar like
    public function quitarLike()
    {
        global $mysqli;

        $id_usuario = $_SESSION["id"];
        $id_producto = $_POST["id"];

        $stmt = $mysqli->prepare("DELETE FROM likes WHERE id_producto = ? AND id_usuario = ?");
        $stmt->bind_param("ii", $id_producto, $id_usuario);

        if ($stmt->execute()) {
            echo "borrar";
        } else {
            echo "Error al quitar like";
        }
    }

    //Buscar un email
    public function verificarEmailExistenteCuenta($id_usuario)
    {
        global $mysqli;

        $email = $_POST["email"];

        $stmt = $mysqli->prepare("SELECT id_usuario FROM usuarios WHERE email = ? AND id_usuario != ?");
        $stmt->bind_param("si", $email, $id_usuario);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "existe";
        } else {
            echo "disponible";
        }

        $stmt->close();
        $mysqli->close();
    }

    //Modificar datos de una cuenta
    public function actualizarDatos($nombre, $email, $id_usuario)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE usuarios SET nombre= ?, email= ? WHERE id_usuario = ?");
        $stmt->bind_param("ssi", $nombre, $email, $id_usuario);

        if ($stmt->execute()) {
        } else {
            echo "Error al actualizar";
        }

        $stmt->close();
    }

    //Modificar contraseña de una cuenta
    public function actualizarPass($pass, $id_usuario)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE usuarios SET pass= ? WHERE id_usuario = ?");
        $stmt->bind_param("si", $pass, $id_usuario);

        if ($stmt->execute()) {
        } else {
            echo "Error al actualizar";
        }

        $stmt->close();
    }

    //Eliminar cuenta
    public function eliminarCuenta($id_usuario)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id_usuario = ?;");
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
        } else {
            echo "Error al borrar";
        }

        $stmt->close();
    }

    //Obtener lista de todos los usuarios
    public function obtenerUsuariosTodos()
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $nombre, $email, $pass, $tipo);
        $usuarios = [];

        while ($stmt->fetch()) {
            if ($tipo == 0) {
                $tipo = "Usuario";
            } else if ($tipo == 1) {
                $tipo = "Administrador";
            }

            $usuarios[] = [
                "id" => $id,
                "nombre" => $nombre,
                "email" => $email,
                "pass" => $pass,
                "tipo" => $tipo
            ];
        }

        $stmt->close();
        return $usuarios;
    }

    //Capa de presentación: mostrar usuarios en forma tabla
    public function pintarUsuariosTabla($usuarios)
    {
        foreach ($usuarios as $user) {
            echo '<tr>
                    <td>' . $user["id"] .'</td>
                    <td>' . $user["nombre"] .'</td>
                    <td>' . $user["email"] .'</td>
                    <td>' . $user["pass"] .'</td>
                    <td>' . $user["tipo"] .'</td>
                    <td><a href="/vista/usuario/registro.php?id=' . $user["id"] .'"><button>Modificar</button></a></td>

                    <td><a href="/controlador/usuarios/admin/eliminar-adm.php?id=' . $user["id"] .'"><button>Eliminar</button></a></td>
                  </tr>';
        }
    }
    //Obtener usuario por id
    public function obtenerUsuarioPorId($id)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt->store_result();
        $stmt->bind_result($id, $nombre, $email, $pass, $tipo);

        if ($stmt->fetch()) {
            $usuario = [
                "nombre" => $nombre,
                "email" => $email,
                "pass" => $pass,
                "tipo" => $tipo
            ];
        }

        $stmt->close();
        return $usuario;
    }

        //Actualitar datos de una cuenta (admin)
    public function actualizarUsuario($id, $nombre, $email, $pass, $tipo){
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE usuarios SET nombre = ?, email = ?, pass = ?, tipo = ?
                                    WHERE id_usuario = ?");
        $stmt->bind_param("sssii", $nombre, $email, $pass, $tipo, $id);
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
}
