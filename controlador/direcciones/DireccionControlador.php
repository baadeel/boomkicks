<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Direccion.php";

//Funciones respecto a las direcciones
class DireccionControlador
{
    //------------------------------------------- CAPA DE ACCESO A DATOS ---------------------------------------------------------------------
    //Añadir o actualizar una dirección
    public function añadirDireccion(Direccion $direccion)
    {
        global $mysqli;
        $id_direccion = $direccion->obtenerIdDireccion();
        $id_usuario = $direccion->obtenerIdUsuario();
        $direccionCalle = $direccion->obtenerDireccion();
        $nombre = $direccion->obtenerNombre();
        $telefono = $direccion->obtenerTelefono();


        $stmt = $mysqli->prepare("INSERT INTO direcciones (id_direccion, id_usuario, direccion, nombre, telefono)
                                    VALUES (?, ?, ?, ?, ?)
                                    ON DUPLICATE KEY UPDATE direccion = ?, nombre = ?, telefono = ?");
        $stmt->bind_param(
            "iississi",
            $id_direccion,
            $id_usuario,
            $direccionCalle,
            $nombre,
            $telefono,
            $direccionCalle,
            $nombre,
            $telefono
        );

        if($stmt->execute()){
            echo "ok";
        } else {
            echo "Error al insertar dirección";
        }
        $stmt->close();
    }

    //Obtener direcciones de un usuario
    public function obtenerDirecciones($id_usuario){
        global $mysqli;

        $direcciones = [];

        $stmt = $mysqli->prepare("SELECT id_direccion, direccion, nombre, telefono FROM direcciones
                                    WHERE id_usuario = ? AND estado = 'activo'");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($id_direccion, $direccion, $nombre, $telefono);

        while ($stmt->fetch()) {
            $valores = explode(",",$direccion);
            $direcciones[] = [
                "idDireccion" => $id_direccion,
                "calle" => $valores[0],
                "cp" => $valores[1],
                "localidad" => $valores[2],
                "provincia" => $valores[3],
                "pais" => $valores[4],
                "nombre" => $nombre,
                "telefono" => $telefono
            ];
        }

        $stmt->close();
        return $direcciones;

    }

    //Eliminar una dirección (Se cambia el estado)
    public function eliminarDireccion($id_direccion){
        global $mysqli;
        
        $stmt = $mysqli->prepare("UPDATE direcciones SET estado = 'inactivo' WHERE id_direccion = ?");
        $stmt->bind_param("i", $id_direccion);
        if($stmt->execute()){
            echo "ok";
        } else {
            echo "Error al borrar la dirección";
        }
    }

    //Obtener una dirección
    public function obtenerDireccionId($id_usuario, $id_direccion){
        global $mysqli;

        $direccionEditar = null;

        $stmt = $mysqli->prepare("SELECT direccion, nombre, telefono FROM direcciones
                                    WHERE id_usuario = ? AND id_direccion = ?");
        $stmt->bind_param("ii", $id_usuario, $id_direccion);
        $stmt->execute();
        $stmt->bind_result($direccion, $nombre, $telefono);

        while ($stmt->fetch()) {
            $valores = explode(",", $direccion);
            $direccionEditar = [
                "direccion" => $valores[0],
                "cp" => $valores[1],
                "localidad" => $valores[2],
                "provincia" => $valores[3],
                "pais" => $valores[4],
                "name" => $nombre,
                "tel" => $telefono
            ];
        }

        $stmt->close();
        return $direccionEditar;
    }

    //------------------------------------ CAPA DE PRESENTACIÓN Y CAPA LÓGICA ---------------------------------------------------------
    //Mostrar las direcciones de un usuario en el carrito
    public function pintarDireccionesCarrito($id_usuario){
        $direcciones = $this->obtenerDirecciones($id_usuario);
        if($direcciones != null){
            foreach($direcciones as $campo){
                $id_direccion = $campo["idDireccion"];
                $calle = $campo["calle"];
                $cp = $campo["cp"];
                $localidad = $campo["localidad"];
                $provincia = $campo["provincia"];
                $pais = $campo["pais"];
                $nombre = $campo["nombre"];
                $telefono = $campo["telefono"];

                echo '<article id="' . $id_direccion .'" class="direccion">
                <h3 id="nombre">'. $nombre . '</h3>
                <p id="calle">' . $calle .'</p>
                <p id="cp">' . $cp .'</p>
                <p id="provincia">' . $provincia .'</p>
                <p id="ciudad">' . $localidad .'</p>
                <p id="pais">' . $pais .'</p>
                <p id="tel">' . $telefono .'</p>
                <button class="seleccionar">Seleccionar</button></a>
                    </article>';
            }
            echo '<article id="nueva-direccion" class="direccion">
                    <h3 id="h3-nueva"><a href="/vista/cuenta/nueva-direccion.php">Añadir una nueva dirección</a></h3></h3>
                    </article>';
        } else {
            echo "<h3> No hay direcciones, debes <a href='/vista/cuenta/nueva-direccion.php'>añadir una dirección</a>  </h3>";
        }

        return ($direcciones != null);
    } 
    
    //Mostrar las direcciones de un usuario en la configuración de direcciones
    public function pintarDirecciones($id_usuario){
        $direcciones = $this->obtenerDirecciones($id_usuario);
        if($direcciones != null){
            foreach($direcciones as $campo){
                $id_direccion = $campo["idDireccion"];
                $calle = $campo["calle"];
                $cp = $campo["cp"];
                $localidad = $campo["localidad"];
                $provincia = $campo["provincia"];
                $pais = $campo["pais"];
                $nombre = $campo["nombre"];
                $telefono = $campo["telefono"];

                echo '<article id="' . $id_direccion .'" class="direccion">
                <h3 id="nombre">'. $nombre . '</h3>
                <p id="calle">' . $calle .'</p>
                <p id="cp">' . $cp .'</p>
                <p id="provincia">' . $provincia .'</p>
                <p id="ciudad">' . $localidad .'</p>
                <p id="pais">' . $pais .'</p>
                <p id="tel">' . $telefono .'</p>
                <button class="editar">Editar</button></a>
                <button class="eliminar">Eliminar</button></a>
            </article>';
            }
        } else {
            echo "<h1> No hay direcciones </h1>";
        }
    }

}
