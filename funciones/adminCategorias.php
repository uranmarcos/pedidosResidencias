<?php
$alertError = "hide";
$mensajeAlertError="";
$alertConfirmacion = "hide";
$mensajeAlertConfirmacion="";
$idUsuarioLogueado = $_SESSION["id"];
// START ACCION CREAR CATEGORIA
if(isset($_POST["crearCategoria"])){
    $categoria = $_POST['descripcionCreacion'];
    date_default_timezone_set('America/Argentina/Cordoba');
    $date = date("Y-m-d H:i:s");
    $insertCategoria = $baseDeDatos ->prepare("INSERT into categorias VALUES(default, '$categoria', '$date', '$date', '$idUsuarioLogueado')");
    try{
        $insertCategoria->execute();
        $alertConfirmacion = "show";
        $mensajeAlertConfirmacion="La categoria se creó correctamente";
    } catch (\Throwable $th) {
        $alertError= "show";
        $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
    }
}
// END ACCION CREAR CATEGORIA

// ACCION EDITAR CATEGORIA
if (isset($_POST["editarCategoria"])){
    $id = $_POST["idCategoriaEdicion"];
    $descripcion = $_POST["descripcionEdicion"];
    date_default_timezone_set('America/Argentina/Cordoba');
    $date = date("Y-m-d H:i:s");
    $consulta = $baseDeDatos ->prepare("UPDATE categorias SET modified = '$date', descripcion = '$descripcion', userId = '$idUsuarioLogueado' WHERE id = '$id'");
    try {
        $consulta->execute();
        $alertConfirmacion = "show";
        $mensajeAlertConfirmacion="La categoria se modificó correctamente";
    } catch (\Throwable $th) {
        $alertError= "show";
        $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
    }
}
// START ACCION ELIMINAR CATEGORIA
if(isset($_POST["eliminarCategoria"])){
    $id = $_POST["idCategoriaEliminar"];
    $consultaValidacion = $baseDeDatos -> prepare("SELECT count(*) from articulos WHERE categoria = '$id'");
    $consulta = $baseDeDatos ->prepare("DELETE from categorias WHERE id = '$id'");
    
    try {
        $consultaValidacion->execute();
        $validacion = $consultaValidacion -> fetchAll(PDO::FETCH_ASSOC);
        $cantidad = $validacion[0]["count(*)"];
        if($cantidad > 0 ){
            $alertError= "show";
            $mensajeAlertError = "La categoria no puede eliminarse ya que existen articulos pertenecientes a la misma. <br> Modifique primero los articulos y luego elimine la categoria.";
        } else {
            try {
                $consulta->execute();
                $alertConfirmacion = "show";
                $mensajeAlertConfirmacion="La categoria se eliminó correctamente";
            } catch (\Throwable $th) {
                $alertError= "show";
                $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
            }
        }
    } catch (\Throwable $th) {
        $alertError= "show";
        $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
    }
}
// END ACCION ELIMINAR CATEGORIA

// CONSULTA LISTADO DE CATEGORIAS
$consultaCategorias = $baseDeDatos ->prepare("SELECT * FROM categorias");
try {
    $consultaCategorias->execute();
} catch (\Throwable $th) {
    $alertError= "show";
    $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
}
$categorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);
$noHayDatos = "show";
$hayDatos = "hide";
if(sizeof($categorias) != 0) {
    $noHayDatos = "hide";
    $hayDatos = "show";
}