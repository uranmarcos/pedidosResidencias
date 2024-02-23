<?php 
// START VARIABLES UTILIZADAS //
$alertErrorConexion = "hide";
$alertConfirmacion = "hide";
$mensajeAlertConfirmacion="";
$sede = $_SESSION["sede"];
$casa = $_SESSION["casa"];
$noHayDatos = "show";
$hayDatos = "hide";
$mostrarStock = "hide";
$mostrarAdmin = "hide";  
if(isset($_COOKIE["pedidoEnviado"])) {
  if($_COOKIE["pedidoEnviado"]){
    $alertConfirmacion = "show";
    $mensajeAlertConfirmacion = "El pedido se envio correctamente";
  }
}  

//START CONSULTA DE PEDIDOS REALIZADOS
if($_SESSION["rol"] == "stock") {
  $consultaPedidos = $baseDeDatos ->prepare("SELECT PN.id, PN.sede, PN.fecha, PN.pedido, PN.casa, A.nombre, A.segundoNombre, A.apellido, S.provincia provinciaSede, S.localidad localidadSede FROM pedidosnuevos PN INNER JOIN
    agentes A ON PN.usuario = A.id INNER JOIN sedes S on PN.sede = S.id WHERE PN.sede = $sede AND PN.casa = $casa AND PN.enviado = 1 ORDER BY PN.fecha DESC"); 
    $mostrarStock = "show";   
} else {
  $consultaPedidos = $baseDeDatos ->prepare("SELECT PN.id, PN.sede, PN.usuario, PN.fecha, PN.pedido, A.nombre, PN.casa, A.segundoNombre, A.apellido, S.provincia provinciaSede, S.localidad localidadSede FROM pedidosnuevos PN INNER JOIN
    agentes A ON PN.usuario = A.id INNER JOIN sedes S on PN.sede = S.id WHERE PN.enviado = 1 ORDER BY PN.fecha DESC"); 
    $mostrarAdmin = "show";     
}
$consultaSedes = $baseDeDatos ->prepare("SELECT * FROM sedes");
$consultaVoluntarios = $baseDeDatos ->prepare("SELECT nombre, segundoNombre, apellido, id FROM agentes");
$consultaArticulos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, A.medida, M.descripcion medida from articulos A INNER JOIN medidas M WHERE A.medida = M.id");
  
try {
  $consultaPedidos->execute();
  $consultaSedes -> execute();
  $consultaVoluntarios -> execute();
  $consultaArticulos -> execute();
} catch (\Throwable $th) {
  $alertErrorConexion= "show";
  $mensajeAlertError ="Hubo un error de conexión. Por favor actualice la página";
}
$pedidos = $consultaPedidos -> fetchAll(PDO::FETCH_ASSOC);
$sedes = $consultaSedes -> fetchAll(PDO::FETCH_ASSOC);
$voluntarios = $consultaVoluntarios -> fetchAll(PDO::FETCH_ASSOC);
$articulos = $consultaArticulos -> fetchAll(PDO::FETCH_ASSOC);

if(sizeof($pedidos) != 0) {
  $noHayDatos = "hide";
  $hayDatos = "show";
}
// END CONSULTA PEDIDOS REALIZADOS





