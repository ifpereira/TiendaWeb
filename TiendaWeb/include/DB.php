<?php
require_once('Producto.php');

class DB {
    protected static function ejecuta_consulta($sql) {
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=dwes";
        $usuario = 'dwes';
        $contrasena = 'abc123.';
        
        $dwes = new PDO($dsn, $usuario, $contrasena, $opc);
        $resultado = null;
        if (isset($dwes)) $resultado = $dwes->query($sql);
        return $resultado;
    }

    public static function obtiene_productos() {
        $sql = "SELECT cod, nombre_corto, nombre, PVP FROM producto;";
        $resultado = self::ejecuta_consulta ($sql);
        $productos = array();

        if($resultado) {
            // Añadimos un elemento por cada producto obtenido
            $row = $resultado->fetch();
            while ($row != null) {
                $productos[] = new Producto($row);
                $row = $resultado->fetch();
            }
        }
        
        return $productos;
    }

    
    public static function obtiene_producto($codigo) {
        $sql = "SELECT cod, nombre_corto, nombre, PVP FROM producto";
        $sql .= " WHERE cod='" . $codigo . "'";
        $resultado = self::ejecuta_consulta ($sql);
        $producto = null;

        if(isset($resultado)) {
            $row = $resultado->fetch();
            $producto = new Producto($row);
        }
        
        return $producto;    
    }
    
    public static function verifica_cliente($nombre, $contrasena) {
        $verificado = false;
        try
        {
            $sql = "SELECT usuario FROM usuarios ";
            $sql .= "WHERE usuario='$nombre' ";
            $sql .= "AND contrasena='" . md5($contrasena) . "';";
            $resultado = self::ejecuta_consulta ($sql);
            $verificado = false;

            if(isset($resultado)) {
                $fila = $resultado->fetch();
                if($fila !== false) $verificado=true;
            }
        }
        catch(PDOException $e)
        {

        }
        return $verificado;
    }
    
}

?>
