<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/pedidos/PedidoControlador.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Pedido.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/carrito/Carrito.php";
    $carrito = new Carrito();
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Recibir idDirección, obtener el total del carrito y crear un pedido
    if (isset($_SESSION["usuario_logueado"]) && $_SESSION["usuario_logueado"] === true){
            $pedidoControdalor = new PedidoControlador();

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDireccion'])) {
                $pedido = new Pedido(null, $_SESSION["id"], null, $_SESSION["total_carrito"], null, null, $_POST["idDireccion"]);
                $pedidoControdalor->añadirPedido($pedido, $_SESSION["carrito"]);
                $carrito->borrarCarrito($_SESSION["id"]);

                $_SESSION["carrito"] = null;
                $_SESSION["carrito_contador"] = 0;
            }
        } else {
            echo "index";
        }

?>