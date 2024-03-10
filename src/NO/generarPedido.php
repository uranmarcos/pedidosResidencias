<?php 
$modalPedidoNoGenerado = "hide";
$mensajePedidoNoGenerado = "";
$modalPedidoNoEnviado = "hide";
$modalPedidoNoActualizado = "hide";
$idPedido = null;
// START FUNCIONES GENERACION DE PEDIDO
    
// BOTON CONFIRMACION DE GENERAR PEDIDO
if(isset($_POST["generarPedido"])){
    //ARMO PEDIDO PARA LA BDD RECORRIENDO INPUT DEL FORMULARIO Y CAMPO OTROS
    $pedido = "";
    
    for($i = 1; $i<= 200; $i++ ){
        if(isset($_POST[$i])){
            if($_POST[$i] != 0) {
                $pedido = $pedido . $i . ":" . $_POST[$i] . ";";
            }
        }
    }
    // Valido no haya error en el pedido con los id
    $errorEnPedido = false;
    $pedidoValidado = explode(";", $pedido);
    array_pop($pedidoValidado);
    foreach ($pedidoValidado as $key ) {
        $p = explode(":", $key);
        if($p[0] == 0 || $p[0] == "") {
            $errorEnPedido = true;
        }
    }
    if($_POST["otros"] != ""){
        $p = str_replace(";", ",", $_POST["otros"]);
        $p = str_replace(":", "=", $p);
        $pedido = $pedido . "otros:" . $p . ";";  
    }

    //GUARDO EL PEDIDO EN BASE DE DATOS 
    if ($sede == 0 || $sede == "" || $casa == 0 || $casa == "" || $idUser == 0 || $idUser == "" || $errorEnPedido) {
        $modalPedidoNoGenerado ="show";
        $mensajePedidoNoGenerado = "Hay un error con los datos. Por favor actualizá la página y generá el pedido nuevamente.";
    } else {
        $insertPedido = $baseDeDatos ->prepare("INSERT into pedidosnuevos VALUES(default, '$sede', '$casa', '$idUser', '$pedido', 0, '$date')"); 
        try {
            $insertPedido->execute();
            $pedidoGuardado = true;
        } catch (\Throwable $th) {
            $modalPedidoNoGenerado ="show";
            $mensajePedidoNoGenerado = "Hubo un error de conexión y el pedido no pudo generarse.<br> Por favor intentalo nuevamente.";
        }
    }
    
    // SI EL PEDIDO SE GUARDO EN BASE DE DATOS CONTINUO PARA GENERAR EL PDF
    if($pedidoGuardado){
        try {
            // CONSULTO EL ID DEL PEDIDO GUARDO PARA GENERAR EL PDF Y ENVIAR EL MAIL
            $consultaUltimoPedido = $baseDeDatos ->prepare("SELECT id FROM pedidosnuevos WHERE usuario = '$idUser' ORDER BY fecha DESC LIMIT 1 "); 
            $consultaUltimoPedido->execute();
            $id = $consultaUltimoPedido -> fetchAll(PDO::FETCH_ASSOC);
            $idPedido = $id[0]["id"];
            $tipoMail = "envio";
            require("funciones/pdf.php");
            require("funciones/pdfMail.php");
            include("mail.php");
            $pedidoEnviado = true;
        } catch (\Throwable $th) {
            $modalPedidoNoGenerado ="show";
            $mensajePedidoNoGenerado = "Hubo un error de conexión y el pedido no pudo generarse.<br> Por favor intentalo nuevamente.";
        }
    }
    if($pedidoEnviado) {
        // SI EL PEDIDO SE ENVIO, ACTUALIZO EN BASE DE DATOS EL CAMPO "ENVIADO"
        try {
            $consultaUltimoPedido = $baseDeDatos ->prepare("SELECT id FROM pedidosnuevos WHERE usuario = '$idUser' ORDER BY fecha DESC LIMIT 1 "); 
            $consultaUltimoPedido->execute();
            $id = $consultaUltimoPedido -> fetchAll(PDO::FETCH_ASSOC);
            $id = $id[0]["id"];
            $consultaEnviado = $baseDeDatos ->prepare("UPDATE pedidosnuevos SET enviado = 1 WHERE id = '$idPedido'"); 
            $consultaEnviado->execute();
            $pedidoActualizado = true;
        } catch (\Throwable $th) {
            $modalPedidoNoActualizado ="show";
        }
    }
}

// CUANDO SE ENVIA EL PEDIDO PERO NO SE ACTUALIZO COMO ENVIADO
if(isset($_POST["actualizarEnviado"])){
    try {
        $consultaUltimoPedido = $baseDeDatos ->prepare("SELECT id FROM pedidosnuevos WHERE usuario = '$idUser' ORDER BY fecha DESC LIMIT 1 "); 
        $consultaUltimoPedido->execute();
        $id = $consultaUltimoPedido -> fetchAll(PDO::FETCH_ASSOC);
        $id = $id[0]["id"];
        $consultaEnviado = $baseDeDatos ->prepare("UPDATE pedidosnuevos SET enviado = 1 WHERE id = '$id'"); 
        $consultaEnviado->execute();
        $pedidoActualizado = true;
    } catch (\Throwable $th) {
        $modalPedidoNoActualizado ="show";
    }
}


if($pedidoActualizado) {
    setcookie("pedidoEnviado", true, time() + (10), "/");
    echo "<script> localStorage.clear();</script>";
    echo "<script>location.href='pedidos.php';</script>";
}
if($_SESSION["errorMail"]){
    $modalPedidoNoEnviado ="show";
    $_SESSION["errorMail"] = false;
}