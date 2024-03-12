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

        case 'crearUsuario':
            $provincia = $_POST["provincia"];
            $localidad = $_POST["localidad"];
            $usuario = $_POST["usuario"];
            // $pass = $_POST['pass'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $rol = $_POST['rol'];
            $casas = $_POST['casas'];
            $data = "'" . $provincia . "', '" . $localidad . "', '" . $usuario . "', '" . $pass . "', '" . $rol . "', '" . $casas .  "'";
            
            $u = $user -> insertar("usuarios", $data);
        
            if ($u) {
                $res["error"] = false;
                $res["mensaje"] = "El usuario se guardó correctamente";
            } else {
                $res["mensaje"] = "No se pudo guardar el usuario. Intente nuevamente";
                $res["error"] = true;
            } 
        break;
        
        case 'editarUsuario':
            $id = $_POST['id'];
            $provincia = $_POST["provincia"];
            $localidad = $_POST["localidad"];
            $usuario = $_POST["usuario"];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $rol = $_POST['rol'];
            $casas = $_POST['casas'];
            
            $u = $user -> editarUsuario($id, $provincia, $localidad, $usuario, $pass, $rol, $casas);
        
            if ($u || $u == true) {
                $res["error"] = false;
                $res["mensaje"] = "El usuario se guardó correctamente";
            } else {
                $res["mensaje"] = "No se pudo guardar el usuario. Intente nuevamente";
                $res["error"] = true;
            } 

        break;   

        case 'getPedidos':
            $idUsuario = $_POST['idUsuario'];
            
            $u = $user -> getPedidos($idUsuario);

            if ($u || $u == []) { 
                $res["pedidos"] = $u;
                $res["mensaje"] = "La consulta se realizó correctamente";
            } else {
                $res["u"] = $u;
                $res["mensaje"] = "Hubo un error al recuperar la información. Por favor recargue la página.";
                $res["error"] = true;
            } 

        break;

        case 'getUsuarios':
            $u = $user -> getUsuarios();

            if ($u || $u == []) { 
                $res["usuarios"] = $u;
                $res["mensaje"] = "La consulta se realizó correctamente";
            } else {
                $res["mensaje"] = "Hubo un error al recuperar la información. Por favor recargue la página.";
                $res["error"] = true;
            } 

        break;

        case 'crearCategoria':
            $descripcion = $_POST["descripcion"];
            $data = "'" . $descripcion . "'";
            
            $u = $user -> insertar("categorias", $data);
        
            if ($u) {
                $res["error"] = false;
                $res["mensaje"] = "La categoria se guardó correctamente";
            } else {
                $res["mensaje"] = "No se pudo guardar la categoria. Intente nuevamente";
                $res["error"] = true;
            } 
        break;
        
        case 'editarCategoria':
            $id = $_POST['id'];
            $descripcion = $_POST["descripcion"];
            
            $u = $user -> editarCategoria($id, $descripcion);
        
            if ($u || $u == true) {
                $res["error"] = false;
                $res["mensaje"] = "La categoria se guardó correctamente";
            } else {
                $res["mensaje"] = "No se pudo guardar la categoria. Intente nuevamente";
                $res["error"] = true;
            } 

        break;   

        case 'crearArticulo':
            $descripcion = $_POST["descripcion"];
            $categoria = $_POST["categoria"];
            $medida = $_POST["medida"];
            $data = "'" . $descripcion . "', '" . $categoria . "', '" . $medida . "'";
            
            
            $u = $user -> insertar("articulos", $data);
        
            if ($u) {
                $res["error"] = false;
                $res["mensaje"] = "El articulo se guardó correctamente";
            } else {
                $res["mensaje"] = "No se pudo guardar El articulo. Intente nuevamente";
                $res["error"] = true;
            } 
        break;
        
        case 'editarArticulo':
            $id = $_POST['id'];
            $descripcion = $_POST["descripcion"];
            $categoria = $_POST["categoria"];
            $medida = $_POST["medida"];
            
            $u = $user -> editarArticulo($id, $descripcion, $categoria, $medida);
        
            if ($u || $u == true) {
                $res["error"] = false;
                $res["mensaje"] = "El articulo se guardó correctamente";
            } else {
                $res["mensaje"] = "No se pudo guardar el articulo. Intente nuevamente";
                $res["error"] = true;
            } 

        break;   

    }
    echo json_encode($res);

?>