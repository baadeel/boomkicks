<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modelo/Productos.php";
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------
//Recuperar datos del formulario y crear un artículo
if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) {
   $productoControlador = new ProductoControlador();
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nombre = $_POST["name"];

      $marca = $_POST["marca"];
      if ($marca == "nueva") {
         $idMarca = $productoControlador->crearMarca($_POST["nueva-marca"]);
      } else {
         $idMarca = $marca;
      }

      $idCategoria = $_POST["categoria"];
      $color = $_POST["color"];
      $precio = $_POST["precio"];
      $descripcion = $_POST["descripcion"];

      //Procesar imagen
      $nombreCarpeta = str_replace(' ', '-', $nombre);

      $rutaCarpeta = '../../recursos/img/zapatillas/' . $nombreCarpeta . '/';

      if (!is_dir($rutaCarpeta)) {
         mkdir($rutaCarpeta, 0777, true);
      }

      if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
         $nombreArchivo = $_FILES['imagen']['name'];
         $rutaTemporal = $_FILES['imagen']['tmp_name'];
         $extension =  pathinfo($nombreArchivo, PATHINFO_EXTENSION);

         $nombreArchivo = nombreImagen($rutaCarpeta, $extension);
         $rutaDestino = $rutaCarpeta . $nombreArchivo;
        
         if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            $rutaAbsoluta = realpath($rutaDestino);
            $documentRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
            $normalizarRuta = str_replace('\\', '/', $rutaAbsoluta);   
            $imagen = str_replace($documentRoot, " ", $normalizarRuta);
         }
      }

      //Crear articulo
      $producto = new Producto(null, $nombre, $color, $descripcion, $precio, null ,$imagen, null, null, $idMarca, $idCategoria);
      $idProducto = $productoControlador->crearProducto($producto);

       //Tallas
       if (isset($_POST["tallas"])) {


         $tallas = $_POST["tallas"];

         $listaTallas = $productoControlador->obtenerListadoTallas();
         if ($tallas) {
            foreach ($tallas as $index => $tallaData) {
               $talla = $tallaData['talla'];
               $cantidad = $tallaData['cantidad'];
               $flag = false;
               foreach ($listaTallas as $clave => $valor) {
                  
                  if ($valor == $talla) {
                     $flag = true;
                     $idTalla = $clave;
                  }
               }

               if(!$flag){
                  $idTalla = $productoControlador->crearTalla($talla);
               }

               $productoControlador->insertarTallaCantidad($idProducto, $idTalla, $cantidad);
            }
         }
      }
      $_SESSION["nuevo_articulo"] = true;
      header("Location: /vista/admin/articulos-adm.php");
   }
} else {
   header("Location: /vista/index.php");
}

//Función para cambiar el nombre de la imagen de forma ordenada
//(Creé con la posibilidad de escalar la aplicación y tener varias imágenes de un producto)
function nombreImagen($dir, $extension)
{
   $i = 1;
   $filename = 'img' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.' . $extension;

   while (file_exists($dir . '/' . $filename)) {
      $i++;
      $filename = 'img' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.' . $extension;
   }

   return $filename;
}
