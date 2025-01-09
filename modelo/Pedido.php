<?php

    class Pedido {
                //------------------------------------------- CAPA LÓGICA ---------------------------------------------------------------------

        private $idPedido;
        private $idUsuario;
        private $estado;
        private $total;
        private $fecha;
        private $numPedido;
        private $idDireccion;


        public function __construct($idPedido, $idUsuario, $estado, $total, $fecha, $numPedido, $idDireccion){
            $this->idPedido = $idPedido;
            $this->idUsuario = $idUsuario;
            $this->estado = $estado;
            $this->total = $total;
            $this->fecha = $fecha;
            $this->numPedido = $numPedido;
            $this->idDireccion = $idDireccion;
        }

        public function obtenerIdPedido(){
            return $this->idPedido;
        }

        public function obtenerIdUsuario(){            
            return $this->idUsuario;
        }

        public function obtenerEstado(){            
            return $this->estado;
        }   

        public function obtenerTotal(){            
            return $this->total;
        }

        public function obtenerFecha(){            
            return $this->fecha;
        }   

        public function obtenerNumPedido(){            
            return $this->numPedido;
        }   

        public function obtenerIdDireccion(){            
            return $this->idDireccion;
        }

    }
?>