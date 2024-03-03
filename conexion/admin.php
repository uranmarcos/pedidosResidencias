<?php
class ApptivaDB {
    private $host = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $db = "pedidosresidencias";
    public $conexion;

    // private $host = "localhost";
    // private $usuario = "fundaci_pedidos";
    // private $clave = "pedidos.1379";
    // private $db = "fundaci_pedidos";
    // public $conexion;
    
    public function __construct(){
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->db)
        or die(mysql_error());
        $this->conexion->set_charset("utf8");
    }

    public function getDatos($opcion) { 
        try {
            if ($opcion == 'articulos') {
                $resultado = $this->conexion->query("SELECT a.id AS id, a.descripcion AS descripcion, c.descripcion AS categoria FROM articulos a INNER JOIN categorias c ON a.categoria = c.id ORDER BY c.descripcion, a.descripcion") or die();
            } else if ($opcion == 'pedidos') {
                $resultado = $this->conexion->query("SELECT id, residencia, voluntario, fecha FROM pedidos") or die();
            } else if ($opcion == 'residencias') {
                $resultado = $this->conexion->query("SELECT id, CONCAT(provincia,' - ', localidad) as residencia, usuario, pass FROM residencias") or die();
            } else {
                $resultado = $this->conexion->query("SELECT * FROM $opcion") or die();
            }

            return $resultado->fetch_all(MYSQLI_ASSOC);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function insertar($tabla, $datos) {
        try {
            $resultado = $this->conexion->query("INSERT INTO $tabla VALUES(null, $datos)") or die();
            //return true;

            if ($resultado === false) {
                return false; // Error al ejecutar la sentencia SQL
            }
    
            $idInsertado = $this->conexion->insert_id;
    
            if ($idInsertado > 0) {
                return $idInsertado; // Devuelve el ID de la instancia insertada
            } else {
                return false; // No se insertó ninguna instancia o no se obtuvo el ID
            }
        } catch (\Throwable $th) {
            // return $th;
            return false;
        }
    }

    public function editarResidencia($id, $provincia, $localidad, $usuario, $pass) {
        try {
            // $resultado = $this->conexion->query("UPDATE residencias SET provincia = '$provincia', localidad='$localidad', usuario = '$usuario', pass = '$pass' WHERE id = '$id'") or die();
            // //return true;

            // if ($resultado === false) {
            //     return false; // Error al ejecutar la sentencia SQL
            // }
            $stmt = $this->conexion->prepare("UPDATE residencias SET provincia = ?, localidad = ?, usuario = ?, pass = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $provincia, $localidad, $usuario, $pass, $id);
            if (!$stmt->execute()) {
                return false;
                // Manejo de errores
                die("Error al ejecutar la actualización: " . $stmt->error);
            }
            return true;
            // $idInsertado = $this->conexion->insert_id;
    
            // if ($idInsertado > 0) {
            //     return $idInsertado; // Devuelve el ID de la instancia insertada
            // } else {
            //     return false; // No se insertó ninguna instancia o no se obtuvo el ID
            // }
        } catch (\Throwable $th) {
            // return $th;
            return false;
        }
    }
}

?>