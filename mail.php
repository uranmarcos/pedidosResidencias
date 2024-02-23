<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "src/Exception.php";
require "src/PHPMailer.php";
require "src/SMTP.php";
// $email_user = "pedidosresidenciassi@gmail.com";
// $email_password = "PEdiDOS.9731";

$email_user = "pedidosresidencias@hotmail.com";
$email_password = "pedidos.1379";

//$email_password = "PEdiDOS.973";
$the_subject = "Nuevo pedido de ". utf8_decode($sede[0]["provincia"]) . ", " .utf8_decode($sede[0]["localidad"]);
//$address_to = "marcos_uran@hotmail.com";
$address_to = "manuel@fundacionsi.org.ar";
$from_name = "Residencia: " . utf8_decode($sede[0]["provincia"]) . ", " .utf8_decode($sede[0]["localidad"]);
$phpmailer = new PHPMailer();
// ———- datos de la cuenta de Gmail ——————————-
$phpmailer->Username = $email_user;
$phpmailer->Password = $email_password; 
//———————————————————————–
// $phpmailer->SMTPDebug = 1;
// $phpmailer->SMTPSecure = 'ssl';

//$phpmailer->Host = "smtp.gmail.com"; // GMail
//$phpmailer->SMTPSecure = 'tls'; 

$phpmailer->Host = "smtp.office365.com"; // GMail
$phpmailer->SMTPSecure = 'STARTTLS';

// $phpmailer->Port = 465;
//agregado por mi linea de abajo
// $phpmailer->Mailer = "smtp";
$phpmailer->Port = 587;
$phpmailer->IsSMTP(); // use SMTP
$phpmailer->SMTPAuth = true;
$phpmailer->setFrom($phpmailer->Username,$from_name);
$phpmailer->AddAddress($address_to); // recipients email
$phpmailer->Subject = $the_subject;	
// $phpmailer->Body .=$_SESSION["pedidoMail"];
$phpmailer->Body .="<p>Nuevo pedido de " . utf8_decode($sede[0]["provincia"]) . ", " .utf8_decode($sede[0]["localidad"] ."</p>");
$phpmailer->Body .="<p>Casa: " . $pedido[0]["casa"] . "</p>";
$phpmailer->Body .="<p>Voluntario: " . utf8_decode($pedido[0]["nombre"]) . " " . utf8_decode($pedido[0]["segundoNombre"]) . " " . utf8_decode($pedido[0]["apellido"]) . "</p>";
//$mail->AddAttachment($archivo); // attachment
// $phpmailer->Body .= "<p>Mensaje personalizado</p>";
$phpmailer->Body .= "<p>Fecha: " . $newDate ."</p>";
$phpmailer->IsHTML(true);
// $phpmailer->AddAttachment($pdf); // attachment
$phpmailer->AddStringAttachment($archivoPdf, utf8_decode($sede[0]["provincia"]) . ", " .utf8_decode($sede[0]["localidad"]) . '.pdf','base64');
try {
    $phpmailer->smtpConnect([
            'ssl' => [
                 'verify_peer' => false,
                 'verify_peer_name' => false,
                 'allow_self_signed' => true
             ]
         ]);
} catch (\Throwable $th) {
    $_SESSION["errorMail"] = true;
    if ($tipoMail == "reenvio") {
        echo "<script>location.href='pedidos.php';</script>";    
    } else {
        echo "<script>location.href='iniciarPedido.php';</script>";
    }
    die;
}
if(!$phpmailer->send()) { 
    $_SESSION["errorMail"] = true;
    if ($tipoMail == "reenvio") {
        echo "<script>location.href='pedidos.php';</script>";    
    } else {
        echo "<script>location.href='iniciarPedido.php';</script>";
    }
    die;
}
