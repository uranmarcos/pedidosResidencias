<?php
$idUsuarioLogueado = $_SESSION["id"];
$alertErrorConexion = "hide";
$alertConfirmacion = "hide";
$mensajeAlertConfirmacion="";
$mensajeAlertError="";
// ACCION CREAR SEDE
if(isset($_POST["crearSede"])){
    $provincia = $_POST['provinciaCreacion'];
    $sede = $_POST['ciudadCreacion'];
    $casas = $_POST['casasCreacion'];
    date_default_timezone_set('America/Argentina/Cordoba');
    $date = date("Y-m-d h:i:s");
    $crearSede = false;
    $consultarSede = $baseDeDatos ->prepare("SELECT count(*) from sedes WHERE provincia = '$provincia' AND localidad = '$sede'");
    try{
        $consultarSede->execute();
        $sedeExistente = $consultarSede -> fetchAll(PDO::FETCH_ASSOC);
        
        $cantidad = $sedeExistente[0]["count(*)"];
        if($cantidad == 0 ){
            $crearSede = true;
        } else {
            $alertErrorConexion= "show";
            $mensajeAlertError="La sede que desea crear ya existe.";    
        }
    } catch (\Throwable $th) {
        $alertErrorConexion= "show";
        $mensajeAlertError="Hubo un error de conexión. Por favor intente nuevamente.";
    }

    if($crearSede) {
        $insertSede = $baseDeDatos ->prepare("INSERT into sedes VALUES(default, '$provincia', '$sede', '$casas', '$date', '$date', '$idUsuarioLogueado')");
        try{
            $insertSede->execute();
            $alertConfirmacion = "show";
            $mensajeAlertConfirmacion="La sede se creó correctamente";
        } catch (\Throwable $th) {
            $alertErrorConexion= "show";
            $mensajeAlertError="Hubo un error de conexión. Por favor intente nuevamente.";
        }
    }
}




// ACCION EDITAR SEDE
if (isset($_POST["editarSede"])){
    $id = $_POST["idSedeEdicion"];
    $casas = $_POST["casasEdicion"];
    date_default_timezone_set('America/Argentina/Cordoba');
    $date = date("Y-m-d H:i:s");
    $consulta = $baseDeDatos ->prepare("UPDATE sedes SET modified = '$date', casas = '$casas', userId = '$idUsuarioLogueado' WHERE id = '$id'");
    try {
        $consulta->execute();
        $alertConfirmacion = "show";
        $mensajeAlertConfirmacion="La sede se modificó correctamente";
    } catch (\Throwable $th) {
        $alertErrorConexion= "show";
        $mensajeAlertConfirmacion="La sede se eliminó correctamente";
    }
}
// ACCION ELIMINAR SEDE
if(isset($_POST["eliminarSede"])){
    $id = $_POST["idSedeEliminar"];
    $consultaValidacion = $baseDeDatos -> prepare("SELECT count(*) from agentes WHERE sede = '$id'");
    $consulta = $baseDeDatos ->prepare("DELETE from sedes WHERE id = '$id'");
    try {
        $consultaValidacion->execute();
        $validacion = $consultaValidacion -> fetchAll(PDO::FETCH_ASSOC);
        $cantidad = $validacion[0]["count(*)"];
        if($cantidad > 0 ){
            $alertErrorConexion= "show";
            $mensajeAlertError = "La sede no puede eliminarse ya que existen usuarios pertenecientes a la misma. <br> Modifique primero los usuarios y luego elimine la sede.";
        } else {
            try {
                $consulta->execute();
                $alertConfirmacion = "show";
                $mensajeAlertConfirmacion="La sede se eliminó correctamente";
            } catch (\Throwable $th) {
                $alertErrorConexion= "show";
                $mensajeAlertError = "Hubo un error de conexión. <br> Por favor intente nuevamente";
            }
        }
    } catch (\Throwable $th) {
        $alertErrorConexion= "show";
        $mensajeAlertError = "Hubo un error de conexión. <br> Por favor intente nuevamente";
    }
}

// CONSULTA LISTADO DE SEDES
$consultaSedes = $baseDeDatos ->prepare("SELECT * FROM sedes");
try {
    $consultaSedes->execute();
} catch (\Throwable $th) {
    $alertErrorConexion= "show";
    $mensajeAlertError = "Hubo un error de conexión. <br> Por favor intente nuevamente";
}
$sedes = $consultaSedes -> fetchAll(PDO::FETCH_ASSOC);
$noHayDatos = "show";
$hayDatos = "hide";
if(sizeof($sedes) != 0) {
    $noHayDatos = "hide";
    $hayDatos = "show";
}