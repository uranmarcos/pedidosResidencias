<?php
// variables de sesion
$sede = $_SESSION["sede"];
$casa = $_SESSION["casa"];
$idUser = $_SESSION["id"];

// variables de pedido
$pedidoGuardado = false;
$pedidoEnviado = false;
$pedidoActualizado = false;
date_default_timezone_set('America/Argentina/Cordoba');
$date = date("Y-m-d H:i:s");
// variables de alertas
$alertErrorConexion= "hide";

// variables de filtros
$productosAsc = "hide";
$productosDesc= "show";
$categoriaAsc = "show";
$categoriaDesc= "hide";

// CONSULTA DE PRODUCTOS DISPONIBLES A BASE DE DATOS
$consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
    INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE A.habilitado = 1 ORDER BY descripcion ASC");
try {
    $consultaProductos->execute();
} catch (\Throwable $th) {
    $alertErrorConexion= "show";
}
$productos = $consultaProductos -> fetchAll(PDO::FETCH_ASSOC);
    
// CONSULTA DE CATEGORIAS DISPONIBLES A BASE DE DATOS PARA EL SELECT
$consultaCategorias = $baseDeDatos ->prepare("SELECT * FROM categorias");
try {
    $consultaCategorias->execute();
} catch (\Throwable $th) {
    $alertErrorConexion= "show";
}
$categorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);  
    
// START FUNCIONES SORT TABLA
// REACOMODO PRODUCTOS POR DESCRIPCION EN ORDEN ASCENDENTE
    if(isset($_POST["productoAsc"])){
        $cat = strtolower($_POST["categoria"]);
        $productosAsc = "hide";
        $productosDesc= "show";
        if($cat == "todos"){
            $consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
                INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE A.habilitado = 1 ORDER BY descripcion ASC");    
        }else{
            $consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
                INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE C.descripcion='$cat' AND A.habilitado = 1 ORDER BY descripcion DESC");
        }
        try {
            $consultaProductos->execute();
        } catch (\Throwable $th) {
            $alertErrorConexion= "show";
        }
        $productos = $consultaProductos -> fetchAll(PDO::FETCH_ASSOC);
    }
// REACOMODO PRODUCTOS POR DESCRIPCION EN ORDEN DESCENDENTE
    if(isset($_POST["productoDesc"])){
        $cat = strtolower($_POST["categoria"]);
        $productosAsc = "show";
        $productosDesc= "hide";
        if($cat == "todos"){
            $consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
                INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE A.habilitado = 1 ORDER BY descripcion DESC");    
        }else{
            $consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
                INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE C.descripcion='$cat' AND WHERE A.habilitado = 1 ORDER BY descripcion DESC");
        }
        try {
            $consultaProductos->execute();
        } catch (\Throwable $th) {
            $alertErrorConexion= "show";
        }
        $productos = $consultaProductos -> fetchAll(PDO::FETCH_ASSOC);
    }
// REACOMODO PRODUCTOS POR CATEGORIA EN ORDEN ASCENDENTE
    if(isset($_POST["categoriaAsc"])){
        $cat = strtolower($_POST["categoria"]);
        if($cat == "todos"){
            $consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
                INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE A.habilitado = 1 ORDER BY categoria ASC, descripcion ASC");   
        }else{
            $consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
                INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE C.descripcion='$cat' AND A.habilitado = 1 ORDER BY categoria ASC, descripcion ASC");  
        }
        $categoriaAsc = "hide";
        $categoriaDesc= "show";
        try {
            $consultaProductos->execute();
        } catch (\Throwable $th) {
            $alertErrorConexion= "show";
        }
        $productos = $consultaProductos -> fetchAll(PDO::FETCH_ASSOC);
    }
// REACOMODO PRODUCTOS POR CATEGORIA EN ORDEN DESCENDENTE
    if(isset($_POST["categoriaDesc"])){
        $cat = strtolower($_POST["categoria"]);
        if($cat == "todos"){
            $consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
                INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE A.habilitado = 1 ORDER BY categoria DESC, descripcion ASC");   
        }else{
            $consultaProductos = $baseDeDatos ->prepare("SELECT A.id, A.descripcion, M.descripcion medida, C.descripcion categoria  FROM articulos A 
                INNER JOIN medidas M on A.medida = M.id INNER JOIN categorias C on A.categoria = C.id WHERE C.descripcion='$cat' AND A.habilitado = 1 ORDER BY categoria DESC, descripcion ASC");  
        }
        $categoriaAsc = "show";
        $categoriaDesc= "hide";
        try {
            $consultaProductos->execute();
        } catch (\Throwable $th) {
            $alertErrorConexion= "show";
        }
        $productos = $consultaProductos -> fetchAll(PDO::FETCH_ASSOC);
    }
// END FUNCIONES SORT TABLA

    