
<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/config/conexion.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Productos.php";
    


    //Funciones para mostrar información del carrito
    class Carrito extends ProductoControlador{

    //------------------------------------ CAPA DE PRESENTACIÓN Y CAPA LÓGICA ---------------------------------------------------------

            //Capa de presentación y lógica: Muestra el contenido del carrito o devuelve false si no hay un carrito
            public function pintarCarrito($carrito){
                $total = 0;
            echo '<section id="carrito-productos">';
                if($carrito != null){
                    foreach($carrito as $producto){
                        $id_producto = $producto["idProducto"];
                        $talla = $producto["tallaSeleccionada"];
                        $cantidad = $producto["cantidad"];
                        $cantidadTotal = $producto["cantidadTotal"];
                        $total += $this->pintarProductoCarrito($id_producto, $talla, $cantidad, $cantidadTotal);
                    }
            echo '</section>';

                    echo '<section id="resumen">
                                <h1>Resumen</h1>
                                <div id="tabla">
                                    <p>Gastos de envío</p>
                                    <p>Gratis</p>
                                    <p>Total</p>
                                    <p><strong id="total">' . $total . ' &euro;</strong></p>
                                </div>
                                <button id="confirmar">Confirmar compra</button>
                        </section>';
                    return true;
            } else {
                return false;
            }
            }

        //Capa de presentación y lógica: Muestra los productos que contiene el carrito y devuelve el total del precio
        public function pintarProductoCarrito($id_producto, $talla, $cantidad, $cantidadTotal){
           
           $producto = $this->obtenerProducto($id_producto);

           $marcas = $this->obtenerListadoMarcas();
           $idMarca = $producto->obtenerMarca();

           $categorias = $this->obtenerListadoCategorias();
           $idCategoria = $producto->obtenerCategoria();
           
            echo ' <article id="' . $id_producto ."-" . $talla . '" class="producto">
                        <div id= arriba>
                            <a href="/vista/productos/producto.php?id='. $producto->obtenerId() . '">
                                <img src="'. $producto->obtenerImagen() .'">
                            </a>
                            <div id="nombre-talla">
                                <h1>'. $producto->obtenerNombre() . '</h1>
                                <p id="talla">Talla ' . $talla . '</p>
                            </div>
                            <h3>' . $marcas[$idMarca] . '</h3>
                        </div>
                        <div id="abajo">
                                
                            <p>Categoria: ' . $categorias[$idCategoria] . '</p>
                            <p>Color: '. $producto->obtenerColor() . '</p>
                            <div id="contador-precio">
                                <div id="contador">
                                    <button class="restar">-</button>
                                    <p id="cantidad" class="' . $cantidadTotal . '">'. $cantidad . '</p>
                                    <button class="sumar">+</button>
                                </div>
                                <p id="precio" class="' . $producto->obtenerPrecio() . '">' 
                                . $producto->obtenerPrecio() * $cantidad . ' &euro;</p>
                            </div>
                        </div>
                    </article>';

            return $producto->obtenerPrecio() * $cantidad;
        }
        
        //Capa lógica: Devolver la suma de los artículos en nuestro carrito
        public function sumarContadorCarrito($carrito){
            $totalCantidad = array_reduce($carrito, function ($total, $producto) {
                return $total + (int)$producto["cantidad"]; 
            }, 0);

            return $totalCantidad;
        }
    
        // ------------------------------------ CAPA DE ACCESSO A DATOS ---------------------------------------------------------
        //Guardar el carrito en la DB
         public function guardarCarrito($carrito, $id_usuario){
            global $mysqli;

           
            foreach($carrito as $producto){
                $id_producto = $producto["idProducto"];
                $talla = $producto["tallaSeleccionada"];
                $cantidad = $producto["cantidad"];
                $cantidad_total = $producto["cantidadTotal"];
                $tallas = $this->obtenerListadoTallas();
                $id_talla = array_search($talla, $tallas);

                    $stmt = $mysqli->prepare("INSERT INTO carritos (id_usuario, id_producto, id_talla, cantidad, cantidad_total) 
                                            VALUES (?, ?, ?, ?, ?)
                                            ON DUPLICATE KEY UPDATE cantidad = ?, cantidad_total = ?;");
                $stmt->bind_param("iiiiiii", $id_usuario, $id_producto, $id_talla, $cantidad, $cantidad_total, $cantidad, $cantidad_total);
            
                if($stmt->execute()){
                    echo "ok";
                } else {
                    echo "Error al guardar carrito";
                }
                $stmt->close();
            }        
        }

        //Recuperar el carrito de la DB
        public function recuperarCarrito($id_usuario){
            global $mysqli;

            $tallas = $this->obtenerListadoTallas();
            
            $carrito = [];
    
            
            $stmt = $mysqli->prepare("SELECT id_producto, id_talla, cantidad, cantidad_total FROM carritos WHERE id_usuario = ?");
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
    
            $stmt->bind_result($id_producto, $id_talla, $cantidad, $cantidad_total);
    
            while ($stmt->fetch()) {
                $numero_talla = $tallas[$id_talla];
                $carrito[] = [
                    "idProducto" => strval($id_producto),
                    "tallaSeleccionada" => strval($numero_talla),
                    "cantidad" => strval($cantidad),
                    "cantidadTotal" => strval($cantidad_total)
                ];
            }
    
            $stmt->close();
            return $carrito;
    
            $mysqli->close();
        }

        //Borrar carrito completo
        public function borrarCarrito($id_usuario){
            global $mysqli;

            $stmt = $mysqli->prepare("DELETE FROM carritos WHERE id_usuario = ?");
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
        }

        //Borrar un artículo de una talla del carrito
        public function borrarArticuloCarrito($id_usuario, $id_producto, $talla){
            global $mysqli;
            $tallas = $this->obtenerListadoTallas();
            $id_talla = array_search($talla, $tallas);

           $stmt = $mysqli->prepare("DELETE FROM carritos WHERE id_usuario = ? AND id_producto = ? AND id_talla = ?");
           $stmt->bind_param("iii",
           $id_usuario,
           $id_producto,
           $id_talla
            );
            $stmt->execute();
        }


        

    }
?>