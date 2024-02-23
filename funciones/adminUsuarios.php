<?php

$alertError = "hide";
$mensajeAlertError = "";
$alertConfirmacion = "hide";
$mensajeAlertConfirmacion="";
$idUsuarioLogueado = $_SESSION["id"];
$rol = $_SESSION["rol"];
$roles = [
    [ "value"=> "admin", "descripcion"=> "Admin"],
    ["value"=> "general", "descripcion"=> "General"],
    [ "value"=> "stock", "descripcion"=> "Stock"]
];

if($rol == "general") {
    $roles = [
        [ "value"=> "stock", "descripcion"=> "Stock"],
    ];
}


// ACCION CREAR USUARIO
if(isset($_POST["crearUsuario"])){
    $nombre = $_POST['primerNombreCreacion'];
    $segundoNombre = $_POST['segundoNombreCreacion']; 
    $apellido = $_POST['apellidoCreacion'];
    $dni = $_POST['dniCreacion'];
    $password = password_hash($dni, PASSWORD_DEFAULT);
    $rolCreacion = $_POST["rolCreacion"];
    $mail = $_POST["mailCreacion"];
    $sede = $_POST["sedeCreacion"];
    $casa = $_POST["casaCreacion"];
     
    date_default_timezone_set('America/Argentina/Cordoba');
    $date = date("Y-m-d H:i:s");
    $insertUsuario = $baseDeDatos ->prepare("INSERT into agentes VALUES(default, '$dni', '$nombre', '$segundoNombre', '$apellido', '$mail', '$rolCreacion', '$password', '$sede', '$casa', '$date', '$date', '$idUsuarioLogueado')");
    $consultaDni = $baseDeDatos ->prepare("SELECT id from agentes WHERE dni = $dni");
    $consultaMail = $baseDeDatos ->prepare("SELECT id from agentes WHERE mail = '$mail'");
    $crearUsuario = false;
    try{
        $consultaDni->execute();
        $consultaMail->execute();
        $dniExistente = $consultaDni -> fetchAll(PDO::FETCH_ASSOC);
        $mailExistente = $consultaMail -> fetchAll(PDO::FETCH_ASSOC);
        if( count($dniExistente) == 0 && count($mailExistente) == 0) {
            $crearUsuario = true;
        } else if (count($dniExistente) != 0 && count($mailExistente) == 0) {
            $alertError= "show";
            $mensajeAlertError="El dni ingresado ya está registrado";
        } else if( count($dniExistente) == 0 && count($mailExistente) != 0) {
            $alertError= "show";
            $mensajeAlertError="El mail ingresado ya está registrado";
        } else {
            $alertError= "show";
            $mensajeAlertError="El dni y el mail ingresados ya están registrados";
        }
    } catch (\Throwable $th) {
        $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
        $alertError= "show";
    }
    if ($crearUsuario) {
        try{
            $insertUsuario->execute();
            $alertConfirmacion = "show";
            $mensajeAlertConfirmacion="El usuario se creó correctamente";
        } catch (\Throwable $th) {
            $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
            $alertError= "show";
        }
    }
}

// ACCION EDITAR USUARIO
if (isset($_POST["editarUsuario"])){
    $id = $_POST["idUsuarioEdicion"];
    $primerNombre = $_POST["primerNombreEdicion"];
    $segundoNombre = $_POST["segundoNombreEdicion"];
    $apellido = $_POST["apellidoEdicion"];
    $rolEdicion = $_POST["rolEdicion"];
    $mail = $_POST["mailEdicion"];
    $sede = $_POST["sedeEdicion"];
    $casa = $_POST["casaEdicion"];
    date_default_timezone_set('America/Argentina/Cordoba');
    $date = date("Y-m-d H:i:s");
    $editarUsuario = false;

    $consultaMail = $baseDeDatos ->prepare("SELECT id from agentes WHERE mail = '$mail'");
    try{
        $consultaMail->execute();
        $mailExistente = $consultaMail -> fetchAll(PDO::FETCH_ASSOC);
        if( count($mailExistente) == 0) {
            $editarUsuario = true;
        } else {
            $alertError= "show";
            $mensajeAlertError="El mail ingresado ya está registrado";
        }
    } catch (\Throwable $th) {
        $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
        $alertError= "show";
    }

    if ($editarUsuario) {
        $consulta = $baseDeDatos ->prepare("UPDATE agentes SET nombre = '$primerNombre', segundoNombre = '$segundoNombre',
        apellido = '$apellido', rol = '$rolEdicion', mail = '$mail', sede = '$sede', casa = '$casa', modified = '$date', idUser = '$idUsuarioLogueado' WHERE id = '$id'");
        try {
            $consulta->execute();
            $alertConfirmacion = "show";
            $mensajeAlertConfirmacion="El usuario se modificó correctamente";
        } catch (\Throwable $th) {
            $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
            $alertError= "show";
        }
    }
}

// ACCION ELIMINAR USUARIO
if(isset($_POST["eliminarUsuario"])){
    $id = $_POST["idUsuarioEliminar"];
    $consulta = $baseDeDatos ->prepare("DELETE from agentes WHERE id = '$id'");
    try {
        $consulta->execute();
        $alertConfirmacion = "show";
        $mensajeAlertConfirmacion="El usuario se eliminó correctamente";
    } catch (\Throwable $th) {
        $mensajeAlertError = "Hubo un error de conexión. Por favor intentalo nuevamente";
        $alertError= "show";
    }
}

// ACCION RESET PASSWORD
if (isset($_POST["resetPassword"])){
    $id = $_POST["idUsuarioResetPassword"];
    $pass = password_hash($_POST["dniUsuarioResetPassword"], PASSWORD_DEFAULT);
    $reset = $baseDeDatos ->prepare("UPDATE agentes SET password = '$pass', idUser = '$idUsuarioLogueado' WHERE id = '$id'"); 
    try {
        $reset->execute();
        $mensajeAlertConfirmacion = "El reseteo de contraseña se realizó correctamente.";
        $alertConfirmacion= "show";
    } catch (\Throwable $th) {
        $mensajeAlertError = "Hubo un error de conexión. Por favor intentá nuevamente";
        $alertError= "show";
    }
}

// CONSULTAS INICIALES LISTADO DE ARTICULOS, MEDIDAS Y CATEGORIAS
$consultaUsuarios = $baseDeDatos ->prepare("SELECT U.id, U.nombre, U.segundoNombre, U.apellido, U.mail, U.dni, U.sede idSede, U.rol, S.provincia 'provincia', S.localidad 'sede', U.casa FROM agentes U INNER JOIN sedes S ON U.sede = S.id");
$consultaSedes = $baseDeDatos ->prepare("SELECT * FROM sedes");
try {
    $consultaUsuarios->execute();
    $consultaSedes->execute();
} catch (\Throwable $th) {
    $mensajeAlertError = "Hubo un error de conexión. Por favor actualizá la página";
    $alertError= "show";
}
$usuarios = $consultaUsuarios -> fetchAll(PDO::FETCH_ASSOC);
$sedes = $consultaSedes -> fetchAll(PDO::FETCH_ASSOC);
$noHayDatos = "show";
$hayDatos = "hide";
if(sizeof($usuarios) != 0) {
    $noHayDatos = "hide";
    $hayDatos = "show";
}
 
    

