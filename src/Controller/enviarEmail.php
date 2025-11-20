<?php
require_once('phpMailer/PHPMailer.php');
require_once('phpMailer/SMTP.php');
require_once('phpMailer/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {

    // dados fixos
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'Supermercado10@gmail.com';
    $mail->Password = 'SENHA_DO_APP_FIXA';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom('Supermercado10@gmail.com', 'Supermercado');

    // dados automaticos (irei alterar algumas partes desse código)
    $destinatario = $_POST['email'];
    $nome = $_POST['nome'];
    $mensagem = $_POST['mensagem'];

    $mail->addAddress($destinatario);

    $mail->isHTML(true);
    $mail->Subject = "Contato de $nome";
    $mail->Body    = "
        <h2>Novo contato do site</h2>
        <p><strong>Nome:</strong> $nome</p>
        <p><strong>Email:</strong> $destinatario</p>
        <p><strong>Mensagem:</strong><br>$mensagem</p>
    ";

    $mail->send();
    echo "Email enviado automaticamente.";

} catch (Exception $e) {
    echo "Erro: {$mail->ErrorInfo}";
}
