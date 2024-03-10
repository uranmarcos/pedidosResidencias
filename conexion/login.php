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

    public function login($usuario, $password) { 
        try {
            $stmt = $this->conexion->prepare("SELECT provincia, localidad, usuario, rol, pass FROM usuarios WHERE usuario = ?");
            $stmt->bind_param('s', $usuario);
            $stmt->execute();
            $stmt->bind_result($provincia, $localidad, $rol, $pass);
            
            $result = array();
            while ($stmt->fetch()) {
                $result[] = array(
                    'provincia' => $provincia,
                    'localidad' => $localidad,
                    'usuario' => $usuario,
                    'rol' => $rol,
                    'pass' => $pass
                );
            }
            
            return $result;
        } catch (Exception $e) {
            // Manejo de errores
            error_log("Error al ejecutar la consulta: " . $e->getMessage());
            return false;
        }
    }  
    
}

?>