<?php
    session_start();
    require("../conexion/login.php");
    $user = new ApptivaDB();
  
    $accion = "mostrar";
    $res = array("error" => false);
    // $archivoPdf = null;
      
    if (isset($_GET["accion"])) {
        $accion = $_GET["accion"];
    }

    // $_SESSION["login"] = false;
    // $_SESSION["rol"] = null;
    // $_SESSION["login"] = true;
    // $_SESSION['login_time'] = time();
    //                     $_SESSION["usuario"] = $u[0]["provincia"] . ", " . $u[0]["localidad"];
    //                     $_SESSION["rol"] = $u[0]["rol"];


    switch ($accion) {
        case 'login':
            $usuario    = $_POST["usuario"];
            $password   = $_POST["password"];
            
            $u = $user -> login($usuario, $password);
            
            if ($u !== false) {
                if (!empty($u)) {
                    // Verificar la contraseña
                    if (password_verify($password, $u[0]['pass'])) {
                        // Inicio de sesión exitoso
                        $res["mensaje"] = "OK";
                        $res["error"] = false;
                        $_SESSION["login"] = true;
                        $_SESSION['login_time'] = time();
                        $_SESSION["provincia"] = $u[0]["provincia"];
                        $_SESSION["localidad"] = $u[0]["localidad"];
                        $_SESSION["usuario"] = $u[0]["usuario"];
                        $_SESSION["rol"] = $u[0]["rol"];
                        $_SESSION["idUsuario"] = $u[0]["id"];
                    } else {
                        // Contraseña incorrecta
                        $res["mensaje"] = "Datos Incorrectos";
                        $res["error"] = true;
                    }
                } else {
                    // Usuario inexistente
                    $res["mensaje"] = "Usuario inexistente";
                    $res["error"] = true;
                }
            } else {
                // Error al realizar la consulta
                $res["mensaje"] = "Hubo un error, intente nuevamente";
                $res["error"] = true;
            }

            // if ($usuario == "marcos@fundacionsi.org.ar") {
            //     if ($password == 30971843) {
            //         header('Location: inicio.php');
            //         exit;
            //         // $res["mensaje"] = "OK";
            //         // $res["error"] = false;
            //     } else {
            //         $res["mensaje"] = "Contraseña Incorrecta";
            //         $res["error"] = true;
            //     }
            // } else if ($usuario == "manuel@fundacionsi.org.ar") {
            //     if ($password == 30971842) {
            //         $res["mensaje"] = "OK";
            //         $res["error"] = false;
            //     } else {
            //         $res["mensaje"] = "Contraseña Incorrecta";
            //         $res["error"] = true;
            //     }
            // } else if ($usuario == "residencias@fundacionsi.org.ar") {
            //     if ($password == 30712506829) {
            //         $res["mensaje"] = "OK";
            //         $res["error"] = false;
            //     } else {
            //         $res["mensaje"] = "Contraseña Incorrecta";
            //         $res["error"] = true;
            //     }
            // } else {
            //     $res["mensaje"] = "Usuario Inexistente";
            //     $res["error"] = true;
            // }
        break;

        case 'logout':
            try {
                session_destroy();
                $res["mensaje"] = "OK";
                $res["error"] = false;
            } catch (\Throwable $th) {
                $res["mensaje"] = "Hubo un error. Intente nuevamente";
                $res["error"] = false;
            }
        break;

        default:
            # code...
            break;
    }

    echo json_encode($res);
?>