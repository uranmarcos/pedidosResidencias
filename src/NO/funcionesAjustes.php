<?php
$id = $_SESSION["id"];
$alertErrorConexion = "hide";
$alertConfirmacion = "hide";
$mensajeAlertError = "";
$mensajeAlertConfirmacion = "";

if (isset($_POST["changePassword"])) {
    $pass = $_POST["inputPassword"];
    $newPass = password_hash($_POST["inputNewPassword"], PASSWORD_DEFAULT);
    $consulta = $baseDeDatos ->prepare("SELECT password FROM agentes A WHERE A.id = '$id'");
    try {
        $consulta->execute();
        $password = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        if(password_verify($pass, $password[0]["password"])) {
            $update = $baseDeDatos ->prepare("UPDATE agentes SET password = '$newPass' WHERE id = '$id'");
            try {
                $update->execute();
                $mensajeAlertConfirmacion = "¡La contraseña se modificó correctamente!";
                $alertConfirmacion = "show";
            } catch (\Throwable $th) {
                $mensajeAlertError = "Hubo un error de conexión. Por favor realizá el cambio nuevamente";
                $alertErrorConexion = "show";
            }
        } else{
            $mensajeAlertError = "La contraseña actual que ingresó no es correcta";
            $alertErrorConexion = "show";
        }
    } catch (\Throwable $th) {  
        $mensajeAlertError = "Hubo un error de conexión. Por favor intente nuevamente";
        $alertErrorConexion = "show";
    }
};

?>