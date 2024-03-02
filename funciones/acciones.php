<?php
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;
    // require "../src/Exception.php";
    // require "../src/PHPMailer.php";
    // require "../src/SMTP.php";
    require("../conexion/conexion.php");
    $user = new ApptivaDB();

    $accion = "mostrar";
    $res = array("error" => false);
    // $archivoPdf = null;
    
    if (isset($_GET["accion"])) {
        $accion = $_GET["accion"];
    }


    switch ($accion) {


        case 'getPedidos':
            $u = $user -> getPedidos();

            if ($u || $u == []) { 
                $res["pedidos"] = $u;
                $res["mensaje"] = "La consulta se realizó correctamente";
            } else {
                $res["u"] = $u;
                $res["mensaje"] = "Hubo un error al recuperar la información. Por favor recargue la página.";
                $res["error"] = true;
            } 

        break;

        case 'getResidencias':
            $u = $user -> getResidencias();

            if ($u || $u == []) { 
                $res["residencias"] = $u;
                $res["mensaje"] = "La consulta se realizó correctamente";
            } else {
                $res["mensaje"] = "Hubo un error al recuperar la información. Por favor recargue la página.";
                $res["error"] = true;
            } 

        break;

    //     case 'guardarPedido':          
    //         $nombreSiPueden     = $_POST["nombreSiPueden"]; 
    //         $nombreVoluntario   = $_POST["nombreVoluntario"]; 
    //         $direccionEnvio     = $_POST["direccionEnvio"]; 
    //         $ciudad             = $_POST["ciudad"];  
    //         $provincia          = $_POST["provincia"]; 
    //         $codigoPostal       = $_POST["codigoPostal"];
    //         $telefono           = $_POST["telefono"];
    //         $fecha              = $_POST["fecha"];
    //         $pedido             = $_POST["pedido"];
    //         $destino            = $_POST["destino"];

    //         date_default_timezone_set('America/Argentina/Cordoba');
    //         $date = date("Y-m-d H:i:s");

    //         $data = "'" . $date . "', '" . $direccionEnvio . "', '" . $ciudad . "', '" . $provincia . "', '" . $codigoPostal . "', '" . $telefono . "', '" . $pedido . "', '" . $nombreVoluntario . "', '" . $nombreSiPueden . "', '" . $destino . "'";
    //         // local:
    //         $u = $user -> insertar("sipueden", $data);
    //         // prod
    //         // $u = $user -> guardarPedido("sipueden", $data);
         
    //         if ($u == false) { 
    //             $res["mensaje"] = "El pedido no pudo realizarse. Intente nuevamente";
    //             $res["error"] = true;
                          
    //         } else {   
    //             $res["mensaje"] = $u;
    //             $res["error"] = false;
    //         }

    //     break;

    //     case 'enviarMail' :
    //         $nombreSiPueden     = $_POST["nombreSiPueden"]; 
    //         $ciudad             = $_POST["ciudad"];  
    //         $provincia          = $_POST["provincia"]; 
    //         $fecha              = $_POST["fecha"];
    //         $archivoPdf = $_FILES['archivoPdf']['tmp_name'];
    //         $nombreArchivo = $_FILES['archivoPdf']['name'];
    //         $mail               = $_POST["mail"];
    //         date_default_timezone_set('America/Argentina/Cordoba');
    //         $date = date("Y-m-d H:i:s");

    //         try {
    //             $nombreSiPueden = mb_convert_encoding($nombreSiPueden, 'UTF-8', 'ISO-8859-1');
    //             $ciudad = mb_convert_encoding($ciudad, 'UTF-8', 'ISO-8859-1');
    //             $provincia = mb_convert_encoding($provincia, 'UTF-8', 'ISO-8859-1');
    //             // CREO LA INSTANCIA
    //             $phpmailer = new PHPMailer();
                                            
    //             // AUTENTICACION SMTP
    //             $phpmailer->IsSMTP(); // use SMTP
    //             $phpmailer->SMTPAuth = true;
    //             $phpmailer->Host = "smtp.office365.com"; // GMail
    //             $phpmailer->Port = 587;
    //             $phpmailer->AddCustomHeader("Content-Type: text/html; charset=UTF-8");

    //             $email_user = "pedidosresidencias@hotmail.com";
    //             $email_password = "pedidos.1379";
    //             $phpmailer->SMTPSecure = 'STARTTLS';
    //             // ———- datos de la cuenta de Gmail ——————————-
    //             $phpmailer->Username = $email_user;
    //             $phpmailer->Password = $email_password; 


    //             $from_name = "Si Pueden (No responder este correo)";
    //             $phpmailer->setFrom($phpmailer->Username, $from_name);
    //             $address_to = $mail;
    //             $phpmailer->AddAddress($address_to); // recipients email
    //             $phpmailer->AddBCC('marcos_uran@hotmail.com');

    //             // CONTENIDO
    //             $phpmailer->IsHTML(true);
    //             $the_subject = "Nuevo pedido de " . utf8_decode($nombreSiPueden);
                
    //             $phpmailer->Subject = $the_subject;	

    //             $phpmailer->Body .="<p><b>NO RESPONDER ESTE CORREO</b></p>";
    //             $phpmailer->Body .="<p>Nuevo pedido de: </p>" . utf8_decode($nombreSiPueden) . " - ";
               
    //             $phpmailer->Body .= utf8_decode($ciudad) . ", " . utf8_decode($provincia);
    //             $phpmailer->Body .= "<p>Fecha: " . $fecha ."</p>";

    //             // Leer los datos del archivo PDF
    //             $pdfData = file_get_contents($archivoPdf);
    //             // Adjuntar los datos del archivo al correo electrónico
    //             $phpmailer->addAttachment($archivoPdf, $nombreArchivo);
                
    //             $phpmailer->CharSet = 'UTF-8';
    //             $phpmailer->Encoding = 'base64';
            
    //             if(!$phpmailer->send()){
    //                         // $res = array("error" => true);
    //                 $res["mensaje"] = "Tu pedido se guardó pero hubo un error al enviar el mail, presioná reintentar. Si el error persiste por favor avisanos!";
    //                 $res["error"] = true;
    //             } else {
    //                 $res = array("error" => false);
    //             }
              
    //         } catch (Exception $e) {
    //             $res["mensaje"] = "Hubo un error y el pedido no se pudo generar. Por favor intentalo nuevamente.";
    //             $res["error"] = true;
    //         }
    //     break;

    //     # code...
    //     break;
    }


    echo json_encode($res);
?>