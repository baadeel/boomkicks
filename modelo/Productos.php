<?php

class Producto implements JsonSerializable
{
            //------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

    private $id;
    private $nombre;
    private $color;
    private $descripcion;
    private $precio;
    private $descuento;
    private $imagen;
    private $vendidos;
    private $fecha;
    private $marca;
    private $categoria;

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'color' => $this->color,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'descuento' => $this->descuento,
            'imagen' => $this->imagen,
            'vendidos' => $this->vendidos,
            'fecha' => $this->fecha,
            'marca' => $this->marca,
            'categoria' => $this->categoria,
        ];
    }

    public function __construct($id, $nombre, $color, $descripcion, $precio, $descuento, $imagen, $vendidos, $fecha, $marca, $categoria)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->color = $color;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->descuento = $descuento;
        $this->imagen = $imagen;
        $this->vendidos = $vendidos;
        $this->fecha = $fecha;
        $this->marca = $marca;
        $this->categoria = $categoria;
    }

    public function obtenerId()
    {
        return $this->id;
    }

    public function obtenerNombre()
    {
        return $this->nombre;
    }

    public function obtenerColor()
    {
        return $this->color;
    }

    public function obtenerDescripcion()
    {
        return $this->descripcion;
    }

    public function obtenerPrecio()
    {
        return $this->precio;
    }

    public function obtenerDescuento()
    {
        return $this->descuento;
    }

    public function obtenerImagen()
    {
        return $this->imagen;
    }

    public function obtenerVendidos()
    {
        return $this->vendidos;
    }

    public function obtenerFecha()
    {
        return $this->fecha;
    }

    public function obtenerMarca()
    {
        return $this->marca;
    }

    public function obtenerCategoria()
    {
        return $this->categoria;
    }

    public function establecerId($id)
    {
        $this->id = $id;
    }

    public function establecerNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function establecerColor($color)
    {
        $this->color = $color;
    }

    public function establecerDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function establecerPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function establecerDescuento($descuento)
    {
        $this->descuento = $descuento;
    }

    public function establecerImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function establecerVendidos($vendidos)
    {
        $this->vendidos = $vendidos;
    }

    public function establecerFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function establecerMarca($marca)
    {
        $this->marca = $marca;
    }

    public function establecerCategoria($categoria)
    {
        $this->categoria = $categoria;
    }
}
