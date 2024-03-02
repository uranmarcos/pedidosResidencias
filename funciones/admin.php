<?php
    require("../conexion/admin.php");
    $user = new ApptivaDB();

    $accion = "mostrar";
    $res = array("error" => false);
    // $archivoPdf = null;
    
    if (isset($_GET["accion"])) {
        $accion = $_GET["accion"];
    }


    switch ($accion) {

        case 'getDatos':
            $opcion = $_POST["opcion"];
            $u = $user -> getDatos($opcion);

            if ($u || $u == []) { 
                $res["pedidos"] = $u;
                $res["mensaje"] = "La consulta se realizó correctamente";
            } else {
                $res["u"] = $u;
                $res["mensaje"] = "Hubo un error al recuperar la información. Por favor recargue la página.";
                $res["error"] = true;
            } 

        break;
        
    }
    echo json_encode($res);

?>