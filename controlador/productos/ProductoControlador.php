
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Productos.php";

//Lógica Productos
class ProductoControlador
{
//------------------------------------------- CAPA DE ACCESO A DATOS ---------------------------------------------------------------------
    //Tabla: Marcas
    public function obtenerListadoMarcas()
    {
        global $mysqli;
        $marcas = [];

        if ($stmt = $mysqli->prepare("SELECT id_marca, nombre FROM marcas")) {
            $stmt->execute();
            $stmt->bind_result($id, $nombre);

            while ($stmt->fetch()) {
                $marcas[$id] = $nombre;
            }

            $stmt->close();
            return $marcas;
        }
        $mysqli->close();
    }

    //Tabla: Categorías
    public function obtenerListadoCategorias()
    {
        global $mysqli;
        $categorias = [];

        if ($stmt = $mysqli->prepare("SELECT id_cat, nombre FROM categorias")) {
            $stmt->execute();
            $stmt->bind_result($id, $nombre);

            while ($stmt->fetch()) {
                $categorias[$id] = $nombre;
            }

            $stmt->close();
            return $categorias;
        }
        $mysqli->close();
    }

    //Lista: Productos más vendidos
    public function obtenerTopProductos()
    {
        global $mysqli;
        $productos = [];

        if ($stmt = $mysqli->prepare("SELECT * FROM productos ORDER BY vendidos DESC LIMIT 4")) {
            $stmt->execute();

            $stmt->bind_result($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);

            while ($stmt->fetch()) {
                $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
                $productos[] = $producto;
            }

            $stmt->close();
            return $productos;
        }
        $mysqli->close();
    }

    //Lista: Productos nuevos
    public function obtenerNuevosProductos()
    {
        global $mysqli;
        $productos = [];

        if ($stmt = $mysqli->prepare("SELECT * FROM productos ORDER BY fecha DESC LIMIT 4")) {
            $stmt->execute();

            $stmt->bind_result($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);

            while ($stmt->fetch()) {
                $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
                $productos[] = $producto;
            }

            $stmt->close();
            return $productos;
        }
        $mysqli->close();
    }

    //Lista de likes del usuario
    public function obtenerProductosLikes($id_usuario)
    {
        global $mysqli;
        $productos = [];

        $stmt = $mysqli->prepare("SELECT p.id_producto, p.nombre, p.color, p.descripcion, p.precio, p.descuento, 
                                        p.imagen, p.vendidos, p.fecha, p.id_marca, p.id_cat
                                        FROM productos p
                                        JOIN likes l ON p.id_producto = l.id_producto
                                        WHERE l.id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $stmt->bind_result($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);

        while ($stmt->fetch()) {
            $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
            $productos[] = $producto;
        }

        $stmt->close();
        return $productos;

        $mysqli->close();
    }

    //Obtener producto por Id
    public function obtenerProducto($id_producto)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM productos p WHERE p.id_producto = ? ");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();

        $stmt->bind_result($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);

        if ($stmt->fetch()) {
            $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
            $stmt->close();
            return $producto;
        }
    }
    

    //Obtener las tallas y cantidad de un producto
    public function obtenerTallasCantidad($id_producto)
    {
        global $mysqli;

        $talla_cantidad = [];


        $stmt = $mysqli->prepare("SELECT t.numero, pt.cantidad 
                                    FROM tallas t 
                                    JOIN producto_talla pt ON t.id_talla = pt.id_talla
                                    WHERE pt.id_producto = ?");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();

        $stmt->bind_result($talla, $cantidad);

        while ($stmt->fetch()) {
            $talla_cantidad["$talla"] = $cantidad;
        }

        $stmt->close();
        ksort($talla_cantidad);
        return $talla_cantidad;

        $mysqli->close();
    }
    

    //Obtener listado tallas
    public function obtenerListadoTallas()
    {
        global $mysqli;
        $tallas = [];

        if ($stmt = $mysqli->prepare("SELECT * FROM tallas")) {
            $stmt->execute();
            $stmt->bind_result($id_talla, $numero);

            while ($stmt->fetch()) {
                $tallas[$id_talla] = $numero;
            }

            $stmt->close();
            return $tallas;
        }
        $mysqli->close();
    }

    //Obtener todos los productos
    public function obtenerProductoTodosTablaAdm()
    {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT id_producto, nombre, id_marca, id_cat, color, precio, vendidos, fecha  FROM productos");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $nombre, $id_marca, $id_cat, $color, $precio, $vendidos, $fecha);
        $productos = [];
        $marcas = $this->obtenerListadoMarcas();
        $categorias = $this->obtenerListadoCategorias();

        while ($stmt->fetch()) {
            $marca = $marcas[$id_marca];
            $categoria = $categorias[$id_cat];
            $productos[] = [
                "id" => $id,
                "nombre" => $nombre,
                "marca" => $marca,
                "categoria" => $categoria,
                "color" => $color,
                "precio" => $precio,
                "vendidos" => $vendidos,
                "fecha" => $fecha
            ];
        }

        $stmt->close();
        return $productos;
    }


    //Crear una nueva marca
    public function crearMarca($nombre)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("INSERT INTO marcas(nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        if ($stmt->execute()) {
            $id = $mysqli->insert_id;
        }
        $stmt->close();
        return $id;
    }

    //Crear una nueva talla
    public function crearTalla($talla)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("INSERT INTO tallas(numero) VALUES (?)");
        $stmt->bind_param("i", $talla);
        if ($stmt->execute()) {
            $id = $mysqli->insert_id;
        }
        $stmt->close();
        return $id;
    }

    //Crear o actualizar un producto
    public function crearProducto(Producto $producto)
    {
        global $mysqli;
        $id = $producto->obtenerId();
        $nombre = $producto->obtenerNombre();
        $color = $producto->obtenerColor();
        $descripcion = $producto->obtenerDescripcion();
        $precio = $producto->obtenerPrecio();
        $imagen = $producto->obtenerImagen();
        $id_marca = $producto->obtenerMarca();
        $id_cat = $producto->obtenerCategoria();

        $stmt = $mysqli->prepare("INSERT INTO productos (id_producto, nombre, color, descripcion, precio, imagen, id_marca, id_cat) 
                                VALUES (?, ?,?,?,?,?,?,?)
                                ON DUPLICATE KEY UPDATE nombre = VALUES(nombre),
                                                        color = VALUES(color),
                                                        descripcion = VALUES(descripcion),
                                                        precio = VALUES(precio),
                                                        imagen = VALUES(imagen),
                                                        id_marca = VALUES(id_marca),
                                                        id_cat = VALUES(id_cat)");

        $stmt->bind_param("isssdsii", $id, $nombre, $color, $descripcion, $precio, $imagen, $id_marca, $id_cat);
        if ($stmt->execute()) {
            $id = $mysqli->insert_id;
        }
        $stmt->close();
        return $id;
    }

    //Insertar tallas de un producto
    public function insertarTallaCantidad($id_producto, $id_talla, $cantidad)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("INSERT INTO producto_talla(id_producto, id_talla, cantidad) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $id_producto, $id_talla, $cantidad);
        if ($stmt->execute()) {
            echo "ok";
        }
        $stmt->close();
    }

    //Editar tallas de un producto
    public function actualizarTallaCantidad($id_producto, $id_talla, $cantidad)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE producto_talla SET cantidad = ? WHERE id_producto = ? AND id_talla = ?");
        $stmt->bind_param("iii", $cantidad, $id_producto, $id_talla);
        if ($stmt->execute()) {
            echo "ok";
        }
        $stmt->close();
    }

    //Borrar tallas de un producto
    public function borrarTallasCantidad($id_producto, $id_talla)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("DELETE FROM producto_talla WHERE id_producto = ? AND id_talla = ?");
        $stmt->bind_param("ii", $id_producto, $id_talla);
        if ($stmt->execute()) {
            echo "borrar";
        }
        $stmt->close();
    }

    //Borrar todas las tallas de un producto
    public function borrarTodasLasTallas($id_producto)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("DELETE FROM producto_talla WHERE id_producto = ?");
        $stmt->bind_param("i", $id_producto);
        if ($stmt->execute()) {
            echo "borrar todo";
        }
        $stmt->close();
    }


    //Eliminar un producto
    public function eliminarProducto($id_producto)
    {
        global $mysqli;

        $stmt = $mysqli->prepare("DELETE FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id_producto);
        if ($stmt->execute()) {
            echo "ok";
        }
    }

    //Recuperar todos los producto
    public function obtenerListaTodosProductos()
    {

        global $mysqli;
        $productos = [];

        if ($stmt = $mysqli->prepare("SELECT * FROM productos")) {
            $stmt->execute();

            $stmt->bind_result($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);

            while ($stmt->fetch()) {
                $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
                $productos[] = $producto;
            }

            $stmt->close();
            return $productos;
        }
        $mysqli->close();
    }

    //Buscar un producto por una letra/palabra
    public function buscarProducto($query)
    {
        global $mysqli;
        $productos = [];

        if ($stmt = $mysqli->prepare("SELECT p.*, m.nombre, c.nombre
                                        FROM productos p
                                        JOIN marcas m ON p.id_marca = m.id_marca
                                        JOIN categorias c ON p.id_cat = c.id_cat
                                        WHERE 
                                            p.nombre LIKE CONCAT('%', ?, '%')
                                            OR p.color LIKE CONCAT('%', ?, '%')
                                            OR m.nombre LIKE CONCAT('%', ?, '%')
                                            OR c.nombre LIKE CONCAT('%', ?, '%');")){ 
            $stmt->bind_param("ssss", $query, $query, $query, $query);                                    
            $stmt->execute();

            $stmt->bind_result(
                $id,
                $nombre,
                $color,
                $descripcion,
                $precio,
                $descuento,
                $imagen,
                $vendidos,
                $fecha,
                $marca,
                $categoria,
                $nombreM,
                $nombreC
            );

            while ($stmt->fetch()) {
                $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
                $productos[] = $producto;
            }

            $stmt->close();
            return $productos;
        }
        $mysqli->close();
    }

    //Buscar un producto por dos filtros
    public function buscarProductosCatMarca($id_cat, $id_marca)
    {
        global $mysqli;
        $productos = [];

        if ($stmt = $mysqli->prepare("SELECT *
                                        FROM productos p
                                        WHERE 
                                            p.id_cat = ?
                                            AND p.id_marca = ?;")){ 
            $stmt->bind_param("ii", $id_cat, $id_marca);                                    
            $stmt->execute();

            $stmt->bind_result(
                $id,
                $nombre,
                $color,
                $descripcion,
                $precio,
                $descuento,
                $imagen,
                $vendidos,
                $fecha,
                $marca,
                $categoria
            );

            while ($stmt->fetch()) {
                $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
                $productos[] = $producto;
            }

            $stmt->close();
            return $productos;
        }
        $mysqli->close();
    }

    //Buscar un producto por un filtros
    public function buscarProductosCat($id_cat)
    {
        global $mysqli;
        $productos = [];

        if ($stmt = $mysqli->prepare("SELECT *
                                        FROM productos p
                                        WHERE 
                                            p.id_cat = ?")){ 
            $stmt->bind_param("i", $id_cat);                                    
            $stmt->execute();

            $stmt->bind_result(
                $id,
                $nombre,
                $color,
                $descripcion,
                $precio,
                $descuento,
                $imagen,
                $vendidos,
                $fecha,
                $marca,
                $categoria
            );

            while ($stmt->fetch()) {
                $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
                $productos[] = $producto;
            }

            $stmt->close();
            return $productos;
        }
        $mysqli->close();
    }

    //Buscar un producto por un filtros
    public function buscarProductosMarca($id_marca)
    {
        global $mysqli;
        $productos = [];

        if ($stmt = $mysqli->prepare("SELECT *
                                        FROM productos p
                                        WHERE 
                                            p.id_marca = ?")){ 
            $stmt->bind_param("i", $id_marca);                                   
            $stmt->execute();

            $stmt->bind_result(
                $id,
                $nombre,
                $color,
                $descripcion,
                $precio,
                $descuento,
                $imagen,
                $vendidos,
                $fecha,
                $marca,
                $categoria
            );

            while ($stmt->fetch()) {
                $producto = new Producto($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria);
                $productos[] = $producto;
            }

            $stmt->close();
            return $productos;
        }
        $mysqli->close();
    }

//------------------------------------------- CAPA PRESENTACIÓN Y LÓGICA ---------------------------------------------------------------------

     //Mostrar producto
     public function pintarProducto($producto, $likes, $carrito = NULL)
     {
 
         if ($producto) {
             $id_producto = $producto->obtenerId();
             if (!$carrito) {
                 $talla_cantidad = $this->obtenerTallasCantidad($id_producto);
             }
             $marcas = $this->obtenerListadoMarcas();
 
 
             if (in_array($id_producto, $likes)) {
                 $like = "like";
                 $relleno = "-relleno";
             } else {
                 $like = "";
                 $relleno = "";
             }
 
             $idMarca = $producto->obtenerMarca();
             echo '
                 <div class="articulo-top">
                     <div id="titulo-articulo">
                         <h1>' . $producto->obtenerNombre() . '</h1>
                         <p>' . $marcas[$idMarca] . '</p>
                     </div>
                     <img id="producto-' . $id_producto . '" class="zapatilla" src="' . $producto->obtenerImagen() . '">
                     <img class="corazon ' .  $like . '" src="/recursos/img/iconos/corazon' .  $relleno . '.png" width="30px">
                     <p id="precio">' . $producto->obtenerPrecio() . '&euro;</p>
                 </div>
                     <div class="articulo-bottom">
                         <div id="descripcion">
                             <h3> Descripción: </h3>
                             <p>' . $producto->obtenerDescripcion() . '</p>
                         </div>
                          <div id="tallas-container">
                             <h3> Tallas disponibles (EU): </h3>
                             <div id="tallas">
                             ' . $this->pintarTallas($talla_cantidad) . '
                             
                             </div>
                             <div id="info"></div>
                         </div>
                         <div id="contador">
                             <button onClick="restar()" disabled id="restar">-</button>
                             <p id="cantidad">1</p>
                             <button onClick="sumar()" disabled id="sumar">+</button>
                         </div>
                         <button disabled id="confirmar" type="button">Añadir a la cesta</button>
                     </div>
                 ';
         } else {
             $this->productoNoEncontrado();
         }
     }

     //Mensaje de error
     public function productoNoEncontrado()
     {
         echo "<h1>El producto no ha sido encontrado";
     }


    //Mostrar las tallas disponibles
    public function pintarTallas($talla_cantidad)
    {
        $html = "";
        if (count($talla_cantidad) > 0) {
            $flag = false;
            foreach ($talla_cantidad as $talla => $cantidad) {
                if ($cantidad > 0) {
                    $flag = true;
                    $html .= '<div id="' . $talla . '" class="talla ' . $cantidad . '">' . $talla . '</div>';
                }
            }
            if (!$flag) {
                $html = "<p>Lo siento, no hay tallas disponibles</p>";
            }
        } else {
            $html = "<p>Lo siento, no hay tallas disponibles</p>";
        }

        return $html;
    }

       //Mostrar las marcas en un select de html
       public function pintarMarcasFormulario($boolean = true, $idSeleccionado = null)
       {
           $marcas = $this->obtenerListadoMarcas();
           echo '<option value="null">-- Selecciona una marca --</option>';
           foreach ($marcas as $id => $nombre) {
               if( isset($idSeleccionado) && $idSeleccionado == $id){
                   echo '<option value="' . $id . '" selected>' . $nombre . '</option>';
               } else {
                   echo '<option value="' . $id . '">' . $nombre . '</option>';
               }
           }
           if($boolean){
            echo '<option value="nueva">+ Nueva marca</option>';
           }
       }
   
       //Mostrar las categorías en un select de html
       public function pintarCategoriasFormulario($idSeleccionado = null)
       {
           $categorias = $this->obtenerListadoCategorias();
           echo '<option value="null"> -- Selecciona una categoría -- </option>';
   
           foreach ($categorias as $id => $nombre) {
               if( isset($idSeleccionado) && $idSeleccionado == $id){
                   echo '<option value="' . $id . '" selected>' . $nombre . '</option>';
               } else {
                   echo '<option value="' . $id . '">' . $nombre . '</option>';
               }
           }
       }


    //Mostrar listas de productos
    public function pintarListasProductos($productos, $likes)
    {
        $marcas = $this->obtenerListadoMarcas();

        foreach ($productos as $producto) {
            if (in_array($producto->obtenerId(), $likes)) {
                $like = "like";
                $relleno = "-relleno";
            } else {
                $like = "";
                $relleno = "";
            }

            $idMarca = $producto->obtenerMarca();
            echo '
                   
                    <div class="articulo">
                    <a class="enlace" 
                        href="/vista/productos/producto.php?id=' . $producto->obtenerId() . '"></a>
                        <div id="titulo-articulo">
                            <h3>' . $producto->obtenerNombre() . '</h3>
                            <small>' . $marcas[$idMarca] . '</small>
                        </div>
                        <img id="producto-' . $producto->obtenerId() . '" class="zapatilla" src="' . $producto->obtenerImagen() . '">
                        <img class="corazon ' .  $like . '" src="/recursos/img/iconos/corazon' .  $relleno . '.png" width="30px">
                        <p>' . $producto->obtenerPrecio() . '&euro;</p>
                    </div>
                    ';
        }
    }

        //Mostrar los productos en una tabla
        public function pintarProductosTabla($productos)
        {
            foreach ($productos as $producto) {
                echo '<tr>
                        <td>' . $producto["id"] . '</td>
                        <td>' . $producto["nombre"] . '</td>
                        <td>' . $producto["marca"] . '</td>
                        <td>' . $producto["categoria"] . '</td>
                        <td>' . $producto["color"] . '</td>
                        <td>' . $producto["precio"] . '</td>
                        <td>' . $producto["vendidos"] . '</td>
                        <td>' . $producto["fecha"] . '</td>
                        <td><a href="/vista/admin/detalle-articulo-adm.php?id=' . $producto["id"] . '"><button>Ver detalles</button></a></td>
                      </tr>';
            }
        }

    //Mostrar un producto en la pantalla del admin
    public function pintarProductoDetalleAdm($id_producto)
    {

        $producto = $this->obtenerProducto($id_producto);
        if ($producto) {
            $talla_cantidad = $this->obtenerTallasCantidad($id_producto);
            $marcas = $this->obtenerListadoMarcas();
            $categorias = $this->obtenerListadoCategorias();
            $idMarca = $producto->obtenerMarca();
            $idCategoria = $producto->obtenerCategoria();

            $htmlTallas = $this->pintarTallasTabla($talla_cantidad);

            echo '<section id="producto">
                    <div class="button">
                        <a href="/vista/admin/articulos-adm.php"><img src="/recursos/img/iconos/izquierda.png"></a>
                        <div id="funciones">
                            <a id="modificar" href="/vista/admin/nuevo-articulo-adm.php?id=' . $id_producto . '"><button class="' . $id_producto . '">Modificar datos</button></a>
                            <button id="eliminar" class="' . $id_producto . '">Borrar producto</button>
                        </div>
                    </div>
                    <div class="articulo-top">
                        <div id="titulo-articulo">
                            <h1>Nombre: ' . $producto->obtenerNombre() . ' </h1>
                            <p>Marca: ' . $marcas[$idMarca] . '</p>
                            <p>Categoria: ' . $categorias[$idCategoria] . '</p>
                            <p>Color: ' . $producto->obtenerColor() . '</p>
                        </div>
                        <img id="producto-' . $id_producto . '" class="zapatilla" src="' . $producto->obtenerImagen() . '">
                        <p id="precio">Precio: ' . $producto->obtenerPrecio() . ' &euro;</p>
                    </div>
                    <div class="articulo-bottom">
                        <div id="descripcion">
                            <h3> Descripción: </h3>
                            <p>' . $producto->obtenerDescripcion() . '</p>
                        </div>
                        <div id="tallas-container">
                            <h3> Tallas disponibles (EU): </h3>
                            ';
            if ($htmlTallas) {
                echo '<table id="tallas">
                                <thead>
                                    <tr>
                                        <th scope="col">Tallas</th>
                                        <th scope="col">Cantidad disponible</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ' . $htmlTallas . '
                        	     </tbody>
                            </table>';
            } else {
                echo '<p>No hay tallas disponibles</p>';
            }

            echo '
                        </div>
                    </div>
                  </section>';
        } else {
            $this->productoNoEncontrado();
        }
    }

     //Mostrar las tallas en una tabla para el admin
     public function pintarTallasTabla($talla_cantidad)
     {
         $html = "";
         if (count($talla_cantidad) > 0) {
             $flag = false;
             foreach ($talla_cantidad as $talla => $cantidad) {
                 if ($cantidad > 0) {
                     $flag = true;
                     $html .= '<tr>
                                 <td>' . $talla . '</td>
                                 <td>' . $cantidad . '</td>
                             </tr>';
                 }
             }
             if (!$flag) {
                 $html = false;
             }
         } else {
             $html = false;
         }
 
         return $html;
     }
 

}
?>