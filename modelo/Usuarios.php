<?php
     require_once $_SERVER["DOCUMENT_ROOT"] . "/config/conexion.php";

    class Usuario {
                //------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

        private $nombre;
        private $email;
        private $pass;
        private $tipo;

        public function __construct($nombre, $email, $pass, $tipo = 0){
         $this->nombre = $nombre;
         $this->email = $email;
         $this->pass = $pass;  
         $this->tipo = $tipo;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getPassword(){
            return $this->pass;
        }

        public function getTipo(){
            return $this->tipo;
        }

        public function guardar(){
            global $mysqli;
           
            $stmt = $mysqli->prepare("INSERT INTO usuarios(nombre, email, pass, tipo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $this->nombre, $this->email, $this->pass, $this->tipo);
            return $stmt->execute();
        }
    }
?>