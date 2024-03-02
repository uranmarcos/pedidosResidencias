<?php
    session_start();

    $accion = "mostrar";
    $res = array("error" => false);

    if (isset($_GET["accion"])) {
        $accion = $_GET["accion"];
    }

    $_SESSION["login"] = false;
    $_SESSION["rol"] = null;

    switch ($accion) {
        case 'login':
            $usuario    = $_POST["usuario"];
            $password   = $_POST["password"];   
            
            if ($usuario == "marcos@fundacionsi.org.ar") {
                if ($password == 30971843) {
                    header('Location: inicio.php');
                    exit;
                    // $res["mensaje"] = "OK";
                    // $res["error"] = false;
                } else {
                    $res["mensaje"] = "Contraseña Incorrecta";
                    $res["error"] = true;
                }
            } else if ($usuario == "manuel@fundacionsi.org.ar") {
                if ($password == 30971842) {
                    $res["mensaje"] = "OK";
                    $res["error"] = false;
                } else {
                    $res["mensaje"] = "Contraseña Incorrecta";
                    $res["error"] = true;
                }
            } else if ($usuario == "residencias@fundacionsi.org.ar") {
                if ($password == 30712506829) {
                    $res["mensaje"] = "OK";
                    $res["error"] = false;
                } else {
                    $res["mensaje"] = "Contraseña Incorrecta";
                    $res["error"] = true;
                }
            } else {
                $res["mensaje"] = "Usuario Inexistente";
                $res["error"] = true;
            }
        break;

        default:
            # code...
            break;
    }

    echo json_encode($res);
?>