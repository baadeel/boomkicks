<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/config/conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Pedido.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/direcciones/DireccionControlador.php";

class PedidoControlador
{
    //------------------------------------------- CAPA DE ACCESO A DATOS ---------------------------------------------------------------------
    //Añadir un pedido
    public function añadirPedido(Pedido $pedido, $carrito)
    {
        global $mysqli;

        $id_pedido = $pedido->obtenerIdPedido();
        $id_usuario = $pedido->obtenerIdUsuario();
        $estado = $pedido->obtenerEstado();
        $total = $pedido->obtenerTotal();
        $fecha = $pedido->obtenerFecha();
        $num_pedido = mt_rand(1000000, 9999999);
        $id_direccion = $pedido->obtenerIdDireccion();

        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM pedidos WHERE num_pedido = ?");
        $stmt->bind_param("i", $num_pedido);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count > 0) {
            $stmt->close();
            $this->añadirPedido($pedido, $carrito);
        } else {
            $stmt->close();

            $stmt = $mysqli->prepare("INSERT INTO pedidos (id_pedido, id_usuario, total, num_pedido, id_direccion)
                                        VALUES (?, ?, ?, ?, ?)
                                        ON DUPLICATE KEY UPDATE id_pedido = ?");
            $stmt->bind_param(
                "iidiii",
                $id_pedido,
                $id_usuario,
                $total,
                $num_pedido,
                $id_direccion,
                $id_pedido,
            );

            if ($stmt->execute()) {
                echo "ok";
            } else {
                echo "Error al insertar pedido";
            }

            $stmt->close();

            $this->añadirDetallePedido($carrito, $num_pedido);
        }
    }

    //Añadir los dettales de un pedido
    public function añadirDetallePedido($carrito, $num_pedido)
    {

        global $mysqli;
        $productoControlador = new ProductoControlador();
        $id_pedido = $this->buscarIdPedido($num_pedido);

        foreach ($carrito as $producto) {
            $id_producto = $producto["idProducto"];
            $talla = $producto["tallaSeleccionada"];
            $cantidad = $producto["cantidad"];
            $cantidadTotal = $producto["cantidadTotal"];
            $producto = $productoControlador->obtenerProducto($id_producto);
            $precio = $producto->obtenerPrecio();
            $total = $precio * $cantidad;


            $stmt = $mysqli->prepare("INSERT INTO detalle_pedidos (id_pedido, id_producto, total, talla, cantidad)
                                      VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "iidii",
                $id_pedido,
                $id_producto,
                $total,
                $talla,
                $cantidad
            );

            if ($stmt->execute()) {
            } else {
                echo "Error al insertar detalle pedido";
            }
            $stmt->close();

            $tallas = $productoControlador->obtenerListadoTallas();
            $id_talla = array_search($talla, $tallas);


            $stmt = $mysqli->prepare("UPDATE producto_talla SET cantidad = ? WHERE id_producto = ? AND id_talla = ? ");

            $stmt->bind_param(
                "iii",
                $cantidadTotal,
                $id_producto,
                $id_talla
            );

            if ($stmt->execute()) {
            } else {
                echo "Error al restar stock";
            }
            $stmt->close();



            $stmt = $mysqli->prepare("UPDATE productos SET vendidos = productos.vendidos + ? WHERE id_producto = ?");

            $stmt->bind_param(
                "ii",
                $cantidad,
                $id_producto
            );

            if ($stmt->execute()) {
            } else {
                echo "Error al restar stock";
            }
            $stmt->close();
        }
    }

    //Buscar el id de un pedido
    public function buscarIdPedido($num_pedido)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT id_pedido FROM pedidos WHERE num_pedido = ?");
        $stmt->bind_param("i", $num_pedido);
        $stmt->execute();
        $stmt->bind_result($id_pedido);

        if ($stmt->fetch()) {
            return $id_pedido;
        }
    }

    //Obtener todos los pedido de un usuario
    public function obtenerPedidos($id_usuario)
    {
        global $mysqli;
        $pedidos = [];

        $stmt = $mysqli->prepare("SELECT id_pedido, estado, total, fecha, num_pedido, id_direccion FROM pedidos 
                                WHERE id_usuario = ?
                                ORDER BY fecha DESC;");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($id_pedido, $estado, $total, $fecha, $num_pedido, $id_direccion);

        while ($stmt->fetch()) {
            $pedido = new Pedido($id_pedido, $id_usuario, $estado, $total, $fecha, $num_pedido, $id_direccion);
            $pedidos[] = $pedido;
        }

        return $pedidos;
    }


    //Capa de presentación, lógica y acceso a datos: Obtener y mostrar los pedidos en el historias de pedidos
    public function pintarPedidos($id_usuario)
    {
        global $mysqli;
        $pedidos = $this->obtenerPedidos($id_usuario);
        $productoControlador = new ProductoControlador();
        $direccionControlador = new DireccionControlador();

        foreach ($pedidos as $pedido) {
            $detallesPedidos = [];
            $id_pedido = $pedido->obtenerIdPedido();
            $stmt = $mysqli->prepare("SELECT id_producto, total, talla, cantidad FROM detalle_pedidos 
                                        WHERE id_pedido = ?");
            $stmt->bind_param("i", $id_pedido);
            $stmt->execute();
            $stmt->bind_result($id_producto, $total, $talla, $cantidad);

            while ($stmt->fetch()) {
                $detallesPedidos[$id_pedido][] = [
                    "idProducto" => strval($id_producto),
                    "total" => strval($total),
                    "talla" => strval($talla),
                    "cantidad" => strval($cantidad)
                ];
            }

            $stmt->close();

            $direccion = $direccionControlador->obtenerDireccionId($id_usuario, $pedido->obtenerIdDireccion());
            $calleLocalidad = $direccion["direccion"] . ", " . $direccion["localidad"];
            echo '<details class="pedido">
                    <summary class="num-pedido"> 
                        NÚMERO PEDIDO: <span class="numero">' . $pedido->obtenerNumPedido() . '</span>
                    </summary>
                    <div class="datos">
                        <div class="contenedor-fecha">
                            <p>PEDIDO REALIZADO</p>
                            <p class="fecha">' . $pedido->obtenerFecha() . '</p>
                        </div>
                        <div class="contenedor-total">
                            <p>TOTAL</p>
                            <p class="total">' . $pedido->obtenerTotal() . ' &euro;</p>
                        </div>
                        <div class="contenedor-estado">
                            <p>ESTADO</p>
                            <p class="estado">' . $pedido->obtenerEstado() . '</p>
                        </div>
                        <div class="contenedor-direccion">
                            <p>DIRECCIÓN ENVIADA</p>
                            <p class="estado">' . $calleLocalidad . '</p>
                        </div>
                    </div>';
            echo '<div class="articulos">';
            if (count($detallesPedidos) > 0) {
                foreach ($detallesPedidos as $idPedido => $detalle) {
                    foreach ($detalle as $productoVendido) {
                        $producto = $productoControlador->obtenerProducto($productoVendido["idProducto"]);
                        echo '<article class="articulo" id="' .  $producto->obtenerId() . '">
                                        <img src="' .  $producto->obtenerImagen() . '">
                                        <h3 class="nombre">' . $producto->obtenerNombre() . '</h2>
                                        <div class="datos-articulo">
                                            <div class="contenedor-talla">
                                                <p>TALLA</p>
                                                <p>' . $productoVendido["talla"] . '</p>
                                            </div>
                                            <div class="contenedor-color">
                                                <p>COLOR</p>
                                                <p>' . $producto->obtenerColor() . '</p>
                                            </div>
                                            <div class="contenedor-cantidad">
                                                <p>CANTIDAD</p>
                                                <p>' . $productoVendido["cantidad"] . '</p>
                                            </div>
                                            <div class="contenedor-total">
                                                <p>TOTAL</p>
                                                <p>' . $productoVendido["total"] . ' &euro;</p>
                                            </div>
                                        </div>
                                    </article>';
                    }
                }
                echo '</div>
                    </details>';
            }  else {
                echo "<h3>Los productos adquiridos en este pedido ya no se encuentran disponibles en nuestra web</h3></div></details>";
            }
        }
    }
}
