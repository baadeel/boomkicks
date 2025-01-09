<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/productos/ProductoControlador.php";

    session_start();
//------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------


if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1 ) {
    $productoControlador = new ProductoControlador();
//--------------- GET: RECUPERAR INFORMACIÓN DEL PRODUCTO A EDITAR ---------------------------------------------------------------------
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET["id"];
        $productoEditar = $productoControlador->obtenerProducto($id);

        if($productoEditar){
           echo json_encode($productoEditar);
        } else {
            echo null;
        }
    }
//-------------- GET: RECUPERAR TALLAS DE UN PRODUCTO --------------------------------------------------------------------------------
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tallas'])) {
        $id = $_GET["idProducto"];
        $tallas = $productoControlador->obtenerTallasCantidad($id);
       
        if($tallas && count($tallas) > 0){
          echo json_encode($tallas);
        } else {
            echo null;
        }
    }

//--------------- POST: RECUPERAR DATOS DE UN FORMULARIO Y EDITAR UN PRODUCTO ---------------------------------------------------------------------------------

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
        $id = $_POST["id"];
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
  
    
         //Si se ha cambiado la imagen se procesa
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) { 
            //Procesar imagen
            $nombreCarpeta = str_replace(' ', '-', $nombre);
    
            $rutaCarpeta = '../../recursos/img/zapatillas/' . $nombreCarpeta . '/';
    
            if (!is_dir($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0777, true);
            }

           $rutaTemporal = $_FILES['imagen']['tmp_name'];
           $nombreArchivo = $_FILES['imagen']['name'];
           $extension =  pathinfo($nombreArchivo, PATHINFO_EXTENSION);

           $nombreArchivo = nombreImagen($rutaCarpeta, $extension);
           $rutaDestino = $rutaCarpeta . $nombreArchivo;
          
           if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
              $rutaAbsoluta = realpath($rutaDestino);
              $documentRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
              $normalizarRuta = str_replace('\\', '/', $rutaAbsoluta);   
              $imagen = str_replace($documentRoot, " ", $normalizarRuta);
           }
        } else {
          //Si no se ha cambiado la imagen se recuperar de la base de datos
            $producto = $productoControlador->obtenerProducto($id);
            $imagen = $producto->obtenerImagen();
        }
  
        //Crear articulo
        $producto = new Producto($id, $nombre, $color, $descripcion, $precio, null ,$imagen, null, null, $idMarca, $idCategoria);
        $productoControlador->crearProducto($producto);

        //Recuperar las tallas
         if (isset($_POST["tallas"])) {
           $tallas = $_POST["tallas"];

           $listaTallas = $productoControlador->obtenerListadoTallas();
           $tallasCantidadDeProducto = $productoControlador->obtenerTallasCantidad($id);
           $arrayTallasFormulario = [];

           //Si hay tallas en el formulario
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
                 $arrayTallasFormulario[$talla] = $cantidad;

                //Comprobar si se han cambiado tallas y actualizarlas     
                 if(array_key_exists($talla, $tallasCantidadDeProducto)){
                    $productoControlador->actualizarTallaCantidad($id, $idTalla, $cantidad);
                 } else {
                     $productoControlador->insertarTallaCantidad($id, $idTalla, $cantidad);
                 }

              }
                //Comprobar si se han eliminado tallas y borrarlas    
              $tallasBorrar = array_diff_key($tallasCantidadDeProducto, $arrayTallasFormulario);

              if(count($tallasBorrar) > 0){
                foreach($tallasBorrar as $talla => $cantidad){
                    $idTalla = array_search($talla, $listaTallas);
                    $productoControlador->borrarTallasCantidad($id, $idTalla);
                }
              }
           }
        } else {
             //Si se han borrado todas las tallas, borrar todas de la DB    
            $productoControlador->borrarTodasLasTallas($id);
        }

        $_SESSION["articulo_modificado"] = true;
        header("Location: /vista/admin/detalle-articulo-adm.php?id=". $id);
       
    }
} else {
    header("Location: /index.php");
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
    ?>