<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {                                   
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'eduardocostacarvalho11@gmail.com';                     
    $mail->Password   = 'umzu ffxw plxl xhmy';                               
    $mail->SMTPSecure = 'tls';            
    $mail->Port       = 587;                                 

    $mail->setFrom('eduardocostacarvalho11@gmail.com','Twitter Clone');
    $mail->addAddress($_POST['email']);
    
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->Subject = 'Redefinição de Senha';
    $mail->Body = '<span>Para trocar sua senha, clique <a href="http://localhost:8080/nova_senha?id='.$id.'">aqui</a></span>';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>