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
                $resultado = $this->conexion->query("SELECT id, descripcion, categoria, medida FROM articulos ORDER BY categoria, descripcion") or die();
            } else if ($opcion == 'pedidos') {
                $resultado = $this->conexion->query("SELECT id, residencia, voluntario, fecha FROM pedidos") or die();
            } else if ($opcion == 'usuarios') {
                $resultado = $this->conexion->query("SELECT id, CONCAT(provincia,' - ', localidad) as residencia, usuario, pass, rol, casas FROM usuarios") or die();
            } else {
                $resultado = $this->conexion->query("SELECT * FROM $opcion") or die();
            }

            return $resultado->fetch_all(MYSQLI_ASSOC);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getPedidos($idUsuario) {
        try {
            if ($idUsuario == 0) {
                $resultado = $this->conexion->query("SELECT * FROM pedidos") or die();
            } else {
                $resultado = $this->conexion->query("SELECT * FROM pedidos WHERE idUsuario = '$idUsuario'") or die();
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

    public function editarUsuario($id, $provincia, $localidad, $usuario, $pass, $rol, $casas) {
        try {
            $stmt = $this->conexion->prepare("UPDATE usuarios SET provincia = ?, localidad = ?, usuario = ?, pass = ?, rol = ?, casas = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $provincia, $localidad, $usuario, $pass, $rol, $casas, $id);
            if (!$stmt->execute()) {
                return false;
                // Manejo de errores
                die("Error al ejecutar la actualización: " . $stmt->error);
            }
            return true;
        } catch (\Throwable $th) {
            // return $th;
            return false;
        }
    }

    public function editarCategoria($id, $descripcion) {
        try {
            $stmt = $this->conexion->prepare("UPDATE categorias SET descripcion = ? WHERE id = ?");
            $stmt->bind_param("si", $descripcion, $id);
            if (!$stmt->execute()) {
                return false;
                // Manejo de errores
                die("Error al ejecutar la actualización: " . $stmt->error);
            }
            return true;
        } catch (\Throwable $th) {
            // return $th;
            return false;
        }
    }

    public function editarArticulo($id, $descripcion, $categoria, $medida) {
        try {
            $stmt = $this->conexion->prepare("UPDATE articulos SET descripcion = ?, categoria = ?, medida = ? WHERE id = ?");
            $stmt->bind_param("sssi", $descripcion, $categoria, $medida, $id);
            if (!$stmt->execute()) {
                return false;
                // Manejo de errores
                die("Error al ejecutar la actualización: " . $stmt->error);
            }
            return true;
        } catch (\Throwable $th) {
            // return $th;
            return false;
        }
    }

    public function getUsuarios() {
        try {
            $resultado = $this->conexion->query("SELECT id, localidad FROM usuarios ORDER BY localidad") or die();

            return $resultado->fetch_all(MYSQLI_ASSOC);
        } catch (\Throwable $th) {
            return false;
        }
    }
}

?>