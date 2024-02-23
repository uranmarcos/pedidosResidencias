<?php
session_start();

require("funciones/pdo.php");
require("funciones/pedidos.php");
// START ACCION VER PDF - ABRIR PEDIDO //        
if(isset($_POST["descargarPedido"])){
  $id = $_POST["id"];
  require("funciones/pdf.php");
  require("funciones/armarPdf.php");
}
// END ACCION VER PDF - ABRIR PEDIDO //  

?>

