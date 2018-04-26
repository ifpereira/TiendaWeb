<?php

class Producto {
    protected $codigo;
    protected $nombre;
    protected $nombre_corto;
    protected $PVP;
    
    public function get_codigo() {return $this->codigo; }
    public function get_nombre() {return $this->nombre; }
    public function get_nombrecorto() {return $this->nombre_corto; }
    public function get_PVP() {return $this->PVP; }
    
    public function __construct($row) {
        $this->codigo = $row['cod'];
        $this->nombre = $row['nombre'];
        $this->nombre_corto = $row['nombre_corto'];
        $this->PVP = $row['PVP'];
    }
}

?>
