<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/src/Exception.php';
require 'mail/src/PHPMailer.php';
require 'mail/src/SMTP.php';

$mail = new PHPMailer(true); 

// Passing `true` enables exceptions
$datos = array();
if (!isset($_POST['name']) || $_POST['name'] == "" &&
    !isset($_POST['personasConfirmadas']) || $_POST['personasConfirmadas'] == "" &&
    !isset($_POST['message']) || $_POST['message'] == ""
    ) {
    $datos['mensaje'] = "error";
    echo json_encode($datos);
} else {


try {
    //Server settings
    $mail->SMTPDebug = 0;                                   // Enable verbose debug output
    $mail->isSMTP();                                        // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                         // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                 // Enable SMTP authentication
    $mail->Username = 'invite.invitacion@gmail.com';    // SMTP username
    $mail->Password = '4739eerr';                           // SMTP password
    $mail->SetFrom('invite.invitacion@gmail.com','Invite');
    $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                      // TCP port to connect to

    //Recipients
    $mail->setFrom('invite.invitacion@gmail.comm', 'Invite');
    $mail->addAddress('dulcesisabella@hotmail.com', 'Rocio y Martin');     // Add a recipient

    //Attachments
    //$mail->AddAttachment($_FILES['attachFile']['tmp_name'],$_FILES['attachFile']['name']); 

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Nueva confirmación de invitado';
    $mail->Body     = 'Felicitaciones, hay una nueva confirmaci&oacute;n para tu boda!<br><br>';
    $mail->Body    .='<b>Nombre:</b> ' . $_POST['name'] . '<br>';
    $mail->Body    .= '<b>Cantidad de personas confirmadas:</b> ' . $_POST['personasConfirmadas'].'<br>';
    
    if (isset($_POST['phone']) || $_POST['phone'] != ''){
        $mail->Body    .= '<b>Tel&eacute;fono:</b> ' . $_POST['phone'].'<br>';
    }
    
    $mail->Body    .= '<b>Mensaje:</b><br><br>' . $_POST['message'].'<br>';
    $mail->AltBody = $_POST['nombre'] . ' ir&oacute; a tu fiesta!!</b>';

    $mail->send();

    $datos['mensaje'] = "ok";

    echo json_encode($datos);
    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
}