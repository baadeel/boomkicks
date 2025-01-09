<?php
    class Direccion {
        //------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

        private $idDireccion;
        private $idUsuario;
        private $direccion;
        private $nombre;
        private $telefono;

        public function __construct($idDireccion, $idUsuario, $direccion, $nombre, $telefono){
            $this->idDireccion = $idDireccion;
            $this->idUsuario = $idUsuario;
            $this->direccion = $direccion;
            $this->nombre = $nombre;
            $this->telefono = $telefono;
        }

        public function obtenerIdDireccion(){
            return $this->idDireccion;
        }

        public function obtenerIdUsuario(){
            return $this->idUsuario;
        }   

        public function obtenerDireccion(){
            return $this->direccion;
        }  

        public function obtenerNombre(){            
            return $this->nombre;
        }

        public function obtenerTelefono(){
            return $this->telefono;
        }

    }




?>